<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model {
    use HasFactory;

    protected $table = 'school_classes';

    protected $fillable = [ 'name', 'field1' ];

    public function sections() {
        return $this->hasMany( Section::class );
    }
    
    public function students() {
        return $this->hasMany( Student::class, 'class_id' );
    }

    public function subjects() {
        return $this->hasMany( Subject::class );
    }

    public function teacher() {
        return $this->belongsTo( Teacher::class, 'teacher_id' );
    }

    // public function exams()
    // {
    //     return $this->hasMany( Exam::class );
    // }

}