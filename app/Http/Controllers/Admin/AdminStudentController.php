<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\SchoolClass;
use App\Models\Section;
use Illuminate\Validation\ValidationException;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Imports\StudentsImport;
use Maatwebsite\Excel\Facades\Excel;

class AdminStudentController extends Controller
{
    
    public function index(Request $request)
    {
        $query = Student::with(['class', 'section']);
        
        // Filter by class if selected
        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }
        
        // Filter by section if selected
        if ($request->filled('section_id')) {
            $query->where('section_id', $request->section_id);
        }
        
        $students = $query->get();
        $classes = SchoolClass::all();
        $sections = Section::with('schoolClass')->get(); // Load sections with class relationship
        
        return view('admin.student.index', compact('students', 'classes', 'sections'));
    }

    public function create()
    {
        $classes = SchoolClass::all();
        $sections = Section::all();
        return view('admin.student.create', compact('classes', 'sections'));
    }

    public function getSectionsByClass(Request $request)
{
    $sections = Section::where('class_id', $request->class_id)
        ->select('id', 'name', 'capacity', 'students_count')
        ->get();

    return response()->json($sections);
} 

public function store(Request $request)
{
    $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email|unique:students,email',
        'phone' => 'required|string|digits:10|unique:students,phone',
        // 'dob' => 'required|date', 
        'dob' => ['required', 'date', 'before:' . Carbon::now()->subYears(3)->toDateString()],
        'gender' => 'required',
        'address' => 'required|string',
        'class_id' => 'required|exists:school_classes,id',
        'section_id' => 'required|exists:sections,id',
        'roll_no' => ['required', 'integer',
                     Rule::unique('students')->where(function ($query) use ($request) {
                     return $query->where('section_id', $request->section_id);
        }),
    ],
    ]);

    DB::beginTransaction();

    try {
        // Check if section is full
        $section = Section::findOrFail($request->section_id);
        if ($section->students_count >= $section->capacity) {
            return redirect()->back()->with('error', 'Section is full. Please choose another section.');
        }

        // Create student
        Student::create($request->all());

        // Increment students_count
        $section->increment('students_count');

        DB::commit();
        return redirect()->route('students.index')->with('success', 'Student added successfully.');
    } catch (\Exception $e) {
        DB::rollback();
        return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
    }
}

// public function importForm()
// {
//     $classes = SchoolClass::all();
//     return view('admin.student.import', compact('classes'));
// }


// public function import(Request $request)
// {
//     $request->validate([
//         'file' => 'required|mimes:xlsx,csv,xls',
//     ]);

//     try {
//         Excel::import(new StudentsImport, $request->file('file'));
//         return redirect()->route('students.index')->with('success', 'Students imported successfully.');
//     } catch (\Exception $e) {
//         return back()->with('error', 'Error during import: '.$e->getMessage());
//     }
// }

public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,csv,xls',
    ]);

    try {
        Excel::import(new StudentsImport, $request->file('file'));
        return redirect()->route('students.index')->with('success', 'Students imported successfully.');
    } catch (ValidationException $e) {
        return back()->withErrors($e->errors());
    } catch (\Exception $e) {
        return back()->with('error', 'Error during import: ' . $e->getMessage());
    }
}

public function edit(Student $student) 
{
    // Get all classes
    $classes = SchoolClass::all();

    // Get sections for the student's class with remaining seat calculation
    $sections = Section::where('class_id', $student->class_id)
        ->get()
        ->map(function ($section) use ($student) {
            $usedSeats = $section->students_count;
            if ($student->section_id == $section->id) {
                $usedSeats--; // exclude this student
            }
            $section->remaining_seats = $section->capacity - $usedSeats;
            return $section;
        });

    return view('admin.student.edit', compact('student', 'classes', 'sections'));
}


    public function update(Request $request, Student $student)
{
    try {
        $messages = [
            'dob.before' => 'The student must be at least 3 years old.',
            'phone.digits' => 'The phone number must be exactly 10 digits.',
            'email.regex' => 'The email must end with .com.',
        ];

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => ['required','email','regex:/^[^@\s]+@[^@\s]+\.(com)$/i',
                         Rule::unique('students')->ignore($student->id),
            ],
            'phone' => ['required','string','digits:10',
                         Rule::unique('students')->ignore($student->id),
            ],
            'roll_no' => ['required', 'integer',
                         Rule::unique('students')
                         ->where(function ($query) use ($request) {
                         return $query->where('section_id', $request->section_id);
                         })->ignore($student->id),
            ],

            'dob' => ['required', 'date', 'before:' . Carbon::now()->subYears(3)->toDateString()],
            'gender' => 'required|string',
            'address' => 'required|string',
            'class_id' => 'required|exists:school_classes,id',
            'section_id' => 'required|exists:sections,id',
        ], $messages);

        DB::beginTransaction();

        // Check if section is changing
        $oldSectionId = $student->section_id;
        $newSectionId = $validated['section_id'];

        if ($oldSectionId != $newSectionId) {
            $newSection = Section::findOrFail($newSectionId);

            if ($newSection->students_count >= $newSection->capacity) {
                return back()->withErrors(['section_id' => 'No seats available in the selected section.'])->withInput();
            }

            // Decrease old section count
            Section::where('id', $oldSectionId)->decrement('students_count');

            // Increase new section count
            $newSection->increment('students_count');
        }

        $student->update($validated);
        DB::commit();

        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    } catch (ValidationException $e) {
        DB::rollback();
        return back()->withErrors($e->errors())->withInput();
    } catch (\Exception $e) {
        DB::rollback();
        return back()->with('error', 'Something went wrong: ' . $e->getMessage())->withInput();
    }
} 

    public function destroy(Student $student)
    {
        try {
            $student->delete();
            return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
        } catch (Exception $e) {
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

}