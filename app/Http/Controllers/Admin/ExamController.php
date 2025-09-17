<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Section;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class ExamController extends Controller
{

public function index(Request $request)
{
    $classes = SchoolClass::all();
    $sections = Section::all();

    $selectedClassId = $request->get('class_id');
    $selectedSectionId = $request->get('section_id');
    $selectedTerm = $request->get('term'); 

    $selectedClassName = SchoolClass::find($selectedClassId)?->name ?? 'Class not found';

    $exams = Exam::when($selectedClassId, function ($query, $classId) {
        return $query->where('school_classes_id', $classId);
    })->when($selectedSectionId, function ($query, $sectionId) {
        return $query->where('section_id', $sectionId);
    })->when($selectedTerm, function ($query, $term) {
        return $query->where('term', $term); 
    })->with(['subject', 'class', 'section'])->get();

    return view('admin.exam.index', compact(
        'exams',
        'classes',
        'sections',
        'selectedClassId',
        'selectedSectionId',
        'selectedTerm', 
        'selectedClassName'
    ));
}

public function getSections( $class_id ) {
        try {
            $sections = Section::where( 'class_id', $class_id )->get( [ 'id', 'name' ] );
            return response()->json( $sections );
        } catch ( \Exception $e ) {
            Log::error( 'Error fetching sections: ' . $e->getMessage() );
            return response()->json( [], 500 );
        }
    }

    public function getSubjectsBySection($sectionId)
{
    try {
        $subjects = Subject::where('section_id', $sectionId)->get(); // 
        return response()->json($subjects);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to fetch subjects'], 500);
    }
}

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'exam_name'        => 'required|string|max:255',
            'school_classes_id'    => 'required|exists:school_classes,id',
            'section_id' => 'required|exists:sections,id',
            'subjects_id'  => 'required|exists:subjects,id',
            'term'        => 'required|string',
            'exam_date'   => 'required|date',
            'start_time'  => 'required',
            'end_time'    => 'required|after:start_time',
            'max_marks' => 'nullable|string',
            'pass_marks' => 'nullable|string',
            'internal_pass_marks' => 'nullable|string',
            'internal_max_marks' => 'nullable|string',
            'session' => 'nullable|string',
            'field2' => 'nullable|string',
            'field3' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {

            // Check for duplicate exam for same class, section, subject, term
        $exists = Exam::where('school_classes_id', $request->school_classes_id)
            ->where('section_id', $request->section_id)
            ->where('subjects_id', $request->subjects_id)
            ->where('term', $request->term)
            ->where('session', $request->session)

            ->exists();

        if ($exists) {
            return back()->with('error', 'This exam already exists for the selected class, section, subject, and term.')
                         ->withInput();
        }
        //

            Exam::create($request->all());
            return redirect()->route('exam.index')->with('success', 'Exam created successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to create exam: ' . $e->getMessage());
        }
    }

    // Edit
public function edit($id)
{
    $exam = Exam::findOrFail($id);
    $classes = SchoolClass::all();
    // $subjects = Subject::where('class_id', $exam->class_id)->get();
    $subjects = Subject::where('class_id', $exam->school_classes_id)->get();
    $sections = Section::where('class_id', $exam->school_classes_id)->get();

    return view('admin.exam.edit', compact('exam', 'classes', 'subjects', 'sections'));
}

// Update
public function update(Request $request, $id)
{
    $request->validate([
        'exam_name' => 'required',
        'school_classes_id' => 'required',
        'section_id' => 'required|exists:sections,id',
        'subjects_id' => 'required',
        // 'subjects_id' => 'nullable',
        'term' => 'required',
        'session' => 'required',
        'pass_marks' => 'required|numeric',
        'max_marks' => 'required|numeric',
        'internal_pass_marks' => 'nullable|string',
        'internal_max_marks' => 'nullable|string',
        'exam_date' => 'required|date',
        'start_time' => 'required',
        'end_time' => 'required',
    ]);

    $exam = Exam::findOrFail($id);
    $exam->update($request->all());

    return redirect()->route('exam.index')->with('success', 'Exam updated successfully.');
}

    public function destroy($id)
    {
        try {
            $exam = Exam::findOrFail($id);
            $exam->delete();
            return redirect()->back()->with('success', 'Exam deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete exam: ' . $e->getMessage());
        }
    }
}