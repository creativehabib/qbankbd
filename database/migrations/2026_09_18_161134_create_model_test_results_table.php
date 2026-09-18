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
        Schema::create('model_test_results', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('model_test_id')->index('model_test_results_model_test_id_foreign');
            $table->unsignedBigInteger('user_id')->index('model_test_results_user_id_foreign');
            $table->integer('correct_count')->default(0);
            $table->integer('wrong_count')->default(0);
            $table->integer('unanswered_count')->default(0);
            $table->decimal('total_score')->default(0);
            $table->integer('time_taken_seconds')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('model_test_results');
    }
};
