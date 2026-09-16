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
            // Modify enum to string to avoid future enum issues
            $table->string('type')->default('mcq')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('past_exams', function (Blueprint $table) {
            $table->enum('type', ['mcq', 'written', 'both'])->default('mcq')->change();
        });
    }
};
