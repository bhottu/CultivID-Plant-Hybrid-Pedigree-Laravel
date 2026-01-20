<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('plants', function (Blueprint $table) {
        $table->id();
        $table->string('common_name');
        $table->string('synonym')->nullable();
        $table->string('genus');
        $table->string('family');
        $table->string('origin');
        $table->string('breeder');
        $table->text('description');
        $table->json('photos')->nullable(); // Menggunakan JSON untuk menyimpan URL foto
        $table->unsignedBigInteger('user_id');
        $table->unsignedBigInteger('edited_by')->nullable(); // Untuk menyimpan ID user yang mengedit
        $table->enum('status', ['available', 'editing', 'revised'])->default('available'); // Status pengeditan
        $table->timestamps();

        // Foreign key constraints
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('edited_by')->references('id')->on('users')->onDelete('set null');
    });
}



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plants');
    }
};
