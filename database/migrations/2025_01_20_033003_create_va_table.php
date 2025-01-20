<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('va', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('trx_id')->unique(); // Transaction ID
            $table->decimal('trx_amount', 15, 2); // Amount
            $table->timestamp('datetime_expired'); // Expiry datetime
            $table->string('virtual_account'); // Virtual account number
            $table->text('detail_tagihan')->nullable(); // Detail tagihan (JSON string)
            $table->timestamps(); // Created at and Updated at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('va');
    }
}
