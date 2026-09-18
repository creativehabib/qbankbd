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
        Schema::table('badge_user', function (Blueprint $table) {
            $table->foreign(['badge_id'])->references(['id'])->on('badges')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['user_id'])->references(['id'])->on('users')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('badge_user', function (Blueprint $table) {
            $table->dropForeign('badge_user_badge_id_foreign');
            $table->dropForeign('badge_user_user_id_foreign');
        });
    }
};
