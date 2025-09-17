<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'short_name', 'class_id', 'teacher_id', 'section_id', 'status', 'description', 'field1', 'field2'];

    public function class()
    {
        return $this->belongsTo(SchoolClass::class); // Assuming class model is SchoolClass
    }

    public function section()
    {
        return $this->belongsTo(Section::class); // Assuming section model is Section
    }

    public function teacher()
    {
        // return $this->belongsTo(User::class, 'teacher_id');
        return $this->belongsTo(Teacher::class);
    }
    
}
