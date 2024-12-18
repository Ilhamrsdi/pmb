<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Carbon;
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_pendaftars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftar_id');
            $table->string('kode_pendaftaran')->nullable();
            $table->string('kode_bayar')->nullable();
            $table->date('tanggal_daftar')->nullable();
            $table->date('tanggal_masuk_kuliah')->nullable();
            $table->integer('nominal_ukt')->nullable();
            $table->integer('potongan_ukt')->nullable();
            $table->string('va_pendaftaran')->nullable();
            $table->string('trx_va')->nullable();
            $table->timestamp('datetime_expired')->nullable()->default(Carbon::now()->addHours(24)); // 24 jam dari sekarang;
            $table->string('va_ukt')->nullable();
            $table->string('trx_va_ukt')->nullable();
            $table->timestamp('datetime_expired_ukt')->nullable()->default(Carbon::now()->addHours(24)); // 24 jam dari sekarang;
            $table->string('status_pendaftaran')->nullable();
            $table->string('status_pembayaran_pendaftaran');
            $table->string('status_pembayaran')->nullable();
            $table->string('status_ukt')->nullable();
            $table->string('status_acc')->nullable();
            $table->string('status_mahasiswa')->nullable();
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
        Schema::dropIfExists('detail_pendaftars');
    }
};
