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
        Schema::table('students', function (Blueprint $table) {
            //
             $table->unsignedInteger('roll_no');
             $table->unique('roll_no'); // uniqueness within a class
             $table->string('field1')->nullable();
             $table->string('field2')->nullable();    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            //
            $table->dropUnique(['class_id', 'roll_no']);
            $table->dropColumn('roll_no');
            $table->dropColumn('field1');
            $table->dropColumn('field2');
        });
    }
};
