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
        Schema::create('model_test_user_answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('model_test_result_id')->index('model_test_user_answers_model_test_result_id_foreign');
            $table->unsignedBigInteger('question_id')->index('model_test_user_answers_question_id_foreign');
            $table->unsignedBigInteger('subject_id')->nullable()->index('model_test_user_answers_subject_id_foreign');
            $table->boolean('is_correct')->default(false);
            $table->boolean('is_skipped')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('model_test_user_answers');
    }
};
