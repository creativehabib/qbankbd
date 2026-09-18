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
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index('payments_user_id_foreign');
            $table->unsignedBigInteger('package_id')->index('payments_package_id_foreign');
            $table->string('transaction_id')->nullable()->unique();
            $table->decimal('amount', 10);
            $table->string('payment_method');
            $table->string('status')->default('pending');
            $table->json('payment_response')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
