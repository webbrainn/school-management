<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marks extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'class_id', 'section_id', 'exam_id', 'subject_id', 'marks_obtained', 
                           'sheet_image', 'term', 'grade', 'description', 'is_active', 'roll_no', 'field2'];

    public function student() {
    return $this->belongsTo(Student::class);
}

public function exam() {
    return $this->belongsTo(Exam::class);
}

public function subject() {
    return $this->belongsTo(Subject::class);
}
    
}

