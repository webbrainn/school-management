<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Marks;
use App\Models\Exam;
use App\Models\Student;
use App\Models\Subject;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Grade;
use App\Imports\MarksImport;
use Maatwebsite\Excel\Facades\Excel;

class MarksController extends Controller
{

    public function create()
{
    $classes = SchoolClass::all();
    $grades = Grade::all(['grade_name', 'description', 'mark_from', 'mark_to']);

    return view('admin.marks.create', compact('classes', 'grades'));
}

public function store(Request $request)
{
    try {
        // Step 1: Fetch subject_id automatically from exam
        $exam = Exam::findOrFail($request->exam_id);
        $subject_id = $exam->subjects_id; // assuming the column is 'subjects_id'

        // Step 2: Merge subject_id into request for validation
        $request->merge([
            'subject_id' => $subject_id,
        ]);

        // Step 3: Validate (now subject_id will be auto-included)
        $request->validate([
            'class_id' => 'required|exists:school_classes,id',
            'section_id' => 'required|exists:sections,id',
            'exam_id' => 'required|exists:exams,id',
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id', // still validated
            'roll_no' => 'required|string',
            'marks_obtained' => 'required|numeric|min:0|max:100',
            'sheet_image' => 'nullable|string',
            'grade' => 'required|string',
            'term' => 'nullable|string',
            'description' => 'required|string',
            'field2' => 'nullable|string',
        ]);

        // Step 4: Prevent duplicate marks
        $existing = Marks::where('student_id', $request->student_id)
            ->where('exam_id', $request->exam_id)
            ->first();

        if ($existing) {
            return redirect()->back()
                ->withErrors(['error' => 'Marks for this student and exam already exist.'])
                ->withInput();
        }

        // Step 5: Save marks with auto-subject_id
        Marks::create($request->all());

        return redirect()->back()->with('success', 'Marks added successfully!');
    } catch (\Exception $e) {
        \Log::error('Mark store error: ' . $e->getMessage());
        return redirect()->back()->withErrors(['error' => 'Something went wrong.'])->withInput();
    }
}

public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls'  // a file must be an excel file
    ]);

    $import = new MarksImport();

    try {
        Excel::import($import, $request->file('file'));

        if (!empty($import->rowErrors)) {
            return back()->with('error', "Some rows were skipped:\n" . implode("\n", $import->rowErrors));
        }

        return back()->with('success', 'Marks imported successfully!');
    } 
    catch (\Exception $e) {
        \Log::error('Excel import error', [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        return back()->with('error', 'Failed to import marks. Check file and try again.');
    }
    
}

public function getSectionsByClass($class_id)
{
    try {
        $sections = Section::where('class_id', $class_id)->get(['id', 'name']);
        return response()->json($sections);
    } catch (\Exception $e) {
        \Log::error('Error fetching sections: ' . $e->getMessage());
        return response()->json([], 500);
    }
}

public function getStudentsBySection($section_id)
{
    try {
        $students = Student::where('section_id', $section_id)->get(['id', 'first_name', 'last_name','roll_no']);
        return response()->json($students);
    } catch (\Exception $e) {
        \Log::error('Error fetching students: ' . $e->getMessage());
        return response()->json([], 500);
    }
}

public function getExamsBySection($section_id)
{
    try {
        $exams = Exam::where('section_id', $section_id)->get(['id', 'exam_name']);
        return response()->json($exams);
    } catch (\Exception $e) {
        \Log::error('Error fetching exams: ' . $e->getMessage());
        return response()->json([], 500);
    }
}

public function getExamsBySectionAndTerm(Request $request, $section_id)
{
    try {
        $term = $request->term;
        $query = Exam::where('section_id', $section_id);

        if (!empty($term)) {
            $query->where('term', $term);
        }

        $exams = $query->get(['id', 'exam_name', 'term']);

        return response()->json($exams);
    } catch (\Exception $e) {
        \Log::error('Error fetching exams by term: ' . $e->getMessage());
        return response()->json([], 500);
    }
}

public function viewByStudent()
{
    $classes = SchoolClass::all();
    return view('admin.marks.student', compact('classes'));
}

// 
public function showMarksheet($student_id, $exam_id)
{
    $student = Student::with(['class', 'section'])->findOrFail($student_id);
    $exam = Exam::findOrFail($exam_id);

    $marks = Marks::with('subject')
        ->where('student_id', $student_id)
        ->where('exam_id', $exam_id)
        ->get();

    $totalMarks = $marks->sum('marks_obtained');
    $maxMarks = $marks->sum(function($mark) {
        return $mark->exam->max_marks ?? 0;
    });
    $percentage = $maxMarks > 0 ? round(($totalMarks / $maxMarks) * 100, 2) : 0;

    return view('admin.marks.marksheet', compact(
        'student', 'exam', 'marks', 'totalMarks', 'maxMarks', 'percentage'
    ));
}
// 

public function getStudentMarks(Request $request, $student_id)
{
    try {
        $student = Student::findOrFail($student_id);
        $query = $student->marks()->with('exam', 'subject');

        if ($request->filled('exam_id')) {
            // If exam is selected, filter by exam ID
            $query->where('exam_id', $request->exam_id);
        } elseif ($request->filled('term')) {
            // If only term is selected (no exam), filter exams by term
            $examIds = Exam::where('term', $request->term)->pluck('id');
            $query->whereIn('exam_id', $examIds);
        }

        $marks = $query->get();

        $view = view('admin.marks.student_marks', [
                'student' => $student,
                'marks' => $marks
        ])->render();

        return response()->json(['html' => $view]);
    } catch (\Exception $e) {
        \Log::error('Error in getStudentMarks: ' . $e->getMessage());
        return response()->json(['html' => '<p class="text-danger">Something went wrong while fetching marks.</p>'], 500);
    }
}

    public function show($student_id)
    {
        // $student = Student::with('marks.exam', 'marks.subject')->findOrFail($student_id);
        $student = Student::with('marks.exam')->findOrFail($student_id);
        return view('admin.marks.student', compact('student'));
    }

public function viewByClass(Request $request)
{
    $classes = SchoolClass::all();
    $selectedClass = null;
    $selectedSection = null;
    $selectedExam = null;
    $marks = collect();
    $sections = [];
    $exams = [];

    // If form submitted
    if ($request->has('class_id') || $request->has('section_id') || $request->has('term')) {

        // Validation for class, section, term
        $validated = $request->validate([
            'class_id' => 'required|exists:school_classes,id',
            'section_id' => 'required|exists:sections,id',
            'term' => 'required|string',
        ]);

        // Get selected class and section
        $selectedClass = SchoolClass::findOrFail($request->class_id);
        $selectedSection = Section::findOrFail($request->section_id);

        // Load available exams for section and term
        $exams = Exam::where('section_id', $request->section_id)
                     ->where('term', $request->term)
                     ->get();

        // Check if exam_id is selected
        if ($request->filled('exam_id')) {
            $selectedExam = Exam::findOrFail($request->exam_id);

            $marks = Marks::with(['student', 'exam'])
                ->where('class_id', $request->class_id)
                ->where('section_id', $request->section_id)
                ->where('exam_id', $request->exam_id)
                ->orderBy('student_id')
                ->get();
        } else {
            // No specific exam selected — get all marks for that class, section and term
            $examIds = $exams->pluck('id');

            $marks = Marks::with(['student', 'exam'])
                ->where('class_id', $request->class_id)
                ->where('section_id', $request->section_id)
                ->whereIn('exam_id', $examIds)
                ->orderBy('student_id')
                ->get();
        }

        // Load sections for dropdown repopulate
        $sections = Section::where('class_id', $request->class_id)->get();
    }

    return view('admin.marks.class', compact(
        'classes',
        'sections',
        'marks',
        'selectedClass',
        'selectedSection',
        'selectedExam',
        'exams'
    ));
}

public function edit($id)
{
    $mark = Marks::findOrFail($id);
    $students = Student::where('class_id', $mark->class_id)->get();
    $exams = Exam::where('section_id', $mark->section_id)->get();
    $grades = Grade::all(['grade_name', 'description', 'mark_from', 'mark_to']);

    return view('admin.marks.edit', compact('mark', 'students', 'exams','grades'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'student_id' => 'required|exists:students,id',
        'exam_id' => 'required|exists:exams,id',
        'marks_obtained' => 'required|numeric',
        'grade' => 'nullable|string|max:255',
        'term' => 'nullable|string|max:255',
        'description' => 'nullable|string|max:255',
    ]);

    $mark = Marks::findOrFail($id);

    $mark->update([
        'student_id' => $request->student_id,
        'exam_id' => $request->exam_id,
        'marks_obtained' => $request->marks_obtained,
        'grade' => $request->grade,
        'term' => $request->term,
        'description' => $request->description,
    ]);

    return redirect()->route('marks.byClass', [
        'class_id' => $mark->class_id,
        'section_id' => $mark->section_id,
        'exam_id' => $mark->exam_id
    ])->with('success', 'Marks updated successfully!');
}

public function destroy($id)
{
    $mark = Marks::findOrFail($id);
    $mark->delete();
    return redirect()->back()->with('success', 'Marks deleted successfully!');
}

public function studentMarksEdit($id)
{
    $mark = Marks::findOrFail($id);
    $students = Student::where('class_id', $mark->class_id)->get();
    $exams = Exam::where('school_classes_id', $mark->class_id)->get();
    $grades = Grade::all(['grade_name', 'description', 'mark_from', 'mark_to']);

    return view('admin.marks.student_edit', compact('mark', 'students', 'exams','grades'));
}

public function studentMarksUpdate(Request $request, $id)
{
    $request->validate([
        'student_id' => 'required|exists:students,id',
        'exam_id' => 'required|exists:exams,id',
        'marks_obtained' => 'required|numeric',
        'grade' => 'nullable|string|max:255',
        'term' => 'nullable|string|max:255',
        'description' => 'nullable|string|max:255',
    ]);

    $mark = Marks::findOrFail($id);

    $mark->update([
        'student_id' => $request->student_id,
        'exam_id' => $request->exam_id,
        'marks_obtained' => $request->marks_obtained,
        'grade' => $request->grade,
        'term' => $request->term,
        'description' => $request->description,
    ]);

    return redirect()->route('marks.byStudent')
           ->with('success', 'Marks updated successfully!');
}

public function studentMarksDestroy($id)
{
    $mark = Marks::findOrFail($id);
    $mark->delete();
    return redirect()->back()->with('success', 'Marks deleted successfully!');
}

public function studentMarksheetSelection()
{
    $classes = SchoolClass::all();
    return view('admin.marks.student_marksheet_selection', compact('classes'));
}


public function showMarksheetByTerm($student_id, $term)
{
    $student = Student::with(['class', 'section'])->findOrFail($student_id);
    
    // Get all exams for the term
    $exams = Exam::where('term', $term)
             ->where('section_id', $student->section_id)->get();
    
    // Get all marks for the student in the selected term
    $marks = Marks::with(['exam', 'subject'])
             ->where('student_id', $student_id)
             ->whereHas('exam', function($query) use ($term) {
               $query->where('term', $term);
            })->get();

    $totalMarks = $marks->sum('marks_obtained');
    $maxMarks = $marks->sum(function($mark) {
                return $mark->exam->max_marks ?? 0;
    });
    $percentage = $maxMarks > 0 ? round(($totalMarks / $maxMarks) * 100, 2) : 0;

    return view('admin.marks.marksheet_by_term', compact(
                'student', 'term', 'exams', 'marks', 'totalMarks', 'maxMarks', 'percentage'
    ));
}

public function showFullYearMarksheet($student_id)
{
    $student = Student::with(['class', 'section'])->find($student_id);
    if (!$student) {
        return redirect()->back()->withErrors('Student not found!');
    }

    // Get all exams for the student's section, grouped by term
    $exams = Exam::where('section_id', $student->section_id)
                 ->orderBy('term')
                 ->orderBy('id')
                 ->get()
                 ->groupBy('term');

    if ($exams->isEmpty()) {
        return redirect()->back()->withErrors('No exams found for this student\'s section.');
    }

    // Get all marks for the student
    $marks = Marks::where('student_id', $student_id)
                  ->with(['subject', 'exam'])
                  ->get();

    if ($marks->isEmpty()) {
        return redirect()->back()->withErrors('No marks found for this student.');
    }

    // Group marks by subject+exam
    $marksBySubjectExam = $marks->groupBy(function ($mark) {
        return $mark->subject_id . '_' . $mark->exam_id;
    });

    // Get all subjects for which the student has marks
    $subjectIds = $marks->pluck('subject_id')->filter()->unique();
    $subjects = Subject::whereIn('id', $subjectIds)->get();

    // dd($subjects);

    if ($subjects->isEmpty()) {
        // return redirect()->back()->withErrors('Subjects not found for this student.');
        return redirect()->back()->with('error', 'Subjects not found for this student.');
    }

    // (subject_id | term) => collection of marks
    $marksBySubjectTerm = $marks->groupBy(function ($m) {
    $term = optional($m->exam)->term ?? '';
    return $m->subject_id . '|' . $term;
});

    $terms = $exams->keys(); // collect(['Term 1','Term 2','Annual Term'])

   foreach ($subjects as $subject) {
      foreach ($terms as $term) {
         $key = $subject->id . '|' . $term;
         if (!isset($marksBySubjectTerm[$key])) {
            return redirect()->back()->with('error', "Missing marks for subject '{$subject->name}' in '{$term}'.");
        }
    }
} 

    $grades = Grade::all();

    // All checks passed
    return view('admin.marks.full_year_marksheet', compact(
        'student', 'exams', 'marksBySubjectExam', 'subjects', 'grades', 'marks'
    )); 
}

}