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
        Schema::create('academic_class_question', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('academic_class_id')->index('academic_class_question_academic_class_id_foreign');
            $table->unsignedBigInteger('question_id')->index('academic_class_question_question_id_foreign');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic_class_question');
    }
};
