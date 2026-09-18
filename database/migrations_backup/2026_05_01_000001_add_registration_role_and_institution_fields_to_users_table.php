<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->string('registration_role')->default('student')->after('password');
            $table->string('institution_name')->nullable()->after('registration_role');
            $table->string('institution_type')->nullable()->after('institution_name');
            $table->text('institution_address')->nullable()->after('institution_type');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->dropColumn(['registration_role', 'institution_name', 'institution_type', 'institution_address']);
        });
    }
};
