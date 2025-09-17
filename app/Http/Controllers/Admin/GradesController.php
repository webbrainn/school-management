<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Grade;

class GradesController extends Controller
{
    
    public function index(){
        $grades=Grade::all();
        return view('admin.grade.index',compact('grades'));
    }

    public function store(Request $request)
{
    $request->validate([
        'grade_name' => 'required|max:5',
        'mark_from' => 'required|integer|min:0',
        'mark_to' => 'required|integer|min:0',
        'description' => 'nullable|string',
    ]);

    // mark_to must be greater than mark_from
    if ($request->mark_to <= $request->mark_from) {
        return back()
            ->withErrors(['mark_to' => 'Marks To must be greater than Mark From'])
            ->withInput();
    }
    Grade::create([
        'grade_name' => $request->grade_name,
        'mark_from' => $request->mark_from,
        'mark_to' => $request->mark_to,
        'description' => $request->description,
    ]);

    return redirect()->route('grades.index')->with('success', 'Grade created successfully.');
}

public function edit($id){
    $grade=Grade::findOrFail($id);
    return view('admin.grade.edit', compact('grade'));
}

public function update(Request $request, $id)
{
    try{
       $request->validate([
        'grade_name' => 'required|max:5',
        'mark_from' => 'required|integer|min:0',
        'mark_to' => 'required|integer|gte:mark_from',
        'description' => 'nullable|string',
    ]);

    if ($request->mark_to <= $request->mark_from) {
        return back()
            ->withErrors(['mark_to' => 'Marks To must be greater than Mark From'])
            ->withInput();
    }
    $grade = Grade::findOrFail($id);
    $grade->update($request->all());

    return redirect()->route('grades.index')->with('success', 'Grade updated successfully.');

    } catch(\Exception $e){
        return back()->withErrors(['error' => $e->getMessage()])->withInput();
    }
}

    public function destroy($id){
        $grade = Grade::findOrFail($id);
        $grade->delete();
        
        return redirect()->route('grades.index')->with('success', 'Grade deleted successfully.');
    }


}