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
        Schema::table('past_exam_question', function (Blueprint $table) {
            $table->foreign(['past_exam_id'])->references(['id'])->on('past_exams')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['question_id'])->references(['id'])->on('questions')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('past_exam_question', function (Blueprint $table) {
            $table->dropForeign('past_exam_question_past_exam_id_foreign');
            $table->dropForeign('past_exam_question_question_id_foreign');
        });
    }
};
