<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Create Pivot Tables
        Schema::create('academic_class_subject', function (Blueprint $table) {
            $table->id();
            $table->foreignId('academic_class_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained()->cascadeOnDelete();
            $table->string('custom_name')->nullable();
            $table->timestamps();
        });

        Schema::create('academic_class_question', function (Blueprint $table) {
            $table->id();
            $table->foreignId('academic_class_id')->constrained()->cascadeOnDelete();
            $table->foreignId('question_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });

        // 2. Data Migration
        // Move subject -> class relationships
        $subjects = DB::table('subjects')->whereNotNull('academic_class_id')->get();
        foreach ($subjects as $subject) {
            DB::table('academic_class_subject')->insert([
                'academic_class_id' => $subject->academic_class_id,
                'subject_id' => $subject->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Move question -> class relationships
        $questions = DB::table('questions')->whereNotNull('academic_class_id')->get();
        foreach ($questions as $question) {
            DB::table('academic_class_question')->insert([
                'academic_class_id' => $question->academic_class_id,
                'question_id' => $question->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 3. Drop Foreign Keys and Columns
        Schema::table('subjects', function (Blueprint $table) {
            $table->dropForeign(['academic_class_id']);
            $table->dropColumn('academic_class_id');
        });

        Schema::table('questions', function (Blueprint $table) {
            $table->dropForeign(['academic_class_id']);
            $table->dropColumn('academic_class_id');
        });
    }

    public function down(): void
    {
        Schema::table('subjects', function (Blueprint $table) {
            $table->foreignId('academic_class_id')->nullable()->constrained('academic_classes')->nullOnDelete();
        });

        Schema::table('questions', function (Blueprint $table) {
            $table->foreignId('academic_class_id')->nullable()->constrained('academic_classes')->nullOnDelete();
        });

        // Best effort data restoration
        $subjectPivots = DB::table('academic_class_subject')->get();
        foreach ($subjectPivots as $pivot) {
            DB::table('subjects')->where('id', $pivot->subject_id)->update(['academic_class_id' => $pivot->academic_class_id]);
        }

        $questionPivots = DB::table('academic_class_question')->get();
        foreach ($questionPivots as $pivot) {
            DB::table('questions')->where('id', $pivot->question_id)->update(['academic_class_id' => $pivot->academic_class_id]);
        }

        Schema::dropIfExists('academic_class_subject');
        Schema::dropIfExists('academic_class_question');
    }
};
