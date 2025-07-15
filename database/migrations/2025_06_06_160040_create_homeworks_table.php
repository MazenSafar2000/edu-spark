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
        Schema::create('homeworks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('teachers')->onDelete('cascade');
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->integer('total_degree');
            $table->foreignId('grade_id')->references('id')->on('Grades')->onDelete('cascade');
            $table->foreignId('classroom_id')->references('id')->on('Classrooms')->onDelete('cascade');
            $table->foreignId('section_id')->references('id')->on('sections')->onDelete('cascade');
            $table->json('allowed_file_types');
            $table->boolean('allow_multiple_submissions')->default(false);
            $table->dateTime('due_date');
            $table->string('attachment_path')->nullable();
            $table->foreignId('created_by_teacher_id')->constrained('teachers');
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
        Schema::dropIfExists('homework');
    }
};
