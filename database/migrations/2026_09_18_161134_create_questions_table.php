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
        Schema::create('questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('uuid', 36)->unique();
            $table->text('title');
            $table->string('slug')->unique();
            $table->longText('description')->nullable();
            $table->json('extra_content')->nullable();
            $table->enum('difficulty', ['easy', 'medium', 'hard'])->default('easy');
            $table->enum('question_type', ['mcq', 'cq', 'short', 'written'])->default('mcq')->index();
            $table->unsignedInteger('marks')->default(0);
            $table->enum('status', ['active', 'pending', 'inactive'])->default('active');
            $table->boolean('has_error')->default(false);
            $table->unsignedBigInteger('views_count')->default(0);
            $table->unsignedBigInteger('likes_count')->default(0);
            $table->unsignedBigInteger('bookmarks_count')->default(0);
            $table->boolean('is_premium')->default(false);
            $table->boolean('is_paid')->default(false);
            $table->unsignedBigInteger('views')->default(0);
            $table->string('image')->nullable();
            $table->unsignedBigInteger('user_id')->index('questions_user_id_foreign');
            $table->unsignedBigInteger('subject_id');
            $table->unsignedBigInteger('chapter_id')->nullable()->index('questions_chapter_id_foreign');
            $table->unsignedBigInteger('topic_id')->nullable()->index();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['subject_id', 'chapter_id'], 'questions_academic_class_id_subject_id_chapter_id_index');
            $table->index(['status', 'is_premium']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
