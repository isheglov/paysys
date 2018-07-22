<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWalletIdToUser extends Migration
{
    /**
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->bigInteger('wallet_id');
            $table->index('wallet_id');

            $table->dropColumn('currency');
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('currency');

            //$table->dropIndex('wallet_id');
            $table->dropColumn('wallet_id');
        });
    }
}
