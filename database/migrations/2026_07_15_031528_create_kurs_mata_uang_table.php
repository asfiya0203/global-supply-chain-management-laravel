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
        Schema::create('kurs_mata_uang', function (Blueprint $table) {
            $table->id();

            $table->foreignId('negara_id')
                ->constrained('negara')
                ->cascadeOnDelete();

            $table->string('kode_mata_uang', 10);
            $table->decimal('kurs_ke_usd', 20, 6);
            $table->decimal('perubahan_persen', 8, 4)->nullable();
            $table->enum('tingkat_risiko', ['rendah', 'sedang', 'tinggi', 'kritis'])->default('rendah');
            $table->date('tanggal');
            $table->string('sumber_api')->default('ExchangeRate API');

            $table->timestamps();

            $table->unique(['negara_id', 'tanggal']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kurs_mata_uang');
    }
};
