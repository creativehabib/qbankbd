<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('model_tests', function (Blueprint $table) {
            $table->boolean('is_premium')->default(false)->after('is_published');
            $table->foreignId('package_id')->nullable()->after('is_premium')->constrained('packages')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('model_tests', function (Blueprint $table) {
            $table->dropForeign(['package_id']);
            $table->dropColumn(['is_premium', 'package_id']);
        });
    }
};
