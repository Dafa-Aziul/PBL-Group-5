<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('pelanggans', function (Blueprint $table) {
            $table->string('jenis_kendaraan', 50)->change();
        });
    }

    public function down()
    {
        Schema::table('pelanggans', function (Blueprint $table) {
            $table->unsignedBigInteger('jenis_kendaraan')->change();
        });
    }

};
