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
        Schema::table('academic_classes', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('subjects', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('chapters', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('topics', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('academic_classes', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('subjects', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('chapters', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('topics', function (Blueprint $table) {
            $table->softDeletes();
        });
    }
};
