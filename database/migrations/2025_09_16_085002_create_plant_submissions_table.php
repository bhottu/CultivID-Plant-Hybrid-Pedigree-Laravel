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
        Schema::create('plant_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('plant_id'); // ID tanaman wajib
            $table->string('induk_jantan'); // Induk jantan wajib
            $table->string('induk_betina'); // Induk betina wajib
            $table->string('penyilang'); // Penyilang wajib
            $table->foreignId('uploader_id')->constrained('users')->onDelete('cascade'); // uploader (user login)
            $table->text('keterangan')->nullable(); // opsional
            $table->string('image')->nullable();
            $table->enum('status_review', ['pending', 'approved', 'rejected'])->default('pending');
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->boolean('uploader_approval')->default(true); // approval uploader jika diedit member lain
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plant_submissions');
    }
};
