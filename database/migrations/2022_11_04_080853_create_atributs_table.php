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
        Schema::create('atributs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftar_id');
            $table->string('atribut_kaos')->nullable();
            $table->string('atribut_topi')->nullable();
            $table->string('atribut_almamater')->nullable();
            $table->string('atribut_jas_lab')->nullable();
            $table->string('atribut_baju_lapangan')->nullable();
            $table->string('status_pengambilan_kaos')->nullable();
            $table->string('status_pengambilan_topi')->nullable();
            $table->string('status_pengambilan_almamater')->nullable();
            $table->string('status_pengambilan_jas_lab')->nullable();
            $table->string('status_pengambilan_baju_lapangan')->nullable();
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
        Schema::dropIfExists('atributs');
    }
};
