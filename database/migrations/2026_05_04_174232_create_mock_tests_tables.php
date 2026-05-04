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
        // ১. মূল মক টেস্ট টেবিল
        Schema::create('mock_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('academic_class_id')->nullable()->constrained()->nullOnDelete(); // ঐচ্ছিক
            $table->foreignId('subject_id')->nullable()->constrained()->nullOnDelete(); // ঐচ্ছিক (পুরো বিষয়ের ওপর পরীক্ষা হলে)
            $table->integer('total_questions'); // মোট কতগুলো প্রশ্ন
            $table->integer('duration_minutes'); // পরীক্ষার সময় (মিনিটে)
            $table->integer('correct_answers')->default(0); // কয়টি সঠিক উত্তর দিয়েছে
            $table->integer('wrong_answers')->default(0); // কয়টি ভুল উত্তর দিয়েছে
            $table->decimal('total_score', 8, 2)->default(0); // মোট প্রাপ্ত নম্বর (নেগেটিভ মার্কিং থাকলে কাজে লাগবে)
            $table->enum('status', ['started', 'completed'])->default('started'); // পরীক্ষার বর্তমান অবস্থা
            $table->timestamp('started_at')->useCurrent(); // কখন শুরু করেছে
            $table->timestamp('completed_at')->nullable(); // কখন শেষ বা সাবমিট করেছে
            $table->timestamps();
        });

        // ২. মক টেস্টের প্রশ্ন এবং ইউজারের দেওয়া উত্তর সেভ রাখার টেবিল
        Schema::create('mock_test_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mock_test_id')->constrained('mock_tests')->cascadeOnDelete();
            $table->foreignId('question_id')->constrained()->cascadeOnDelete();
            $table->string('user_answer')->nullable(); // ইউজারের সিলেক্ট করা অপশন (যেমন: 'ক', 'খ' বা 'A', 'B')
            $table->boolean('is_correct')->default(false); // উত্তরটি সঠিক ছিল কি না
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mock_test_questions');
        Schema::dropIfExists('mock_tests');
    }
};
