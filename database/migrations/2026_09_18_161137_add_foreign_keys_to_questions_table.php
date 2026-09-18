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
        Schema::table('questions', function (Blueprint $table) {
            $table->foreign(['chapter_id'])->references(['id'])->on('chapters')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['subject_id'])->references(['id'])->on('subjects')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['topic_id'])->references(['id'])->on('topics')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['user_id'])->references(['id'])->on('users')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropForeign('questions_chapter_id_foreign');
            $table->dropForeign('questions_subject_id_foreign');
            $table->dropForeign('questions_topic_id_foreign');
            $table->dropForeign('questions_user_id_foreign');
        });
    }
};
