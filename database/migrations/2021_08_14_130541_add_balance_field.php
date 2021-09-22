<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBalanceField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_wallet', function (Blueprint $table) {
            $table->float('balance', 9, 4)->default(0.0000)->after('wax');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_wallet', function (Blueprint $table) {
            $table->dropColumn('balance');
        });
    }
}
