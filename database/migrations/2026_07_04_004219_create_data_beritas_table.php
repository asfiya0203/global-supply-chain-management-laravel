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
        Schema::create('data_berita', function (Blueprint $table) {
            $table->id();

            $table->foreignId('negara_id')
            ->constrained('negara')
            ->cascadeOnDelete();

            $table->string('judul');
            $table->text('isi');
            $table->string('url_sumber');
            $table->unsignedInteger('skor_positif')->default(0);
            $table->unsignedInteger('skor_negatif')->default(0);
            $table->enum('sentimen', [
                'positif',
                'netral',
                'negatif'
            ]);
            $table->dateTime('tanggal_duplikasi')->nullable();
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
        Schema::dropIfExists('data_beritas');
    }
};
