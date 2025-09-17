<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\SchoolClass;
use App\Models\Teacher;
use App\Models\Section;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;

class SubjectController extends Controller {

    public function index( Request $request ) {
        try {
            $classes = SchoolClass::all();
            $sections = Section::all();
            // Or use Eloquent relationships if needed
            $teachers = Teacher::all();

            $subjects = collect();
            // default empty

            if ( $request->has( 'class_id' ) && $request->has( 'section_id' ) && $request->filled( 'class_id' ) && $request->filled( 'section_id' ) ) {
                $subjects = Subject::where( 'class_id', $request->class_id )
                ->where( 'section_id', $request->section_id )
                ->with( [ 'class', 'section', 'teacher' ] )
                ->paginate( 10 );
            }

            return view( 'admin.subject.index', compact( 'subjects', 'classes', 'teachers', 'sections' ) );
        } catch ( \Exception $e ) {
            Log::error( 'Error loading subject index: ' . $e->getMessage() );
            return back()->with( 'error', 'Failed to load subjects.' );
        }
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

    public function store( Request $request ) {
        $request->validate( [
            'name' => 'required|string|max:255',
            'short_name' => 'required|string|max:255',
            'class_id' => 'required|exists:school_classes,id',
            'teacher_id' => 'required|exists:teachers,id',
        ] );

        try {
            Subject::create( $request->all() );
            return redirect()->back()->with( 'success', 'Subject added successfully.' );
        } catch ( \Exception $e ) {
            Log::error( 'Error storing subject: ' . $e->getMessage() );
            return back()->withInput()->with( 'error', 'Failed to add subject.' );
        }
    }

    public function edit( $id ) {
        try {
            $subject = Subject::findOrFail( $id );
            $classes = SchoolClass::all();
            $teachers = Teacher::all();
            $sections = Section::where( 'class_id', $subject->class_id )->get();
            return view( 'admin.subject.edit', compact( 'subject', 'classes', 'teachers', 'sections' ) );
        } catch ( \Exception $e ) {
            Log::error( 'Subject edit load error: ' . $e->getMessage() );
            return back()->with( 'error', 'Failed to load subject edit form.' );
        }
    }

    public function update( Request $request, $id ) {
        $request->validate( [
            'name' => 'required|string|max:255',
            'short_name' => 'required|string|max:100',
            'class_id' => 'required|exists:school_classes,id',
            'section_id' => 'required|exists:sections,id',
            'teacher_id' => 'required|exists:teachers,id',
        ] );

        try {
            $subject = Subject::findOrFail( $id );
            $subject->update( $request->only( [ 'name', 'short_name', 'class_id', 'teacher_id', 'section_id' ] ) );
            return redirect()->route( 'subject.index' )->with( 'success', 'Subject updated successfully!' );
        } catch ( QueryException $e ) {
            Log::error( 'Subject update error: ' . $e->getMessage() );
            return back()->withInput()->with( 'error', 'Database error while updating subject.' );
        }
    }

    public function destroy( $id ) {
        try {
            Subject::findOrFail( $id )->delete();
            return back()->with( 'success', 'Subject deleted successfully!' );
        } catch ( \Exception $e ) {
            Log::error( 'Subject delete error: ' . $e->getMessage() );
            return back()->with( 'error', 'Failed to delete subject.' );
        }
    }
}