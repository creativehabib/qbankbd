<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('past_exams', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // e.g. "মন্ত্রিপরিষদ বিভাগ (কম্পিউটার অপারেটর)"
            $table->foreignId('institution_id')->nullable()->constrained()->nullOnDelete();
            
            // Add exam category relation to map it to BCS, Bank, Class 9 etc.
            $table->foreignId('exam_category_id')->nullable()->constrained('exam_categories')->nullOnDelete();

            $table->date('exam_date')->nullable();
            $table->string('grade')->nullable(); // e.g. "৯ম গ্রেড - ১৩তম গ্রেড"
            $table->integer('total_marks')->nullable();
            $table->integer('total_questions')->nullable();
            $table->text('description')->nullable();
            
            $table->enum('type', ['mcq', 'written', 'both'])->default('mcq');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('past_exams');
    }
};
