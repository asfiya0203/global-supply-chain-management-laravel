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
            $table->text('deskripsi')->nullable();
            $table->string('url', 750)->unique();
            $table->string('sumber');
            $table->enum('kategori', ['logistik', 'perdagangan', 'pelayaran', 'ekonomi']);

            $table->integer('skor_positif')->default(0);
            $table->integer('skor_negatif')->default(0);

            $table->enum('sentimen', ['positif', 'netral', 'negatif']);
            $table->integer('skor_risiko_berita')->default(1);
            $table->dateTime('tanggal_publikasi')->nullable();
            $table->timestamps();
            $table->index('negara_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_berita');
    }
};
