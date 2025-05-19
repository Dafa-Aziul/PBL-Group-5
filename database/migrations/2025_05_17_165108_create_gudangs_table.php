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
        Schema::create('gudangs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sparepart_id');
            $table->enum('aktivitas', ['masuk', 'keluar']);
            $table->integer('jumlah');
            $table->text('keterangan');
            $table->timestamps();

            $table->foreign('sparepart_id')
                  ->references('id')
                  ->on('spareparts')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gudangs');
    }
};
