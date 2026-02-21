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
            Schema::create('notifications', function (Blueprint $table) {
                $table->id();

                $table->unsignedBigInteger('user_id'); // penerima
                $table->unsignedBigInteger('from_user_id')->nullable(); // pelaku aksi

                $table->string('type'); // post_liked, post_commented, plant_rejected

                $table->unsignedBigInteger('notifiable_id')->nullable();
                $table->string('notifiable_type')->nullable();

                $table->json('data')->nullable();

                $table->boolean('is_read')->default(false);

                $table->timestamps();

                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('from_user_id')->references('id')->on('users')->onDelete('cascade');
            });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
