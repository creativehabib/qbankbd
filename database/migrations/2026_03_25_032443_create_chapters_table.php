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
        Schema::create('chapters', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('subject_id')->constrained()->cascadeOnDelete();

            $table->string('name');
            $table->string('chapter_no')->nullable(); // যেমন: 'অধ্যায়-১' বা 'Chapter-01'
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('image')->nullable();

            $table->integer('order_sequence')->default(0); // বইয়ের সূচিপত্রের মতো সাজানোর জন্য
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
        Schema::dropIfExists('chapters');
    }
};
