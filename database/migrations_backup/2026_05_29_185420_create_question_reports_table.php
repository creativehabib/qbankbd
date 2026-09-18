<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('question_reports', function (Blueprint $table) {
            $table->id();
            // কোন স্টুডেন্ট রিপোর্ট করেছে
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // কোন প্রশ্নে ভুল রিপোর্ট করা হয়েছে
            $table->foreignId('question_id')->constrained()->onDelete('cascade');
            // ভুলের ধরণ (wrong_answer, typing_mistake ইত্যাদি)
            $table->string('reason');
            // স্টুডেন্টের দেওয়া বিস্তারিত নোট
            $table->text('description')->nullable();
            // এডমিন এটি সমাধান করেছেন কি না (ভবিষ্যতের ট্র্যাকিংয়ের জন্য)
            $table->boolean('is_resolved')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('question_reports');
    }
};
