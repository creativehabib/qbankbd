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
        Schema::create('model_tests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->integer('duration_minutes')->default(30);
            $table->decimal('negative_mark_weight', 4)->default(0)->comment('e.g. 0.25, 0.50');
            $table->integer('total_marks')->default(0);
            $table->boolean('is_published')->default(false);
            $table->boolean('is_premium')->default(false);
            $table->unsignedBigInteger('package_id')->nullable()->index('model_tests_package_id_foreign');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('model_tests');
    }
};
