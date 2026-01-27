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
        Schema::create('user_transactions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->enum('type', ['deposit','withdraw']);
        $table->unsignedBigInteger('amount');
        $table->unsignedBigInteger('user_share')->default(0);
        $table->unsignedBigInteger('admin_share')->default(0);
        $table->string('status')->default('pending'); // pending, completed, failed
        $table->string('payment_gateway')->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_transactions');
    }
};
