<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Fee;

class FeeController extends Controller
{
    //

public function index(Request $request)
{
    $classes = SchoolClass::all();
    $students = collect();
    $selectedFees = collect();

    if ($request->class_id && $request->section_id && $request->student_id) {
        $students = Student::where([
            'class_id' => $request->class_id,
            'section_id' => $request->section_id,
        ])->get();

        $selectedFees = Fee::where('student_id', $request->student_id)->get();
    }

    return view('admin.fees.index', compact('classes', 'students', 'selectedFees'));
}

public function store(Request $request)
{
    $validated = $request->validate([
        'class_id' => 'required',
        'section_id' => 'required',
        'student_id' => 'required',
        'roll_no' => 'required',
        'months' => 'required|array',
        'fee_amount' => 'required|numeric',
        'amount_paid' => 'required|numeric',
        'amount_due' => 'nullable|numeric',
    ]);

    $alreadyPaidMonths = [];

    foreach ($request->months as $month) {
        $alreadyExists = Fee::where('student_id', $request->student_id)
            ->where('month', $month)
            ->where('year', date('Y'))
            ->exists();

        if ($alreadyExists) {
            $alreadyPaidMonths[] = $month;
        }
    }

    if (!empty($alreadyPaidMonths)) {
        return back()
            ->withErrors(['months' => 'Fee already collected of this student for: ' . implode(', ', $alreadyPaidMonths)])
            ->withInput();
    }

    // If no duplicate found, proceed to insert
    foreach ($request->months as $month) {
        Fee::create([
            'class_id' => $request->class_id,
            'section_id' => $request->section_id,
            'student_id' => $request->student_id,
            'roll_no' => $request->roll_no,
            'month' => $month,
            'year' => date('Y'),
            'fee_amount' => $request->fee_amount,
            'amount_paid' => $request->amount_paid,
            'amount_due' => $request->fee_amount - $request->amount_paid,
        ]);
    }

    return back()->with('success', 'Fee collected successfully!');
}

public function edit($id)
{
    $fee = Fee::findOrFail($id);
    $classes = SchoolClass::all();
    $sections = Section::where('class_id', $fee->class_id)->get();

    return view('admin.fees.edit', compact('fee', 'classes', 'sections'));
}

public function update(Request $request, $id)
{
    $validated = $request->validate([
        'class_id' => 'required',
        'section_id' => 'required',
        'student_id' => 'required',
        'roll_no' => 'required',
        'month' => 'required',
        // 'year' => 'required',
        'fee_amount' => 'required|numeric',
        'amount_paid' => 'required|numeric',
        'amount_due' => 'nullable|numeric',
    ]);

    $fee = Fee::findOrFail($id);
    $fee->update($validated);

    return redirect()->route('fees.index')->with('success', 'Fee record updated successfully!');
}

public function destroy($id)
{
    $fee = Fee::findOrFail($id);
    $fee->delete();

    return back()->with('success', 'Fee record deleted successfully!');
}

}