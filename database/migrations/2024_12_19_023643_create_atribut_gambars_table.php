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
        Schema::create('atribut_gambars', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_gambar'); // Jenis gambar (contoh: Kaos, Topi)
            $table->string('nama_gambar'); // Nama file gambar
            $table->string('ukuran')->nullable(); // Ukuran gambar (jika diperlukan)
            $table->timestamps(); // Timestamp created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('atribut_gambars');
    }
};
