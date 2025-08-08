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
            $table->string('name');
            $table->text('description');
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->integer('duration')->default(10);   // duration in minutes
            $table->integer('attemptes')->default(10);
            $table->integer('question_per_page')->default(1);
            $table->float('total_marks')->default(0); // مجموع درجات الأسئلة فعليًا
            $table->float('maximum_grade')->default(100); // الدرجة النهائية المعتمدة لحساب النتيجة
            $table->boolean('shuffle_questions')->default(false);

            $table->foreignId('subject_id')->references('id')->on('subjects')->onDelete('cascade');
            $table->foreignId('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
            $table->boolean('show_answers')->default(false)->nullable();
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
