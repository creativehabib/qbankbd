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
        Schema::table('model_test_user_answers', function (Blueprint $table) {
            $table->foreign(['model_test_result_id'])->references(['id'])->on('model_test_results')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['question_id'])->references(['id'])->on('questions')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['subject_id'])->references(['id'])->on('subjects')->onUpdate('no action')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('model_test_user_answers', function (Blueprint $table) {
            $table->dropForeign('model_test_user_answers_model_test_result_id_foreign');
            $table->dropForeign('model_test_user_answers_question_id_foreign');
            $table->dropForeign('model_test_user_answers_subject_id_foreign');
        });
    }
};
