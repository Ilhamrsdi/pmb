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
        Schema::create('gelombang_pendaftarans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_gelombang');
            $table->string('tahun_ajaran');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->string('status');
            $table->string('deskripsi');
            $table->string('biaya_pendaftaran');
            $table->string('biaya_administrasi');
            $table->string('kuota_pendaftar');
            $table->date('tanggal_ujian');
            $table->string('tempat_ujian')->default('POLIWANGI');
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
        Schema::dropIfExists('gelombang_pendaftarans');
    }
};
