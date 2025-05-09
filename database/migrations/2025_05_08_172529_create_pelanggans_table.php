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
        Schema::create('pelanggans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('no_hp');
            $table->string('alamat');
            $table->string('no_polisi')->unique();
            $table->foreignId('jenis_kendaraan_id')->constrained('jenis_kendaraans');
            $table->string('tipe_kendaraan');
            $table->unsignedBigInteger('odometer');
            $table->enum('keterangan', ['pribadi', 'perusahaan']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggans');
    }
};
