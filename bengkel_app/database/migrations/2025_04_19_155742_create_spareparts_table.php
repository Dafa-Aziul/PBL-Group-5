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
        Schema::create('spareparts', function (Blueprint $table) {
         $table->id(); // Menambahkan kolom 'id' sebagai primary key
        $table->string('nama'); 
        $table->string('merk'); 
        $table->string('satuan', 10); 
        $table->integer('stok'); // Jumlah sparepart yang tersedia
        $table->decimal('harga', 10, 2); // Harga sparepart, dengan 10 digit total dan 2 digit setelah koma
        $table->string('model_kendaraan'); // Model kendaraan yang sesuai dengan sparepart
        $table->string('keterangan'); // Keterangan tambahan mengenai sparepart
        $table->timestamps(); // Kolom created_at dan updated_at
        $table->softDeletes(); // Kolom deleted_at untuk soft delete
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spareparts');
    }
};
