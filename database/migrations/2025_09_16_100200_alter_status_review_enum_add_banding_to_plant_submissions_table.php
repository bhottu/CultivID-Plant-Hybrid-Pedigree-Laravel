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
        // Ubah enum status_review, tambahkan 'banding'
        DB::statement("ALTER TABLE plant_submissions MODIFY status_review ENUM('pending', 'approved', 'rejected', 'banding') DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan ke enum awal tanpa 'banding'
        DB::statement("ALTER TABLE plant_submissions MODIFY status_review ENUM('pending', 'approved', 'rejected') DEFAULT 'pending'");
    }
};
