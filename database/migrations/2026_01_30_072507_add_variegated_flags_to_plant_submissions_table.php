<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('plant_submissions', function (Blueprint $table) {

            $table->tinyInteger('plant_id_var')
                ->default(1)
                ->comment('0 = variegated, 1 = normal')
                ->after('plant_id');

            $table->tinyInteger('induk_jantan_var')
                ->default(1)
                ->comment('0 = variegated, 1 = normal')
                ->after('induk_jantan');

            $table->tinyInteger('induk_betina_var')
                ->default(1)
                ->comment('0 = variegated, 1 = normal')
                ->after('induk_betina');
        });
    }

    public function down(): void
    {
        Schema::table('plant_submissions', function (Blueprint $table) {
            $table->dropColumn([
                'plant_id_var',
                'induk_jantan_var',
                'induk_betina_var'
            ]);
        });
    }
};

