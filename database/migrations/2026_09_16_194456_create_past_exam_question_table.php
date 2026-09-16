<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('past_exam_question', function (Blueprint $table) {
            $table->id();
            $table->foreignId('past_exam_id')->constrained()->cascadeOnDelete();
            $table->foreignId('question_id')->constrained()->cascadeOnDelete();
            $table->integer('order')->default(0); // To preserve question order
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('past_exam_question');
    }
};
