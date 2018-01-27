<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrainDelaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('train_delays', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('travel_card_id')->unsigned();
            $table->string('from');
            $table->string('to');
            $table->enum('reference_time', ['arrival', 'depature']);
            $table->integer('delayed_stage');
            $table->enum('reason', ['delayed', 'early', 'cancelled'])->default('delayed');
            $table->dateTime('happend_at');
            $table->dateTime('arrived_at');
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
        Schema::dropIfExists('train_delays');
    }
}
