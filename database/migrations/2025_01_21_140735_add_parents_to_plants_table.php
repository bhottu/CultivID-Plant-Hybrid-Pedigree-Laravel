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
    Schema::table('plants', function (Blueprint $table) {
        $table->unsignedBigInteger('female_parents_id')->nullable()->after('breeder');
        $table->unsignedBigInteger('male_parents_id')->nullable()->after('female_parents_id');
        
        // Tambahkan foreign key jika diperlukan
        $table->foreign('female_parents_id')->references('id')->on('plants')->onDelete('set null');
        $table->foreign('male_parents_id')->references('id')->on('plants')->onDelete('set null');
    });
}

public function down()
{
    Schema::table('plants', function (Blueprint $table) {
        $table->dropForeign(['female_parents_id']);
        $table->dropForeign(['male_parents_id']);
        $table->dropColumn(['female_parents_id', 'male_parents_id']);
    });
}

};
