<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHistoryTable extends Migration
{
    /**
     * @return void
     */
    public function up()
    {
        Schema::create('history', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('wallet_id');
            $table->date('date');
            $table->integer('amount');
            $table->integer('amount_usd');
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('history');
    }
}
