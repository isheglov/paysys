<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUniqueToUsers extends Migration
{
    /**
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unique(
                [
                    'name',
                    'country',
                    'city',
                    'wallet_id'
                ],
                'uq__name_country_city_wallet_id__users'
            );
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique('uq__name_country_city_wallet_id__users');
        });
    }
}
