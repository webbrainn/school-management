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
        Schema::create('fees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('class_id')->constrained('school_classes')->onDelete('cascade');
            $table->foreignId('section_id')->constrained('sections')->onDelete('cascade'); 
            $table->string('month'); // e.g., 'January', 'February'
            $table->integer('year'); // e.g., 2025
            $table->decimal('fee_amount', 8, 2);
            $table->decimal('amount_paid', 8, 2);
            $table->decimal('amount_due', 8, 2);
            $table->integer('field1')->nullable();
            $table->integer('field2')->nullable();
            $table->string('field3')->nullable();
            $table->string('field4')->nullable();
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
        Schema::dropIfExists('fees');
    }
};
