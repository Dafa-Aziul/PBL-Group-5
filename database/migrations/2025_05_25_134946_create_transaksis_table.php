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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelanggan_id')->constrained('pelanggans');
            $table->foreignId('kasir_id')->constrained('karyawans');

            $table->enum('jenis_transaksi', [
                'service',
                'penjualan',
                ])->default('penjualan');
            $table->string('kode_transaksi')->unique();
            $table->decimal('sub_total', 10, 2);
            $table->decimal('pajak', 10, 2)->default(0);
            $table->decimal('diskon', 10, 2)->default(0);
            $table->decimal('grand_total', 10, 2);

            $table->enum('status_pembayaran', [
                'lunas',
                'pending'
            ])->default('pending');

            $table->string('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
