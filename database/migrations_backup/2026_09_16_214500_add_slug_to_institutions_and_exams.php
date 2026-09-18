<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('institutions', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('name');
        });
        
        Schema::table('past_exams', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('title');
        });
    }

    public function down(): void
    {
        Schema::table('institutions', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
        
        Schema::table('past_exams', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
