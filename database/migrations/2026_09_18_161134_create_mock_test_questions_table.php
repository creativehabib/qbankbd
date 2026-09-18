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
        Schema::create('mock_test_questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('mock_test_id')->index('mock_test_questions_mock_test_id_foreign');
            $table->unsignedBigInteger('question_id')->index('mock_test_questions_question_id_foreign');
            $table->string('user_answer')->nullable();
            $table->boolean('is_correct')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mock_test_questions');
    }
};
