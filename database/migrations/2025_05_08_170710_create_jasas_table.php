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
        Schema::create('jasas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jenis_kendaraan_id')->constrained('jenis_kendaraans');
            $table->string('kode');
            $table->string('nama_jasa');
            $table->string('estimasi');
            $table->decimal('harga', 10, 2);
            $table->string('keterangan');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jasas');
    }
};
