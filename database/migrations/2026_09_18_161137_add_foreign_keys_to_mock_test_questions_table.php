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
        Schema::table('mock_test_questions', function (Blueprint $table) {
            $table->foreign(['mock_test_id'])->references(['id'])->on('mock_tests')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['question_id'])->references(['id'])->on('questions')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mock_test_questions', function (Blueprint $table) {
            $table->dropForeign('mock_test_questions_mock_test_id_foreign');
            $table->dropForeign('mock_test_questions_question_id_foreign');
        });
    }
};
