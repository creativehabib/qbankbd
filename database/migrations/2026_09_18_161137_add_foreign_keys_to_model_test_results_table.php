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
        Schema::table('model_test_results', function (Blueprint $table) {
            $table->foreign(['model_test_id'])->references(['id'])->on('model_tests')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['user_id'])->references(['id'])->on('users')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('model_test_results', function (Blueprint $table) {
            $table->dropForeign('model_test_results_model_test_id_foreign');
            $table->dropForeign('model_test_results_user_id_foreign');
        });
    }
};
