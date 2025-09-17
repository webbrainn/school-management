<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $table = 'sections';
    protected $fillable = [
        'name',
        'class_id',
        'teacher_id',
        'capacity',
        'status',
        // 'description',
        // 'students_count',
        // 'field1',
        // 'field2'
    ];

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }
    
    public function students()
    {
        return $this->hasMany(Student::class, 'section_id');
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class, 'section_id');
    }
    
}
