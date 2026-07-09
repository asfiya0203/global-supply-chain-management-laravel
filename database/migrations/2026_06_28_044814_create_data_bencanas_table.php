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
        Schema::create('data_bencana', function (Blueprint $table) {
            $table->id();

            $table->foreignId('negara_id')
            ->constrained('negara')
            ->cascadeOnDelete();

            $table->string('jenis_bencana');
            $table->string('tingkat_keparahan');
            $table->string('lokasi');
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
        Schema::dropIfExists('data_bencana');
    }
};
