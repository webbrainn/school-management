<?php

namespace App\Imports;

use App\Models\Marks;
use App\Models\Student;
use App\Models\SchoolClass;
use App\Models\Exam;
use App\Models\Section;
use App\Models\Subject;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Illuminate\Support\Facades\Log;
use Throwable;

class MarksImport implements ToCollection, WithHeadingRow, SkipsOnFailure, SkipsOnError
{
    use SkipsFailures, SkipsErrors;

    public $rowErrors = [];

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            Log::info('Import row:', $row->toArray());
            $rowNumber = $index + 2; // +2 because row 1 is the header

            // Normalize input
            $studentName   = trim($row['student_name'] ?? '');
            $className     = trim($row['class_name'] ?? '');
            $sectionName   = trim($row['section_name'] ?? '');
            $examName      = trim($row['exam_name'] ?? '');
            // $subjectName   = trim($row['subject_name'] ?? '');   // <-- add subject
            $subjectName = trim($row['exam_name'] ?? '');
            $rollNo        = trim($row['roll_no'] ?? '');
            $marksObtained = $row['marks_obtained'] ?? null;
            $grade         = trim($row['grade'] ?? '');
            $description   = trim($row['description'] ?? '');
            $term          = trim($row['term'] ?? '');

            // Required fields validation
            $required = [
                'student_name'   => $studentName,
                'class_name'     => $className,
                'section_name'   => $sectionName,
                'exam_name'      => $examName,
                'subject_name'   => $subjectName,
                'roll_no'        => $rollNo,
                'marks_obtained' => $marksObtained,
                'grade'          => $grade,
                'term'           => $term,
            ];

            foreach ($required as $key => $value) {
                if ($value === '' || $value === null) {
                    $this->rowErrors[] = "Row $rowNumber: Missing value for '$key'.";
                    continue 2; // Skip this row
                }
            }

            try {
                $student = Student::whereRaw("TRIM(CONCAT(first_name, ' ', COALESCE(last_name, ''))) = ?", [$studentName])->first();
                $class   = SchoolClass::where('name', $className)->first();
                $section = Section::where('name', $sectionName)->where('class_id', optional($class)->id)->first();
                $exam    = Exam::where('exam_name', $examName)
                ->where('school_classes_id', $class->id)
                           ->where('section_id', $section->id)
                ->first();

                // $subject = Subject::where('name', $subjectName)->first();
                $subject = Subject::where('name', $examName) // using exam_name as subject_name
                           ->where('class_id', $class->id)
                           ->where('section_id', $section->id)
                           ->first();

                if (!$subject) {
                    $this->rowErrors[] = "Row $rowNumber: Subject '{$examName}' not found for class {$className} and section {$sectionName}.";
                    continue;
                }


                if (!$student || !$class || !$exam || !$section || !$subject) {
                    $this->rowErrors[] = "Row $rowNumber: Student/Class/Section/Exam/Subject not found.";
                    continue;
                }

                // Check if marks already exist for this student, exam & subject
                $existing = Marks::where('student_id', $student->id)
                  ->where('exam_id', $exam->id)
                  ->where('subject_id', $subject->id)
                  ->where('term', $term)
                  ->first();

                if ($existing) {
                    $this->rowErrors[] = "Row $rowNumber: Duplicate marks entry for '{$studentName}' in class :- '{$className}' section :- '{$sectionName}', subject :- '{$examName}', term :- '{$term}'.";
                    continue;
                }

                // Insert new marks
                Marks::create([
                    'student_id'     => $student->id,
                    'class_id'       => $class->id,
                    'section_id'     => $section->id,
                    'exam_id'        => $exam->id,
                    // 'subject_id'     => $subject->id,
                    'subject_id'     => $subject->id,  // ✅ now exact subject_id (33 for Nursery A)
                    'roll_no'        => $rollNo,
                    'marks_obtained' => $marksObtained,
                    'grade'          => $grade,
                    'description'    => $description,
                    'term'           => $term,
                ]);
            } catch (Throwable $e) {
                $this->rowErrors[] = "Row $rowNumber: " . $e->getMessage();
            }
        }
    }
}
