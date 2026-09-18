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
        Schema::table('model_test_question', function (Blueprint $table) {
            $table->foreign(['model_test_id'])->references(['id'])->on('model_tests')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['question_id'])->references(['id'])->on('questions')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('model_test_question', function (Blueprint $table) {
            $table->dropForeign('model_test_question_model_test_id_foreign');
            $table->dropForeign('model_test_question_question_id_foreign');
        });
    }
};
