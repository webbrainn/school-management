<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\SchoolClass;
use App\Models\Section;
Use App\Models\Subject;
Use App\Models\Fee;
Use App\Models\Grade;
Use App\Models\Exam;
Use App\Models\Marks;
Use App\Models\Admission;

class DashboardController extends Controller
{
    //
    // public function dashboard(){

    //     $totalStudents = Student::count();
    //     $totalTeachers = Teacher::count();
    //     $totalClasses = SchoolClass::count();
    //     $totalSections = Section::count();
    //     $totalSubjects = Subject::count();
    //     $totalfees = Fee::count();
    //     $totalGrades = Grade::count();
    //     $totalExams = Exam::count();
    //     $totalMarks = Marks::count();
    //     $totalAdmissions = Admission::count();

    //     return view('admin.dashboard',compact('totalStudents','totalTeachers',
    //                 'totalClasses','totalSections','totalSubjects','totalfees',
    //                 'totalGrades','totalExams','totalMarks','totalAdmissions') );
    // }

    public function dashboard()
{
    $totalStudents = Student::count();
    $totalTeachers = Teacher::count();
    $totalClasses = SchoolClass::count();
    $totalSections = Section::count();
    $totalSubjects = Subject::count();
    $totalfees = Fee::count();
    $totalGrades = Grade::count();
    $totalExams = Exam::count();
    $totalMarks = Marks::count();
    $totalAdmissions = Admission::count();

    // Get latest admissions
    $recentStudents = Student::with(['class', 'section'])
        ->latest()
        ->take(2)
        ->get()
        ->map(function ($student) {
            return [
                'type' => 'student',
                'message' => "New Student:  $student->first_name $student->last_name  
                              ({$student->class->name} - {$student->section->name})",
                'date' => $student->created_at
            ];
        });

    // Get latest fee payments
    $recentFees = Fee::with(['student.class', 'student.section'])
        ->latest()
        ->take(2)
        ->get()
        ->map(function ($fee) {
            return [
                'type' => 'fee',
                // 'message' => "Fee Paid: ₹{$fee->amount_paid} by {$fee->student->name} ({$fee->student->class->name} - {$fee->student->section->name})",
                'message' => "Fee Paid: ₹{$fee->amount_paid} by '{$fee->student->first_name} {$fee->student->last_name}' 
                                         ({$fee->student->class->name} - {$fee->student->section->name})",
                'date' => $fee->created_at
            ];
        });

    // Get latest marks updates
    $recentMarks = Marks::with(['student.class', 'student.section', 'exam'])
        ->latest()
        ->take(2)
        ->get()
        ->map(function ($mark) {
            return [
                'type' => 'marks',
                // 'message' => "Marks updated for {$mark->student->class->name} - {$mark->student->section->name} ({$mark->exam->exam_name})",
                'message' => "Marks updated for '{$mark->student->first_name} {$mark->student->last_name}' 
                              from {$mark->student->class->name} - {$mark->student->section->name} ({$mark->exam->exam_name})",
                'date' => $mark->updated_at
            ];
        });

    // Merge & sort all recent activities
    $recentActivities = collect()
        ->merge($recentStudents)
        ->merge($recentFees)
        ->merge($recentMarks)
        ->sortByDesc('date')
        ->take(5);

    return view('admin.dashboard', compact(
        'totalStudents', 'totalTeachers', 'totalClasses', 'totalSections', 
        'totalSubjects', 'totalfees', 'totalGrades', 'totalExams', 
        'totalMarks', 'totalAdmissions', 'recentActivities'
    ));
}

}