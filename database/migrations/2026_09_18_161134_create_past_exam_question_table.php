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
        Schema::create('past_exam_question', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('past_exam_id')->index('past_exam_question_past_exam_id_foreign');
            $table->unsignedBigInteger('question_id')->index('past_exam_question_question_id_foreign');
            $table->integer('order')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('past_exam_question');
    }
};
