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
        Schema::create('graduates', function (Blueprint $table) {
            $table->id();

            $table->foreignId('student_id')->nullable()->constrained('students')->onDelete('set null');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // still link to user

            // Store old school info (at the moment of graduation)
            $table->string('name');
            $table->string('email');
            $table->string('National_ID');
            $table->string('parent_name');
            $table->string('grade');
            $table->string('classroom');
            $table->string('section');
            $table->string('academic_year');
            $table->date('Date_Birth');

            // Graduation details
            $table->date('graduated_at')->nullable();
            $table->string('reason')->nullable(); // e.g., "finished school", "transferred", etc.


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
        Schema::dropIfExists('graduates');
    }
};
