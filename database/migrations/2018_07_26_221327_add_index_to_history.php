<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIndexToHistory extends Migration
{
    /**
     * @return void
     */
    public function up()
    {
        Schema::table('history', function (Blueprint $table) {
            $table->index(
                [
                    'wallet_id',
                    'date'
                ],
                'ix__wallet_id_date__history'
            );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('history', function (Blueprint $table) {
            $table->dropIndex('ix__wallet_id_date__history');
        });
    }
}
