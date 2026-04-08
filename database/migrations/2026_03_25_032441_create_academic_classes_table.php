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
        Schema::create('academic_classes', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique(); // API & Security
            $table->string('name'); // যেমন: HSC, SSC, BCS
            $table->string('slug')->unique(); // SEO URL
            $table->text('description')->nullable();
            $table->string('image')->nullable();

            $table->integer('order_sequence')->default(0); // কাস্টম সিরিয়াল মেইনটেইন করার জন্য
            $table->boolean('is_active')->default(true); // string('active') এর চেয়ে ফাস্ট
            $table->boolean('is_premium')->default(false); // string('no') এর চেয়ে ফাস্ট

            $table->softDeletes(); // ট্র্যাশ বা রিসাইকেল বিন সুবিধার জন্য
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic_classes');
    }
};
