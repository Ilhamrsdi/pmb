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
        Schema::create('gelombang_prodi_lain', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('gelombang_id'); // Relasi ke tabel gelombang
            $table->unsignedBigInteger('prodi_lain_id'); // Relasi ke tabel prodi_lain
            $table->timestamps();

            // Foreign keys
            $table->foreign('gelombang_id')
                ->references('id')
                ->on('gelombang_pendaftarans')
                ->onDelete('cascade');

            $table->foreign('prodi_lain_id')
                ->references('id')
                ->on('prodi_lain')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gelombang_prodi_lain');
    }
};
