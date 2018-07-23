<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRateTable extends Migration
{
    /**
     * @return void
     */
    public function up()
    {
        Schema::create('rates', function (Blueprint $table) {
            $table->string('curr');
            $table->string('rate');
            $table->date('date');

            $table->index(['date','curr']);
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rates');
    }
}
