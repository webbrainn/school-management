<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admission extends Model
{
    use HasFactory;

    protected $fillable = [
        'serial_no',
        'registration_no',
        'admission_no',
        'session',
        'imageUpload',
        'child_relation',
        'student_name_consent',
        'class_name_consent',
        'student_type',
        'student_name',
        'dob',
        'gender',
        'only_child',
        'adhaar_no',
        'email',
        'father_name',
        'father_qualification',
        'father_occupation',
        'mother_name',
        'mother_qualification',
        'mother_occupation',
        'address',
        'whatsapp_no',
        'mobile_no',
        'guardian_name',
        'guardian_relation',
        'nationality',
        'religion',
        'weight',
        'blood_group',
        'category',
        'last_exam_class',
        'last_exam_school',
        'last_exam_year',
        'last_exam_marks',
        'applying_for_class',
        'admitted_to_class',
        'admission_date',
        'language_subject',
        'subjects_offered',
        'aadhaar_card',
        'status',
    ];

    protected $dates = ['dob', 'admission_date'];

}
