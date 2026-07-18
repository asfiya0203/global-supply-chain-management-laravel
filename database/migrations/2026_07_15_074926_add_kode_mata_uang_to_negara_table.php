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
        Schema::table('negara', function (Blueprint $table) {
            $table->string('kode_mata_uang', 10)
                ->after('kode_iso3')
                ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('negara', function (Blueprint $table) {
            $table->dropColumn('kode_mata_uang');
        });
    }
};
