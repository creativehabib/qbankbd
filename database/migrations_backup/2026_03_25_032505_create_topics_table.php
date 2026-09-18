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
        Schema::create('topics', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('chapter_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained()->cascadeOnDelete();

            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();

            // অ্যাডভান্সড ফিচার: ভবিষ্যতে টপিকের আন্ডারে ভিডিও বা পিডিএফ দিতে চাইলে
            $table->string('video_url')->nullable();
            $table->string('attachment_url')->nullable(); // লেকচার শিট বা পিডিএফ লিংক

            $table->integer('order_sequence')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_premium')->default(false);

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topics');
    }
};
