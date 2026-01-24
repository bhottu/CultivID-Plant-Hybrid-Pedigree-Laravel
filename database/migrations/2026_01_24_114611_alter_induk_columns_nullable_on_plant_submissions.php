<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('plant_submissions', function (Blueprint $table) {
        $table->string('induk_jantan')->nullable()->change();
        $table->string('induk_betina')->nullable()->change();
    });
}

public function down()
{
    Schema::table('plant_submissions', function (Blueprint $table) {
        $table->string('induk_jantan')->nullable(false)->change();
        $table->string('induk_betina')->nullable(false)->change();
    });
}

};
