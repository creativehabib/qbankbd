<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('past_exams', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('slug')->nullable()->unique();
            $table->unsignedBigInteger('institution_id')->nullable()->index('past_exams_institution_id_foreign');
            $table->unsignedBigInteger('exam_category_id')->nullable()->index('past_exams_exam_category_id_foreign');
            $table->date('exam_date')->nullable();
            $table->string('grade')->nullable();
            $table->integer('total_marks')->nullable();
            $table->integer('duration')->nullable()->comment('Exam duration in minutes');
            $table->integer('total_questions')->nullable();
            $table->text('description')->nullable();
            $table->string('type')->default('mcq');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('past_exams');
    }
};
