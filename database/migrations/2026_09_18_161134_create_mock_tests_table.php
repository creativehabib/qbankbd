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
        Schema::create('mock_tests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index('mock_tests_user_id_foreign');
            $table->unsignedBigInteger('academic_class_id')->nullable()->index('mock_tests_academic_class_id_foreign');
            $table->unsignedBigInteger('subject_id')->nullable()->index('mock_tests_subject_id_foreign');
            $table->integer('total_questions');
            $table->integer('duration_minutes');
            $table->integer('correct_answers')->default(0);
            $table->integer('wrong_answers')->default(0);
            $table->decimal('total_score')->default(0);
            $table->enum('status', ['started', 'completed'])->default('started');
            $table->string('exam_type')->default('digital');
            $table->timestamp('started_at')->useCurrent();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mock_tests');
    }
};
