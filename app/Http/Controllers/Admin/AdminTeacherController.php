<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Validation\Rule;
use App\Models\Teacher;

class AdminTeacherController extends Controller
{

    public function index()
    {
        try {
            $teachers = Teacher::all();
            // $teachers = Teacher::paginate(10);
            return view('admin.teacher.index', compact('teachers'));
        } catch (Exception $e) {
            return back()->with('error', 'Failed to load teachers: ' . $e->getMessage());
        }
    }

    public function create()
    {
        return view('admin.teacher.create');
    }

public function store(Request $request)
{
    $messages = [
        'email.unique' => 'This email is already registered.',
        'phone.unique' => 'This phone number is already in use.',
        'email.required' => 'Email is required.',
        'phone.required' => 'Phone number is required.',
        'name.required' => 'Name is required.',
        'qualification.required' => 'Qualification is required.',
        'phone.digits' => 'The phone number must be exactly 10 digits.',
        'email.regex' => 'The email must end with .com.',
    ];

    $request->validate([
        'name' => 'required|string|max:255',
        // 'email' => 'required|email|unique:teachers,email',
        'email' => ['required', 'email', 'regex:/^[^@\s]+@[^@\s]+\.(com)$/i', 'unique:teachers,email',],
        'phone' => 'required|string|digits:10|unique:teachers,phone',
        'qualification' => 'required|string|max:255',
        'subject' => 'required|string|max:255',
        'address' => 'nullable|string|max:255',
    ], $messages);

    try {
        Teacher::create($request->all());
        return redirect()->route('admin.teachers.index')->with('success', 'Teacher added successfully!');
    } catch (\Exception $e) {
        return back()->withInput()->with('error', 'Failed to add teacher: ' . $e->getMessage());
    }
}


    // public function show(Teacher $teacher)
    // {
    //     try {
    //         return view('admin.teacher.show', compact('teacher'));
    //     } catch (Exception $e) {
    //         return back()->with('error', 'Failed to load teacher details: ' . $e->getMessage());
    //     }
    // }

    public function edit(Teacher $teacher)
    {
        try {
            return view('admin.teacher.edit', compact('teacher'));
        } catch (Exception $e) {
            return back()->with('error', 'Failed to load teacher details: ' . $e->getMessage());
        }
    }


//     public function update(Request $request, Teacher $teacher)
// {
//     $request->validate([
//         'name' => 'required|string|max:255',
//         'email' => 'required|email|unique:teachers,email,' . $teacher->id,
//         'phone' => 'required|string|max:10|unique:teachers,phone,' . $teacher->id,
//         'qualification' => 'required|string|max:255',
//         'subject' => 'nullable|string|max:255',
//         'address' => 'nullable|string|max:255',
//     ]);

//     try {
//         $teacher->update($request->only(['name', 'email', 'phone', 'qualification','subject', 'address']));
//         return redirect()->route('admin.teachers.index')->with('success', 'Teacher updated successfully!');
//     } catch (Exception $e) {
//         return back()->withInput()->with('error', 'Failed to update teacher: ' . $e->getMessage());
//     }
// }

public function update(Request $request, Teacher $teacher)
{
    try {
        $messages = [
            'dob.before' => 'The student must be at least 3 years old.',
            'phone.digits' => 'The phone number must be exactly 10 digits.',
            'email.regex' => 'The email must end with .com.',
        ];

        $request->validate([
        'name' => 'required|string|max:255',
        // 'email' => ['required', 'email', 'regex:/^[^@\s]+@[^@\s]+\.(com)$/i', 'unique:teachers,email',],
        'email' => [
                'required',
                'email',
                'regex:/^[^@\s]+@[^@\s]+\.(com)$/i',
                Rule::unique('teachers', 'email')->ignore($teacher->id),
            ],
        'phone' => 'required|string|max:10|unique:teachers,phone,' . $teacher->id,
        'qualification' => 'required|string|max:255',
        'subject' => 'nullable|string|max:255',
        'address' => 'nullable|string|max:255',
    ], $messages);

        $teacher->update($request->only(['name', 'email', 'phone', 'qualification','subject', 'address']));
        return redirect()->route('admin.teachers.index')->with('success', 'Teacher updated successfully!');
    } catch (Exception $e) {
        return back()->withInput()->with('error', 'Failed to update teacher: ' . $e->getMessage());
    }
}

    public function destroy(Teacher $teacher)
    {
        try {
            $teacher->delete();
            return redirect()->route('admin.teachers.index')->with('success', 'Teacher deleted successfully!');
        } catch (Exception $e) {
            return back()->with('error', 'Failed to delete teacher: ' . $e->getMessage());
        }
    }
}