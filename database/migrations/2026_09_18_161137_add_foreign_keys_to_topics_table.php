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
        Schema::table('topics', function (Blueprint $table) {
            $table->foreign(['chapter_id'])->references(['id'])->on('chapters')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['subject_id'])->references(['id'])->on('subjects')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('topics', function (Blueprint $table) {
            $table->dropForeign('topics_chapter_id_foreign');
            $table->dropForeign('topics_subject_id_foreign');
        });
    }
};
