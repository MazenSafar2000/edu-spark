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
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');

            $table->foreignId('from_grade')->constrained('grades')->onDelete('cascade');
            $table->foreignId('from_classroom')->constrained('classrooms')->onDelete('cascade');
            $table->foreignId('from_section')->constrained('sections')->onDelete('cascade');

            $table->foreignId('to_grade')->constrained('grades')->onDelete('cascade');
            $table->foreignId('to_classroom')->constrained('classrooms')->onDelete('cascade');
            $table->foreignId('to_section')->constrained('sections')->onDelete('cascade');

            $table->string('academic_year');
            $table->string('academic_year_new');

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
        Schema::dropIfExists('promotions');
    }
};
