<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDailyStatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stat_daily', function(Blueprint $table) {
            $table->unsignedBigInteger('short_url_id');
            $table->date('date');
            $table->unsignedBigInteger('count')->default(0);
            $table->index('date');
            $table->foreign('short_url_id')->references('id')->on('links');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('stat_daily');
    }
}
