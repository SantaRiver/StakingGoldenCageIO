<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->string('name', 64);
            $table->string('schema', 16);
            $table->string('rarity', 16)->nullable();
            $table->string('template_id', 8);
            $table->text('description')->nullable();
            $table->boolean('active')->default(false);
            $table->timestamps();
        });

        Schema::create('cards_img', function (Blueprint $table) {
            $table->id();
            $table->foreignId('card_id')->constrained('cards');
            $table->string('img', 64);
            $table->string('preview', 64);
            $table->timestamps();
        });

        Schema::create('cards_staking', function (Blueprint $table) {
            $table->id();
            $table->foreignId('card_id')->constrained('cards');
            $table->float('staking_rate')->default(1);
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
        Schema::dropIfExists('cards_staking');
        Schema::dropIfExists('cards_img');
        Schema::dropIfExists('cards');
    }
}
