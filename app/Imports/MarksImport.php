<?php

namespace App\Imports;

use App\Models\Marks;
use App\Models\Student;
use App\Models\SchoolClass;
use App\Models\Exam;
use App\Models\Section;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Throwable;

class MarksImport implements ToCollection, WithHeadingRow, SkipsOnFailure, SkipsOnError
{
    use SkipsFailures, SkipsErrors;

    public $rowErrors = [];

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            $rowNumber = $index + 2; // +2 because row 1 is the header

            // Normalize input
            $studentName = trim($row['student_name'] ?? '');
            $className = trim($row['class_name'] ?? '');
            $sectionName = trim($row['section_name']);
            $examName = trim($row['exam_name'] ?? '');
            $rollNo = trim($row['roll_no'] ?? '');
            $marksObtained = $row['marks_obtained'] ?? null;
            $grade = trim($row['grade'] ?? '');
            $description = trim($row['description'] ?? '');
            $term = trim($row['term'] ?? '');

            // Check for required fields
            $required = [
                'student_name' => $studentName,
                'class_name' => $className,
                'section_name' => $sectionName,
                'roll_no' => $rollNo,
                'exam_name' => $examName,
                'marks_obtained' => $marksObtained,
                'grade' => $grade,
                'description' => $description,
                'term' => $term
            ];

            foreach ($required as $key => $value) {
                if ($value === '' || $value === null) {
                    $this->rowErrors[] = "Row $rowNumber: Missing value for '$key'.";
                    continue 2; // Skip this row
                }
            }

            try {
                $student = Student::whereRaw("TRIM(CONCAT(first_name, ' ', COALESCE(last_name, ''))) = ?", [$studentName])->first();
                $class = SchoolClass::where('name', $className)->first();
                $section = Section::where('name', $sectionName)->first();
                $exam = Exam::where('exam_name', $examName)->first();

                if (!$student || !$class || !$exam || !$section) {
                    $this->rowErrors[] = "Row $rowNumber: Student/Class/Section/Exam not found.";
                    continue;
                }

                Marks::create([
                    'student_id' => $student->id,
                    'class_id' => $class->id,
                    'section_id' => $section->id,
                    'exam_id' => $exam->id,
                    'roll_no' => $rollNo,
                    'marks_obtained' => $marksObtained,
                    'grade' => $grade,
                    'description' => $description,
                    'term' => $term,
                ]);
            } catch (Throwable $e) {
                $this->rowErrors[] = "Row $rowNumber: " . $e->getMessage();
            }
        }
    }
}
