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
        Schema::create('omr_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');                      // টেমপ্লেটের নাম (যেমন: সাধারণ, সিগনেচার)
            $table->string('unique_code')->unique();     // ইউনিক ওএমআর কোড (যেমন: 13160)
            $table->integer('total_questions');          // মোট প্রশ্ন (যেমন: ৬০ বা ১০০)
            $table->integer('columns');                  // কলাম সংখ্যা (যেমন: ৩ বা ৪)
            $table->string('type')->default('standard'); // টেমপ্লেটের টাইপ
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('omr_templates');
    }
};
