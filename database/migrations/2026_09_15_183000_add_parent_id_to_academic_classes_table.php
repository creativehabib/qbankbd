<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('academic_classes', function (Blueprint $table) {
            $table->foreignId('parent_id')->nullable()->after('uuid')->constrained('academic_classes')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('academic_classes', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn('parent_id');
        });
    }
};
