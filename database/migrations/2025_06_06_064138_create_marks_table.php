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
        Schema::create('marks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('exam_id')->constrained('exams')->onDelete('cascade');
            $table->foreignId('class_id')->constrained('school_classes')->onDelete('cascade');
            $table->foreignId('section_id')->constrained('sections')->onDelete('cascade'); 
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade');
            $table->unique(['student_id', 'exam_id', 'subject_id', 'class_id', 'section_id']); // Ensure no duplicate entries
            $table->decimal('marks_obtained', 5, 2);
            $table->string('sheet_image')->nullable();
            $table->string('grade')->nullable();
            $table->string('description')->nullable();
            $table->string('term')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('roll_no')->nullable();
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
        Schema::dropIfExists('marks');
    }
};
