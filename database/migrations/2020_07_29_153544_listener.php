<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Listener extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    Schema::create('listeners', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->unsignedBigInteger('vuser_id');
        $table->string('type')->nullable();
        $table->string('type_prop')->nullable();        
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
    Schema::dropIfExists('listeners');
}
}
