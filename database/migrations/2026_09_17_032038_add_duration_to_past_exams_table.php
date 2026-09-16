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
        Schema::table('past_exams', function (Blueprint $table) {
            $table->integer('duration')->nullable()->after('total_marks')->comment('Exam duration in minutes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('past_exams', function (Blueprint $table) {
            $table->dropColumn('duration');
        });
    }
};
