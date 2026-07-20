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
        Schema::create('data_cuaca', function (Blueprint $table) {
            $table->id();

            $table->foreignId('negara_id')
            ->constrained('negara')
            ->cascadeOnDelete();

            $table->decimal('suhu', 5, 2);
            $table->decimal('curah_hujan', 8, 2);
            $table->decimal('kecepatan_angin', 5, 2);
            $table->string('kondisi_cuaca');
            $table->enum('tingkat_risiko', ['rendah', 'sedang', 'tinggi']);
            $table->string('sumber_api');
            $table->date('tanggal_data');
            $table->timestamps();

            $table->unique(['negara_id', 'tanggal_data']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_cuaca');
    }
};
