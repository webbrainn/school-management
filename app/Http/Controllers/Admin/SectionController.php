<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\SchoolClass;
use App\Models\Teacher;
use Illuminate\Validation\ValidationException;
use Exception;
use Carbon\Carbon;

class SectionController extends Controller
{
    
    // public function index()
    // {
    //     $sections = Section::with(['schoolClass', 'teacher'])->get();
    //     $classes = SchoolClass::all();
    //     $teachers = Teacher::all();
    //     return view('admin.section.index', compact('sections'));
    // }

    public function index(Request $request)
    {
        $sections = Section::with(['schoolClass', 'teacher'])
            ->when($request->class_id, function ($query) use ($request) {
                return $query->where('class_id', $request->class_id);
            })->paginate(10);

        $classes = SchoolClass::all();
        $teachers = Teacher::all();
        return view('admin.section.index', compact('sections', 'classes', 'teachers'));
    }

    // public function create()
    // {
    //     $classes = SchoolClass::all();
    //     $teachers = Teacher::all();
    //     return view('admin.section.create', compact('classes', 'teachers'));
    // }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'class_id' => 'required|exists:school_classes,id',
                'teacher_id' => 'nullable|exists:teachers,id',
                'status' => 'nullable|boolean',
                // 'description' => 'nullable|string|max:500',
                'capacity' => 'required|integer|min:1',
                // 'students_count' => 'nullable|integer|min:1',
                // 'field1' => 'nullable|string|max:255',
                // 'field2' => 'nullable|string|max:255',
            ]);

            // Check if the selected teacher is already assigned
            if (!empty($validated['teacher_id'])) {
                $assigned = Section::where('teacher_id', $validated['teacher_id'])->first();

                if ($assigned) {
                    return back()->withErrors(['teacher_id' => 'This teacher is already assigned to another section. Please choose another teacher! '])->withInput();
                }
            }

            // dd($validated);
            // Create section
            Section::create($validated);
            return redirect()->route('section.index')->with('success', 'Section created successfully.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'An error occurred while creating the section.'])->withInput();
        }
    }

    public function edit(Section $section)
    {
        $classes = SchoolClass::all();
        $teachers = Teacher::all();
        return view('admin.section.edit', compact('section', 'classes', 'teachers'));
    }

    public function update(Request $request, Section $section)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'class_id' => 'required|exists:school_classes,id',
                'teacher_id' => 'nullable|exists:teachers,id',
                'status' => 'nullable|boolean',
                'description' => 'nullable|string|max:500',
                'capacity' => 'required|integer|min:1',
                'students_count' => 'nullable|integer|min:1',
                'field1' => 'nullable|string|max:255',
                'field2' => 'nullable|string|max:255',
            ]);

            // Check if the selected teacher is already assigned
            if (!empty($validated['teacher_id']) && $validated['teacher_id'] != $section->teacher_id) {
                $assigned = Section::where('teacher_id', $validated['teacher_id'])->first();

                if ($assigned) {
                    return back()->withErrors(['teacher_id' => 'This teacher is already assigned to another section. Please choose another teacher!'])->withInput();
                }
            }

            // Update the section
            $section->update($validated);

            return redirect()->route('section.index')->with('success', 'Section updated successfully.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'An error occurred while updating the section.'])->withInput();
        }
    }

    public function destroy(Section $section)
    {
        try {
            $section->delete();
            return redirect()->route('section.index')->with('success', 'Section deleted successfully.');
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'An error occurred while deleting the section.'])->withInput();
        }
    }

}
