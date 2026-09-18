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
        Schema::table('model_tests', function (Blueprint $table) {
            $table->foreign(['package_id'])->references(['id'])->on('packages')->onUpdate('no action')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('model_tests', function (Blueprint $table) {
            $table->dropForeign('model_tests_package_id_foreign');
        });
    }
};
