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
        Schema::create('packages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('type')->default('subscription');
            $table->decimal('price', 10);
            $table->text('description')->nullable();
            $table->string('thumbnail_image')->nullable();
            $table->unsignedInteger('question_create_limit')->default(0);
            $table->unsignedInteger('page_view_limit')->nullable();
            $table->boolean('is_ad_free')->default(false);
            $table->unsignedInteger('validity_days')->default(30);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
