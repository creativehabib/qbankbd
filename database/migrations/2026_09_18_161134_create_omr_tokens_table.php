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
        Schema::create('omr_tokens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('token_id')->unique();
            $table->unsignedBigInteger('omr_template_id')->index('omr_tokens_omr_template_id_foreign');
            $table->string('title');
            $table->json('answer_key')->nullable();
            $table->decimal('correct_mark', 4)->default(1);
            $table->decimal('negative_mark', 4)->default(0);
            $table->integer('total_questions');
            $table->string('created_by')->default('Habibur Rahaman');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('omr_tokens');
    }
};
