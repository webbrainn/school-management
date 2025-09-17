<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('admissions', function (Blueprint $table) {
        $table->id();
        $table->string('serial_no')->unique();
        $table->string('registration_no')->unique();
        $table->string('admission_no')->unique();
        $table->string('session');
        $table->string('imageUpload');
        $table->string('child_relation');
        $table->string('student_name_consent');
        $table->string('class_name_consent');
        $table->string('student_type');
        $table->string('student_name');
        $table->date('dob');
        $table->string('gender');
        $table->string('only_child');
        $table->string('aadhaar_no');
        $table->string('email');
        $table->string('father_name');
        $table->string('father_qualification');
        $table->string('father_occupation');
        $table->string('mother_name');
        $table->string('mother_qualification');
        $table->string('mother_occupation');
        $table->text('address');
        $table->string('whatsapp_no');
        $table->string('mobile_no');
        $table->string('guardian_name');
        $table->string('guardian_relation');
        $table->string('nationality');
        $table->string('religion');
        $table->string('weight');
        $table->string('blood_group');
        $table->string('category');
        $table->string('last_exam_class');
        $table->string('last_exam_school');
        $table->string('last_exam_year');
        $table->string('last_exam_marks');
        $table->string('applying_for_class');
        $table->string('admitted_to_class');
        $table->date('admission_date');
        $table->string('language_subject');
        $table->string('subjects_offered');
        $table->string('aadhaar_card');
        $table->enum('status', ['Pending', 'Approved'])->default('Pending');
        $table->string('field1')->nullable();
        $table->string('field2')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admissions');
    }
};