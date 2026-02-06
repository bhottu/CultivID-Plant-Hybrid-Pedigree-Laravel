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
        Schema::table('user_transactions', function (Blueprint $table) {
    $table->unsignedBigInteger('related_id')->nullable()->after('type');
    // untuk plant_submission_id / certificate_id

    $table->boolean('is_platform_only')->default(false)->after('admin_share');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_transactions', function (Blueprint $table) {
            //
        });
    }
};
