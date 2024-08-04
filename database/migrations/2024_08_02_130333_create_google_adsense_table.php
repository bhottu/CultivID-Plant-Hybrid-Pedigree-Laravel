<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('google_adsense', function (Blueprint $table) {
            $table->id();
            $table->string('publisher_id');
            $table->string('display_ads')->nullable();
            $table->string('in_feed_ads')->nullable();
            $table->string('multiplex_ads')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('google_adsense');
    }
};
