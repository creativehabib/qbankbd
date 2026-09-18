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
        Schema::table('omr_tokens', function (Blueprint $table) {
            $table->foreign(['omr_template_id'])->references(['id'])->on('omr_templates')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('omr_tokens', function (Blueprint $table) {
            $table->dropForeign('omr_tokens_omr_template_id_foreign');
        });
    }
};
