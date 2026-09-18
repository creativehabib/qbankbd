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
        Schema::table('mock_tests', function (Blueprint $table) {
            $table->foreign(['academic_class_id'])->references(['id'])->on('academic_classes')->onUpdate('no action')->onDelete('set null');
            $table->foreign(['subject_id'])->references(['id'])->on('subjects')->onUpdate('no action')->onDelete('set null');
            $table->foreign(['user_id'])->references(['id'])->on('users')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mock_tests', function (Blueprint $table) {
            $table->dropForeign('mock_tests_academic_class_id_foreign');
            $table->dropForeign('mock_tests_subject_id_foreign');
            $table->dropForeign('mock_tests_user_id_foreign');
        });
    }
};
