<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWaxField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cards_staking', function (Blueprint $table) {
            $table->float('wax', 5, 4)->default(0.0000)->after('staking_rate')->comment('wax/h');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cards_staking', function (Blueprint $table) {
            $table->dropColumn('wax');
        });
    }
}
