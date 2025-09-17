<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SchoolClass;
use App\Models\Teacher;

class SchoolClassController extends Controller {

    public function index() {
        $classes = SchoolClass::with( 'teacher' )->get();
        return view( 'admin.classes.index', compact( 'classes' ) );
    }

    public function create() {
        $teachers = Teacher::all();
        return view( 'admin.classes.create', compact( 'teachers' ) );
    }

    /**
    * Store a newly created class in storage.
    */

    public function store(Request $request)
{
    try {
        $request->validate([
            'name' => 'required|unique:school_classes,name',
            'field1' => 'nullable|string|max:255',
            // 'capacity' => 'nullable|integer|min:1',
            // 'teacher_id' => 'nullable|exists:teachers,id',
        ]);

        // Check if the selected teacher is already assigned
        // if (!empty($request->teacher_id)) {
        //     $assigned = SchoolClass::where('teacher_id', $request->teacher_id)->first();

        //     if ($assigned) {
        //         return back()->withErrors(['teacher_id' => 'This teacher is already assigned to another class.'])->withInput();
        //     }
        // }

        SchoolClass::create($request->all());

        return redirect()->route('classes.index')->with('success', 'Class created successfully.');
    } catch (\Exception $e) {
        return back()->withErrors(['error' => $e->getMessage()])->withInput();
    }
}

    /**
    * Show the form for editing the specified class.
    */

    public function edit( SchoolClass $class ) {
        $teachers = Teacher::all();
        return view( 'admin.classes.edit', compact( 'class', 'teachers' ) );
    }

    /**
    * Update the specified class in storage.
    */

    public function update( Request $request, SchoolClass $class ) {
        try {
            $request->validate( [
                'name' => 'required|unique:school_classes,name,' . $class->id,
                'capacity' => 'nulllable|integer|min:1',
                'teacher_id' => 'nullable|exists:teachers,id', // Assuming class_teacher is a foreign key to teachers
            ] );

            $class->update( $request->all() );

            return redirect()->route( 'classes.index' )->with( 'success', 'Class updated successfully.' );
        } catch ( \Exception $e ) {
            return back()->withErrors( [ 'error' => $e->getMessage() ] )->withInput();
        }
    }

    /**
    * Remove the specified class from storage.
    */

    public function destroy( SchoolClass $class ) {
        try {
            $class->delete();
            return redirect()->route( 'classes.index' )->with( 'success', 'Class deleted successfully.' );
        } catch ( \Exception $e ) {
            return back()->withErrors( [ 'error' => 'Failed to delete the class. ' . $e->getMessage() ] );
        }
    }
}

