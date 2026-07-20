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

            $table->string('judul', 500);
            $table->string('url', 750)->unique();
            $table->string('sumber');
            $table->enum('jenis_bencana', [
                'gempa',
                'banjir',
                'topan',
                'longsor',
                'kebakaran',
                'bencana_nasional'
            ]);

            $table->integer('skor_negatif')->default(0);
            $table->integer('skor_risiko_bencana')->default(0);

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
        Schema::dropIfExists('data_bencana');
    }
};
