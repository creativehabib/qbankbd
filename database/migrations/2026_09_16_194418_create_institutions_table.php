<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('institutions', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g. "জনপ্রশাসন মন্ত্রণালয়"
            $table->string('short_name')->nullable(); // e.g. "MOPA"
            $table->string('logo_path')->nullable(); // logo for the card
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('institutions');
    }
};
