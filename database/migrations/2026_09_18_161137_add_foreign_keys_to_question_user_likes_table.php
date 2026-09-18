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
        Schema::table('question_user_likes', function (Blueprint $table) {
            $table->foreign(['question_id'])->references(['id'])->on('questions')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['user_id'])->references(['id'])->on('users')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('question_user_likes', function (Blueprint $table) {
            $table->dropForeign('question_user_likes_question_id_foreign');
            $table->dropForeign('question_user_likes_user_id_foreign');
        });
    }
};
