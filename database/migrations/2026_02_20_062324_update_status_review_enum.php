<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    DB::statement("
        ALTER TABLE plant_submissions 
        MODIFY status_review 
        ENUM('pending','approved','rejected','revision_submitted') 
        DEFAULT 'pending'
    ");
}

public function down()
{
    DB::statement("
        ALTER TABLE plant_submissions 
        MODIFY status_review 
        ENUM('pending','approved','rejected') 
        DEFAULT 'pending'
    ");
}

};
