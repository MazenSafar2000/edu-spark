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
        Schema::create('exam_attempts', function (Blueprint $table) {
            // $table->id();
            // $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            // $table->foreignId('exam_id')->constrained('exams')->onDelete('cascade');
            // $table->dateTime('started_at');
            // $table->dateTime('ended_at')->nullable();
            // $table->boolean('completed')->default(false);
            // $table->float('score')->nullable();
            // $table->json('answers')->nullable(); // لحفظ الاجابات مؤقتًا
            // $table->timestamps();

            // $table->id();
            // $table->foreignId('exam_id')->constrained()->onDelete('cascade');
            // $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            // $table->integer('attempt_number');
            // $table->integer('current_question_index')->default(0);
            // $table->integer('time_left'); // بالثواني
            // $table->enum('status', ['in_progress', 'completed', 'abandoned'])->default('in_progress');
            // $table->timestamps();

            $table->id();
            $table->foreignId('exam_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->integer('attempt_number');
            $table->integer('current_question_index')->default(0);
            $table->integer('time_left'); // seconds
            $table->enum('status', ['in_progress', 'completed', 'abandoned'])->default('in_progress');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ended_at')->nullable();
            $table->float('score_obtained')->nullable();
            $table->float('grade_obtained')->nullable();
            $table->json('question_order')->nullable();
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
        Schema::dropIfExists('exam_attempts');
    }
};
