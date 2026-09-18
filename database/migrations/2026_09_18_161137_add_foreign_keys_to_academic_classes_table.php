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
            $table->foreign(['parent_id'])->references(['id'])->on('academic_classes')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('academic_classes', function (Blueprint $table) {
            $table->dropForeign('academic_classes_parent_id_foreign');
        });
    }
};
