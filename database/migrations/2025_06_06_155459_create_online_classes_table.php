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
        Schema::create('online_classes', function (Blueprint $table) {
            $table->id();
            $table->boolean('integration');
            $table->foreignId('Grade_id')->references('id')->on('Grades')->onDelete('cascade');
            $table->foreignId('Classroom_id')->references('id')->on('Classrooms')->onDelete('cascade');
            $table->foreignId('section_id')->references('id')->on('sections')->onDelete('cascade');
            $table->string('created_by');   // treacher gmail
            $table->foreignId('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
            $table->foreignId('subject_id')->references('id')->on('subjects')->onDelete('cascade');
            $table->string('meeting_id');
            $table->string('topic');
            $table->dateTime('start_at');
            $table->integer('duration')->comment('minutes');
            $table->string('password')->comment('meeting password');
            $table->text('start_url');
            $table->text('join_url');
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
        Schema::dropIfExists('online_classes');
    }
};
