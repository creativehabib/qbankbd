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
            $table->id();

            // সিকিউরিটি এবং API এর জন্য UUID (অটোমেটিক জেনারেট হবে)
            $table->uuid('uuid')->unique();

            // Question Content
            $table->text('title'); // Math বা HTML থাকতে পারে তাই text
            $table->string('slug')->unique();
            $table->longText('description')->nullable();

            // MCQ অপশন বা CQ এর অংশগুলো এখানে JSON আকারে থাকবে
            $table->json('extra_content')->nullable();

            // Question Meta & Settings
            $table->enum('difficulty', ['easy', 'medium', 'hard'])->default('easy');
            $table->enum('question_type', ['mcq', 'cq', 'short', 'written'])->default('mcq');
            $table->decimal('marks', 8, 2)->default(0);
            $table->enum('status', ['active', 'pending', 'inactive'])->default('active');
            $table->boolean('is_premium')->default(false); // Boolean ব্যবহার করা হয়েছে
            $table->unsignedBigInteger('views')->default(0);
            $table->string('image')->nullable();

            // Relations (Denormalized for Fast Read)
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('academic_class_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained()->cascadeOnDelete();
            $table->foreignId('chapter_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('topic_id')->nullable()->constrained()->cascadeOnDelete();

            $table->softDeletes();
            $table->timestamps();

            // পারফরম্যান্স অপ্টিমাইজেশনের জন্য Indexing
            $table->index(['academic_class_id', 'subject_id', 'chapter_id']);
            $table->index(['status', 'is_premium']);
            $table->index('question_type');
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
