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
        Schema::table('exam_category_question', function (Blueprint $table) {
            $table->foreign(['exam_category_id'])->references(['id'])->on('exam_categories')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['question_id'])->references(['id'])->on('questions')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exam_category_question', function (Blueprint $table) {
            $table->dropForeign('exam_category_question_exam_category_id_foreign');
            $table->dropForeign('exam_category_question_question_id_foreign');
        });
    }
};
