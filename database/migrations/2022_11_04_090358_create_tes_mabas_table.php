<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tes_mabas', function (Blueprint $table) {
            $table->id();
            $table->string('kode_mapel');
            $table->string('nama_mapel');
            $table->string('jumlah_soal');
            $table->date('tanggal_tes');
            $table->string('waktu_tes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tes_mabas');
    }
};
