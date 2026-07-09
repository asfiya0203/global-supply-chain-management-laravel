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
        Schema::create('data_sanksi', function (Blueprint $table) {
            $table->id();

            $table->foreignId('negara_id')
            ->constrained('negara')
            ->cascadeOnDelete();

            $table->string('jenis_sanksi');
            $table->string('negara_pemberi_sanksi');
            $table->enum('status', ['aktif', 'dicabut']);
            $table->text('deskripsi');
            $table->string('sumber_api');
            $table->dateTime('waktu_data');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_sanksi');
    }
};
