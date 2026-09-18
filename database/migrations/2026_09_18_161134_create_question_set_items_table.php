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
        Schema::create('question_set_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('question_set_id', 36)->nullable();
            $table->unsignedBigInteger('question_id')->nullable()->index('question_set_items_question_id_foreign');
            $table->unsignedInteger('order')->default(0);
            $table->timestamps();

            $table->unique(['question_set_id', 'question_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_set_items');
    }
};
