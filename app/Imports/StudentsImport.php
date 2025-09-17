<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\Section;
use App\Models\SchoolClass;
use Illuminate\Validation\ValidationException; 
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Validators\Failure;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class StudentsImport implements ToModel, WithHeadingRow, SkipsOnFailure
{
    public function model(array $row)
    {
        //  Find class by name
        // $class = SchoolClass::where('name', $row['class_name'])->first();
        // if (!$class) {
        //     throw ValidationException::withMessages([
        //         'class_name' => "Class '{$row['class_name']}' not found."
        //     ]);
        // }

        $class = SchoolClass::where('name', $row['class_name'])->first();
        if (!$class) {
            // Log and skip
            Log::error("Class '{$row['class_name']}' not found.");
            return null;
        }
        // dd($row);

        // Find section by name and class
        $section = Section::where('name', $row['section_name'])
            ->where('class_id', $class->id)
            ->first();

        if (!$section) {
            throw ValidationException::withMessages([
                'section_name' => "Section '{$row['section_name']}' not found in class '{$row['class_name']}'."
            ]);
        }

        // Check if section capacity is full
        if ($section->students_count >= $section->capacity) {
            throw ValidationException::withMessages([
                'section_name' => "Section '{$row['section_name']}' is full."
            ]);
        }

        // Parse date of birth
        try {
            if (is_numeric($row['dob'])) {
                $dob = Carbon::instance(ExcelDate::excelToDateTimeObject($row['dob']));
            } else {
                $dob = Carbon::createFromFormat('d/m/Y', $row['dob']);
            }
        } catch (\Exception $e) {
            throw ValidationException::withMessages([
                'dob' => "Invalid date format '{$row['dob']}'. Please use DD/MM/YYYY."
            ]);
        }

        // Check for unique email
        if (Student::where('email', $row['email'])->exists()) {
            throw ValidationException::withMessages([
                // 'email' => "Email '{$row['email']}' already exists."
                'email' => "Email '{$row['email']}' already exists in class '{$row['class_name']}', section '{$row['section_name']}'."
            ]);
        }

        // Check for unique phone
        if (Student::where('phone', $row['phone'])->exists()) {
            throw ValidationException::withMessages([
                'phone' => "Phone '{$row['phone']}' already exists in class '{$row['class_name']}', section '{$row['section_name']}'."
            ]);
        }

        // Check for unique roll_no within section
        if (Student::where('section_id', $section->id)
            ->where('roll_no', $row['roll_no'])
            ->exists()) {
            throw ValidationException::withMessages([
                'roll_no' => "Roll No '{$row['roll_no']}' already exists in class '{$row['class_name']}', section '{$row['section_name']}'."
            ]);
        }

        // Return new Student model
        return new Student([
            'first_name' => $row['first_name'],
            'last_name'  => $row['last_name'],
            'email'      => $row['email'],
            'phone'      => $row['phone'],
            'dob'        => $dob,
            'gender'     => $row['gender'],
            'address'    => $row['address'],
            'class_id'   => $class->id,
            'section_id' => $section->id,
            'roll_no'    => $row['roll_no'],
        ]);
    }

    public function onFailure(Failure ...$failures)
    {
        foreach ($failures as $failure) {
            Log::error('Import failure', [
                'row' => $failure->row(),
                'attribute' => $failure->attribute(),
                'errors' => $failure->errors(),
                'values' => $failure->values(),
            ]);
        }
    }
}