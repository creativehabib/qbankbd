<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('guard')->default('web');
            $table->timestamps();
        });

        $now = now();

        DB::table('roles')->insert([
            ['name' => 'Student', 'slug' => 'student', 'guard' => 'web', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Teacher', 'slug' => 'teacher', 'guard' => 'web', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Admin', 'slug' => 'admin', 'guard' => 'web', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Super Admin', 'slug' => 'super_admin', 'guard' => 'web', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
