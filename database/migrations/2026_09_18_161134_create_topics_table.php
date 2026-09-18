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
            $table->bigIncrements('id');
            $table->char('uuid', 36)->unique();
            $table->unsignedBigInteger('chapter_id')->index('topics_chapter_id_foreign');
            $table->unsignedBigInteger('subject_id')->index('topics_subject_id_foreign');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('video_url')->nullable();
            $table->string('attachment_url')->nullable();
            $table->integer('order_sequence')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_premium')->default(false);
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
