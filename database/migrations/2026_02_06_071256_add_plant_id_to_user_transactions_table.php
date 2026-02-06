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
            $table->unsignedBigInteger('plant_id')->nullable()->after('user_id_receiver');

            // optional FK (kalau plant_id adalah PK di plant_submissions)
            // $table->foreign('plant_id')
            //       ->references('plant_id')
            //       ->on('plant_submissions')
            //       ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('user_transactions', function (Blueprint $table) {
            // $table->dropForeign(['plant_id']);
            $table->dropColumn('plant_id');
        });
    }
};
