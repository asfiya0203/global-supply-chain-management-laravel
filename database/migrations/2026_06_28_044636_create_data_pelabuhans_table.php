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
        Schema::create('data_pelabuhan', function (Blueprint $table) {
            $table->id();

            $table->foreignId('negara_id')
                ->constrained('negara')
                ->cascadeOnDelete();

            $table->string('nama_pelabuhan');
            $table->string('nama_alternatif')->nullable();
            $table->string('un_locode')->nullable();
            $table->string('wilayah')->nullable();
            $table->string('ukuran_pelabuhan')->nullable();
            $table->string('tipe_pelabuhan')->nullable();
            $table->string('penggunaan_pelabuhan')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->timestamps();
            $table->unique(['negara_id', 'nama_pelabuhan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_pelabuhan');
    }
};
