<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDuelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('duels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('code');
            $table->integer('number_0');
            $table->integer('number_1');
            $table->integer('number_2');
            $table->integer('number_3');
            $table->integer('number_4');
            $table->integer('number_5');
            $table->integer('number_target');
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
        Schema::dropIfExists('duels');
    }
}
