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
        Schema::create('skor_risiko_harian', function (Blueprint $table) {
            $table->id();

            $table->foreignId('negara_id')
            ->constrained('negara')
            ->cascadeOnDelete();

            $table->date('tanggal');
            $table->decimal('skor_cuaca', 5, 2);
            $table->decimal('skor_bencana', 5, 2);
            $table->decimal('skor_pelabuhan', 5, 2);
            $table->decimal('skor_sanksi', 5, 2);
            $table->decimal('skor_berita', 5, 2);
            $table->decimal('skor_total', 5, 2);
            $table->enum('level_risiko', ['rendah', 'sedang', 'tinggi']);
            $table->text('ringkasan_ai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skor_risiko_harian');
    }
};
