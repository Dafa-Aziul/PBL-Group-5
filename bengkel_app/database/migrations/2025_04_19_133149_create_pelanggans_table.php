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
            $table->string('nama_pelanggan', 255);
            $table->string('email', 100);
            $table->string('no_telp', 20);
            $table->text('alamat');
            $table->string('no_polisi')->unique();
            $table->string('jenis_kendaraan');
            $table->string('model');
            $table->enum('ket', ['Pribadi','Perusahaan']);
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
