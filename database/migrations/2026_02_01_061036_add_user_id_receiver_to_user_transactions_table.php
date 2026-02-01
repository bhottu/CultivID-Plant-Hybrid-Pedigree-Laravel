<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id_receiver')->nullable()->after('user_id');

            // Jika mau, bisa tambahkan foreign key ke users.id
            $table->foreign('user_id_receiver')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('user_transactions', function (Blueprint $table) {
            $table->dropForeign(['user_id_receiver']);
            $table->dropColumn('user_id_receiver');
        });
    }
};
