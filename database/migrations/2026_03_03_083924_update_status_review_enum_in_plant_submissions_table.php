<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('plant_submissions', function (Blueprint $table) {
            $table->enum('status_review', [
                'pending',
                'approved',
                'rejected',
                'revision_submitted',
                'banding'
            ])->change();
        });
    }

    public function down(): void
    {
        Schema::table('plant_submissions', function (Blueprint $table) {
            $table->enum('status_review', [
                'pending',
                'approved',
                'rejected',
                'revision_submitted'
            ])->change();
        });
    }
};
