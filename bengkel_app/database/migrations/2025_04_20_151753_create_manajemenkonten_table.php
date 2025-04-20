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
        Schema::create('manajemenkonten', function (Blueprint $table) {
            // $table->id();
            $table->id('id_konten'); // PK, Auto Increment
            $table->string('judul', 150);
            $table->text('isi');
            $table->string('kategori', 50);
            $table->date('tanggal_terbit');
            $table->string('gambar', 255)->nullable();
            $table->string('video', 255)->nullable();
            $table->enum('status', ['draft', 'terbit', 'arsip'])->default('draft');
            $table->string('penulis', 100);
            $table->timestamps(); // created_at & updated_at

            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manajemenkonten');
    }
};
