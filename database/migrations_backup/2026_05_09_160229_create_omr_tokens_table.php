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
            $table->id();
            $table->string('token_id')->unique();       // জেনারেট হওয়া টোকেন আইডি (TOK-XXXXXX)
            $table->foreignId('omr_template_id')->constrained()->onDelete('cascade');
            $table->string('title');                    // পরীক্ষার টাইটেল (যেমন: Example)
            $table->json('answer_key')->nullable();     // উত্তরপত্র [1 => "A", 2 => "C", ...]
            $table->decimal('correct_mark', 4, 2)->default(1.00);
            $table->decimal('negative_mark', 4, 2)->default(0.00);
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
