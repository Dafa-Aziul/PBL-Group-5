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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('kode_service')->unique();
            $table->foreignId('kendaraan_id')->constrained('kendaraans');
            $table->foreignId('montir_id')->constrained('karyawans');
            $table->string('no_polisi');
            $table->string('model_kendaraan');
            $table->integer('odometer')->nullable();
            $table->text('deskripsi_keluhan')->nullable();
            $table->enum('status', [
                'dalam antrian',
                'dianalisis',
                'analisis selesai',
                'dalam_proses',
                'selesai',
                'batal'
            ])->default('dalam antrian');
            $table->decimal('estimasi_harga', 12, 2)->nullable();
            $table->date('tanggal_keluhan')->nullable();
            $table->dateTime('tanggal_mulai_service')->nullable();
            $table->dateTime('tanggal_selesai_service')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
