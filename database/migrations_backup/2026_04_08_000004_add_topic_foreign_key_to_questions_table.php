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
        if (! Schema::hasTable('questions') || ! Schema::hasTable('topics')) {
            return;
        }

        Schema::table('questions', function (Blueprint $table): void {
            $table->foreign('topic_id')->references('id')->on('topics')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('questions')) {
            return;
        }

        Schema::table('questions', function (Blueprint $table): void {
            $table->dropForeign(['topic_id']);
        });
    }
};
