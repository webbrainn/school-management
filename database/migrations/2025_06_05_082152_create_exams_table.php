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
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->string('exam_name');
            $table->string('term'); // e.g., Term 1
            $table->date('exam_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('max_marks');
            $table->integer('pass_marks');
            $table->string('session')->nullable();
			$table->integer('internal_pass_marks')->nullable();
            $table->integer('internal_max_marks')->nullable();
			$table->string('field1')->nullable();
            $table->string('field2')->nullable();
            $table->integer('field3')->nullable();

            $table->foreignId('school_classes_id')->constrained('school_classes')->onDelete('cascade');
            $table->foreignId('section_id')->constrained('sections')->onDelete('cascade');
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade'); 
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
        Schema::dropIfExists('exams');
    }
};
