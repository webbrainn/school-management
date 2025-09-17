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
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('class_id');
            $table->unsignedBigInteger('teacher_id')->nullable();
            $table->string('status')->default('active'); // active, inactive
            $table->string('description')->nullable();
            $table->integer('capacity')->default(30); // Default capacity, can be adjusted
            $table->integer('students_count')->default(0); // To track the number of students in the section
            $table->string('field1')->nullable();
            $table->integer('field2')->nullable();

            $table->foreign('class_id')->references('id')->on('school_classes')->onDelete('cascade');
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('set null');
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
        Schema::dropIfExists('sections');
    }
};
