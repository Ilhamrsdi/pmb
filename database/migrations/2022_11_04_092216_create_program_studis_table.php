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
        Schema::create('program_studis', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('jurusan_id')->nullable();
            $table->string('kode_program_studi');
            $table->string('nama_program_studi');
            $table->string('kode_nim')->nullable();
            $table->string('jenjang_pendidikan');
            $table->string('akreditasi');
            $table->integer('kuota_diterima')->default(0);
            $table->integer('nomer_urut_nim')->default(0);
            $table->string('status');
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
        Schema::dropIfExists('program_studis');
    }
};
