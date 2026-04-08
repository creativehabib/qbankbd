<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->foreignId('role_id')->nullable()->after('role')->constrained('roles')->nullOnDelete();
        });

        Schema::table('role_permissions', function (Blueprint $table): void {
            $table->foreignId('role_id')->nullable()->after('id')->constrained('roles')->cascadeOnDelete();
        });

        DB::table('users')
            ->join('roles', 'roles.slug', '=', 'users.role')
            ->update(['users.role_id' => DB::raw('roles.id')]);

        DB::table('role_permissions')
            ->join('roles', 'roles.slug', '=', 'role_permissions.role')
            ->update(['role_permissions.role_id' => DB::raw('roles.id')]);

        Schema::table('role_permissions', function (Blueprint $table): void {
            $table->dropUnique(['role', 'permission_id']);
            $table->unique(['role_id', 'permission_id']);
        });
    }

    public function down(): void
    {
        Schema::table('role_permissions', function (Blueprint $table): void {
            $table->dropUnique(['role_id', 'permission_id']);
            $table->unique(['role', 'permission_id']);
            $table->dropConstrainedForeignId('role_id');
        });

        Schema::table('users', function (Blueprint $table): void {
            $table->dropConstrainedForeignId('role_id');
        });
    }
};
