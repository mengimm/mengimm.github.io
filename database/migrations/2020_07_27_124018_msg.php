<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Msg extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    Schema::create('msgs', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->unsignedBigInteger('vuser_id');
        $table->string('timestamp')->nullable();
        $table->string('token')->nullable();        
        $table->foreign('vuser_id')
      ->references('id')->on('vusers')
      ->onDelete('cascade');
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
    Schema::dropIfExists('msgs');
}
}
