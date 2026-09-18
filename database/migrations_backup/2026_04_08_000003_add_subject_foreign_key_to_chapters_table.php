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
        if (! Schema::hasTable('chapters') || ! Schema::hasTable('subjects')) {
            return;
        }

        Schema::table('chapters', function (Blueprint $table): void {
            $table->foreign('subject_id')->references('id')->on('subjects')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('chapters')) {
            return;
        }

        Schema::table('chapters', function (Blueprint $table): void {
            $table->dropForeign(['subject_id']);
        });
    }
};
