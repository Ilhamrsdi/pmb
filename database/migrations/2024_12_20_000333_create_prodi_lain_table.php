<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdiLainTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prodi_lain', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Ganti id menjadi UUID
            $table->string('name'); // Nama Program Studi
            $table->string('kampus'); // Nama Kampus
            $table->string('alamat_kampus')->nullable(); // Alamat Kampus
            $table->string('email_kampus')->nullable(); // Email Resmi Kampus
            $table->bigInteger('telepon_kampus')->nullable();  // Nomor Telepon Kampus
            $table->string('website_kampus')->nullable(); // Website Resmi Kampus
            $table->string('status')->nullable();
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
        Schema::dropIfExists('prodi_lain');
    }
}
