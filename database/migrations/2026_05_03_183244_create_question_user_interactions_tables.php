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
        // Likes Pivot Table
        Schema::create('question_user_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            // একজন ইউজার একটি প্রশ্নে একবারই লাইক দিতে পারবে
            $table->unique(['question_id', 'user_id']);
        });

        // Bookmarks Pivot Table
        Schema::create('question_user_bookmarks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            // একজন ইউজার একটি প্রশ্ন একবারই বুকমার্ক করতে পারবে
            $table->unique(['question_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_user_bookmarks');
        Schema::dropIfExists('question_user_likes');
    }
};
