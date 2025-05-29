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
        Schema::create('kontens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penulis_id')->constrained('karyawans');
            $table->string('judul');
            $table->text('isi');
            $table->string('kategori');
            $table->string('foto_konten')->nullable();
            $table->string('video_konten')->nullable();
            $table->enum('status', ['draft', 'terbit', 'arsip'])->default('draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kontens');
    }
};
