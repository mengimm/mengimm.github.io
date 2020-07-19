<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Ad extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('vuser_id');
            $table->string('type')->nullable();
            $table->string('description')->nullable();
            $table->string('status')->nullable();
            $table->string('views')->nullable();
            $table->string('photos')->nullable();           
            $table->date('dt')->nullable();
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
        Schema::dropIfExists('ads');
    }
}
