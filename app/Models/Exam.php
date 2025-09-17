<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_name','school_classes_id', 'section_id', 'subjects_id','term','exam_date','start_time','end_time',
        'max_marks','pass_marks','session', 'internal_pass_marks', 'internal_max_marks', 'field1', 'field2', 'field3'
    ];

     /**
     * Get the class associated with the exam.
     */
    public function class()
    {
        return $this->belongsTo(SchoolClass::class, 'school_classes_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    /**
     * Get the subject associated with the exam. 
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subjects_id');
    }

}
