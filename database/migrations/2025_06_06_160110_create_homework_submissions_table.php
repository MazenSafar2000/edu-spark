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
        Schema::create('homework_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('homework_id')->constrained('homeworks')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->string('file_path')->nullable();
            $table->string('notes')->nullable();
            $table->dateTime('submitted_at')->nullable();
            $table->enum('delivery_status', ['submittedOnTime', 'submittedOutOfTime', 'notSubmitted'])->default('notSubmitted');
            $table->enum('evaluation_status', ['evaluated', 'notEvaluated'])->default('notEvaluated');
            $table->integer('degree')->nullable();
            $table->text('feedback')->nullable();
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
        Schema::dropIfExists('homework_submissions');
    }
};
