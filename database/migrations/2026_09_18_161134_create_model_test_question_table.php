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
        Schema::create('model_test_question', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('model_test_id')->index('model_test_question_model_test_id_foreign');
            $table->unsignedBigInteger('question_id')->index('model_test_question_question_id_foreign');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('model_test_question');
    }
};
