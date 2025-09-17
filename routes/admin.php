<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminTeacherController;
use App\Http\Controllers\Admin\SchoolClassController;
use App\Http\Controllers\Admin\AdminStudentController;
use App\Http\Controllers\Admin\AdminAdmissionController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\GradesController;
use App\Http\Controllers\Admin\MarksController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\FeeController;

// Admin Dashboard
Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');

// Teachers Route
Route::get('/teachers', [AdminTeacherController::class, 'index'])->name('admin.teachers.index');
Route::get('/teachers/create', [AdminTeacherController::class, 'create'])->name('admin.teachers.create');
Route::post('/teachers', [AdminTeacherController::class, 'store'])->name('admin.teachers.store');
Route::get('/teachers/{teacher}/edit', [AdminTeacherController::class, 'edit'])->name('admin.teachers.edit');
Route::put('/teachers/{teacher}', [AdminTeacherController::class, 'update'])->name('admin.teachers.update');
Route::delete('/teachers/{teacher}', [AdminTeacherController::class, 'destroy'])->name('admin.teachers.destroy');

// Classes route
Route::get('/classes', [SchoolClassController::class, 'index'])->name('classes.index');
Route::get('/classes/create', [SchoolClassController::class, 'create'])->name('classes.create');
Route::post('/classes', [SchoolClassController::class, 'store'])->name('classes.store');
Route::get('/{class}/edit', [SchoolClassController::class, 'edit'])->name('classes.edit');
Route::put('/{class}', [SchoolClassController::class, 'update'])->name('classes.update');
Route::delete('/{class}', [SchoolClassController::class, 'destroy'])->name('classes.destroy');

// Section Routes
Route::get('/sections', [SectionController::class, 'index'])->name('section.index');
Route::get('/sections/create', [SectionController::class, 'create'])->name('section.create');
Route::post('/sections', [SectionController::class, 'store'])->name('section.store');
Route::get('/sections/{section}/edit', [SectionController::class, 'edit'])->name('section.edit');
Route::put('/sections/{section}', [SectionController::class, 'update'])->name('section.update');
Route::delete('/sections/{section}', [SectionController::class, 'destroy'])->name('section.destroy');

// Student Routes
Route::get('/students', [AdminStudentController::class, 'index'])->name('students.index');
Route::get('/students/create', [AdminStudentController::class, 'create'])->name('students.create');
Route::post('/students', [AdminStudentController::class, 'store'])->name('students.store');
Route::get('/students/{student}/edit', [AdminStudentController::class, 'edit'])->name('students.edit');
Route::put('/students/{student}', [AdminStudentController::class, 'update'])->name('students.update');
Route::delete('/students/{student}', [AdminStudentController::class, 'destroy'])->name('students.destroy');
Route::get('/get-sections-by-class', [AdminStudentController::class, 'getSectionsByClass'])->name('admin.getSectionsByClass');

// Student excel uploading
Route::post('/students/import', [AdminStudentController::class, 'import'])->name('students.import');

// Subject Routes
Route::get('/subject', [SubjectController::class, 'index'])->name('subject.index'); 
Route::post('/subject', [SubjectController::class, 'store'])->name('subject.store');
Route::get('/subject/{subject}/edit', [SubjectController::class, 'edit'])->name('subject.edit');
Route::put('/subject/{subject}', [SubjectController::class, 'update'])->name('subject.update');
Route::delete('/subject/{subject}', [SubjectController::class, 'destroy'])->name('subject.destroy');
Route::get('/get-sections/{class_id}', [SubjectController::class, 'getSections']);
Route::post('/subject-toggle-status', [SubjectController::class, 'toggleStatus'])->name('subject.toggleStatus');

// Exam Routes
Route::get('/exam', [ExamController::class, 'index'])->name('exam.index'); 
Route::post('/exam', [ExamController::class, 'store'])->name('exam.store');
Route::get('/exam/{exam}/edit', [ExamController::class, 'edit'])->name('exam.edit'); 
Route::put('/exam/{exam}', [ExamController::class, 'update'])->name('exam.update');
Route::delete('/exam/{exam}', [ExamController::class, 'destroy'])->name('exam.destroy');
Route::get('/get-sections/{class_id}', [ExamController::class, 'getSections']);
// Route::get('/get-subjects/{class_id}', [ExamController::class, 'getSubjects']);
Route::get('/get-subjects-by-section/{sectionId}', [ExamController::class, 'getSubjectsBySection']);
Route::post('/exam-toggle-status', [ExamController::class, 'toggleStatus'])->name('exam.toggleStatus');

