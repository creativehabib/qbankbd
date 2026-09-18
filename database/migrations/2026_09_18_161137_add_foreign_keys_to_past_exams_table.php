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
            $table->foreign(['exam_category_id'])->references(['id'])->on('exam_categories')->onUpdate('no action')->onDelete('set null');
            $table->foreign(['institution_id'])->references(['id'])->on('institutions')->onUpdate('no action')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('past_exams', function (Blueprint $table) {
            $table->dropForeign('past_exams_exam_category_id_foreign');
            $table->dropForeign('past_exams_institution_id_foreign');
        });
    }
};
