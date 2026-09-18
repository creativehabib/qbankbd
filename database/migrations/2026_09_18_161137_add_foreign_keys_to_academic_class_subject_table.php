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
        Schema::table('academic_class_subject', function (Blueprint $table) {
            $table->foreign(['academic_class_id'])->references(['id'])->on('academic_classes')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['subject_id'])->references(['id'])->on('subjects')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('academic_class_subject', function (Blueprint $table) {
            $table->dropForeign('academic_class_subject_academic_class_id_foreign');
            $table->dropForeign('academic_class_subject_subject_id_foreign');
        });
    }
};
