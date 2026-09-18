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
        Schema::create('exam_category_question', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('question_id')->index('exam_category_question_question_id_foreign');
            $table->unsignedBigInteger('exam_category_id')->index('exam_category_question_exam_category_id_foreign');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_category_question');
    }
};