// Grades Routes
Route::get('/grades', [GradesController::class, 'index'])->name('grades.index'); 
Route::post('/grades', [GradesController::class, 'store'])->name('grades.store');
Route::get('/grades/{id}/edit', [GradesController::class, 'edit'])->name('grades.edit'); 
Route::put('/grades/{id}', [GradesController::class, 'update'])->name('grades.update');
Route::delete('/grades/{id}', [GradesController::class, 'destroy'])->name('grades.destroy');
Route::post('/grades-toggle-status', [GradesController::class, 'toggleStatus'])->name('grades.toggleStatus');


// Marks Routes
Route::get('/marks/create', [MarksController::class, 'create'])->name('marks.create');
Route::post('/marks/store', [MarksController::class, 'store'])->name('marks.store');
Route::get('/get-students/{class_id}', [MarksController::class, 'getStudents'])->name('marks.getStudents');
// Route::get('/get-subjects/{class_id}', [MarksController::class, 'getSubjects'])->name('marks.getSubjects');
// Route::get('/get-exams/{classId}', [MarksController::class, 'getExamsByClass'])->name('marks.getExamsByClass');
Route::get('/get-sections-by-class/{class_id}', [MarksController::class, 'getSectionsByClass']);
Route::get('/get-students-by-section/{section_id}', [MarksController::class, 'getStudentsBySection']);
Route::get('/get-exams-by-section/{section_id}', [MarksController::class, 'getExamsBySection']);
Route::post('/marks/import', [MarksController::class, 'import'])->name('marks.import');

Route::get('/marks/class', [MarksController::class, 'viewByClass'])->name('marks.byClass');
Route::delete('/marks/{id}', [MarksController::class, 'destroy'])->name('marks.destroy');
Route::get('/marks/{id}/edit', [MarksController::class, 'edit'])->name('marks.edit');
Route::put('/marks/{id}', [MarksController::class, 'update'])->name('marks.update');

Route::get('/marks/by-student', [MarksController::class, 'viewByStudent'])->name('marks.byStudent');
Route::get('/marks/get-student-marks/{student_id}', [MarksController::class, 'getStudentMarks'])->name('marks.getStudentMarks');
Route::get('/student-marks/{id}/edit', [MarksController::class, 'studentMarksEdit'])->name('student-marks.edit');
Route::put('/student-marks/{id}', [MarksController::class, 'studentMarksUpdate'])->name('student-marks.update');
Route::delete('/student-marks/{id}', [MarksController::class, 'studentMarksDestroy'])->name('student-marks.destroy');
Route::get('/get-exams-by-section-term/{section_id}', [MarksController::class, 'getExamsBySectionAndTerm']);

// Marksheet Routes 
Route::get('/student-marksheet', [MarksController::class, 'studentMarksheetSelection'])->name('student.marksheet');
Route::get('/marksheet/{student_id}/term/{term}', [MarksController::class, 'showMarksheetByTerm'])->name('marks.marksheet.term');
// Route::get('/marksheet/{student_id}', [MarksController::class, 'showFullYearMarksheet'])->name('marks.full_year');
Route::get('/marksheet/{student_id}', [MarksController::class, 'showFullYearMarksheet'])->name('marks.full_year');

Route::get('/results/student/{student_id}', [MarksController::class, 'viewStudentResult'])->name('results.student');
Route::get('/results/class/{class_id}', [MarksController::class, 'viewClassResult'])->name('results.class');
Route::get('/results/subject/{subject_id}', [MarksController::class, 'viewSubjectResult'])->name('results.subject');

// Fee Routes
Route::get('/fees', [FeeController::class, 'index'])->name('fees.index');
Route::post('/fees/collect', [FeeController::class, 'store'])->name('fees.store');
Route::get('/fees/{fee}/edit', [FeeController::class, 'edit'])->name('fees.edit');
Route::put('/fees/{fee}', [FeeController::class, 'update'])->name('fees.update');
Route::delete('/fees/{fee}', [FeeController::class, 'destroy'])->name('fees.destroy');

// Admission Routes
Route::get('/admission', [AdminAdmissionController::class, 'index'])->name('admission.index');
Route::get('/admission/create', [AdminAdmissionController::class, 'create'])->name('admission.create');
Route::post('/admission', [AdminAdmissionController::class, 'store'])->name('admission.store');
Route::get('/admission/{admission}/edit', [AdminAdmissionController::class, 'edit'])->name('admission.edit');
Route::put('/admission/{admission}', [AdminAdmissionController::class, 'update'])->name('admission.update');
Route::delete('/admission/{admission}', [AdminAdmissionController::class, 'destroy'])->name('admission.destroy');
Route::get('/admission-search', [AdminAdmissionController::class, 'search'])->name('admission.search');
Route::post('/admission-toggle-status', [AdminAdmissionController::class, 'toggleStatus'])->name('admission.toggleStatus');


// Route::get('/test-image', function () {
//     return view('admin.admission.test');
// })->name('admin.test-image');