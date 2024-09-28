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
        Schema::create('ukts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('golongan_id');
            $table->foreignId('gelombang_id')->nullable();
            $table->integer('nominal_reguler');
            $table->integer('nominal_non_reguler');
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
        Schema::dropIfExists('ukts');
    }
};
