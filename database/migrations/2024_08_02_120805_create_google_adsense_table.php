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
            $table->string('ad_type'); // tipe iklan (Display, In-feed, Multiplex)
            $table->string('publisher_id'); // Publisher ID
            $table->text('ad_slot'); // Kode slot iklan
            $table->boolean('is_active')->default(true); // status aktif/non-aktif
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
