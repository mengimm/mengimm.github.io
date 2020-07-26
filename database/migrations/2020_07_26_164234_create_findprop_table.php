<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFindpropTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {        
        Schema::create('findprops', function (Blueprint $table) {            
            $table->bigIncrements('id');
            $table->unsignedBigInteger('vuser_id');
            $table->Integer('type')->nullable();
            $table->Integer('prop_type')->nullable();
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
        Schema::dropIfExists('findprops');
    }
}
