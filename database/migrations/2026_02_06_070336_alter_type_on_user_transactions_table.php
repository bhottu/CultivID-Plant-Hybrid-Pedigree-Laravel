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
    DB::statement("
        ALTER TABLE user_transactions
        MODIFY type ENUM('deposit','withdraw','certificate')
        NOT NULL
        COLLATE utf8mb4_unicode_ci
    ");
}

public function down()
{
    DB::statement("
        ALTER TABLE user_transactions
        MODIFY type ENUM('deposit','withdraw')
        NOT NULL
        COLLATE utf8mb4_unicode_ci
    ");
}

};
