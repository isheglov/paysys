<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWalletEntity extends Migration
{
    /**
     * @return void
     */
    public function up()
    {
        Schema::create('wallets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('amount');
            $table->string('currency');
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wallets');
    }
}
