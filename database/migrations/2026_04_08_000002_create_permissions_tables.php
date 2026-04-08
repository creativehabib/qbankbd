<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('permissions', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('role_permissions', function (Blueprint $table): void {
            $table->id();
            $table->string('role');
            $table->foreignId('permission_id')->constrained('permissions')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['role', 'permission_id']);
        });

        Schema::create('user_permissions', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('permission_id')->constrained('permissions')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['user_id', 'permission_id']);
        });

        $timestamp = now();

        DB::table('permissions')->insert([
            ['name' => 'Read Questions', 'slug' => 'questions.read', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['name' => 'Read All Questions', 'slug' => 'questions.read_all', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['name' => 'Create Questions', 'slug' => 'questions.create', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['name' => 'Update Questions', 'slug' => 'questions.update', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['name' => 'Delete Questions', 'slug' => 'questions.delete', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['name' => 'Publish Questions', 'slug' => 'questions.publish', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['name' => 'Manage Roles', 'slug' => 'users.manage_roles', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['name' => 'Manage Permissions', 'slug' => 'users.manage_permissions', 'created_at' => $timestamp, 'updated_at' => $timestamp],
        ]);

        $permissionIds = DB::table('permissions')->pluck('id', 'slug');

        $roleMap = [
            'student' => ['questions.read'],
            'teacher' => ['questions.read', 'questions.create', 'questions.update', 'questions.delete'],
            'admin' => [
                'questions.read',
                'questions.read_all',
                'questions.create',
                'questions.update',
                'questions.delete',
                'questions.publish',
            ],
            'super_admin' => [
                'questions.read',
                'questions.read_all',
                'questions.create',
                'questions.update',
                'questions.delete',
                'questions.publish',
                'users.manage_roles',
                'users.manage_permissions',
            ],
        ];

        $rolePermissionRows = [];

        foreach ($roleMap as $role => $slugs) {
            foreach ($slugs as $slug) {
                $permissionId = $permissionIds[$slug] ?? null;

                if ($permissionId !== null) {
                    $rolePermissionRows[] = [
                        'role' => $role,
                        'permission_id' => $permissionId,
                        'created_at' => $timestamp,
                        'updated_at' => $timestamp,
                    ];
                }
            }
        }

        DB::table('role_permissions')->insert($rolePermissionRows);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_permissions');
        Schema::dropIfExists('role_permissions');
        Schema::dropIfExists('permissions');
    }
};
