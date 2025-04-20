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
        Schema::create('data_karyawan', function (Blueprint $table) {
            $table->id('id_karyawan');
            $table->string('email')->unique();
            $table->string('nama', 100);
            $table->string('jabatan', 50);
            $table->string('no_hp', 15);
            $table->text('alamat');
            $table->date('tanggal_masuk');
            $table->enum('status', ['Aktif', 'Nonaktif']);
            $table->timestamps();
            $table->softDeletes();
    
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_karyawans');
    }
};
