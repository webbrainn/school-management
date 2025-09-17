<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{ 
    use HasFactory;

    protected $fillable = [
        'first_name', 'last_name', 'email', 'phone', 'dob', 'gender', 'address', 'class_id', 
        'section_id', 'roll_no', 'field1', 'field2'
    ];

    public function class()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

public function section()
{
    return $this->belongsTo(Section::class, 'section_id');
}

public function marks(){
    return $this->hasMany(Marks::class);
}

public function fees(){
    return $this->hasMany(Fee::class);
}

}

