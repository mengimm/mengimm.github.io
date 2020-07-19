<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Vuser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vusers', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->string('vid')->nullable();
        $table->string('name')->nullable();
        $table->string('nick')->nullable();
        $table->string('photo')->nullable();
        $table->string('status')->nullable();
        $table->string('phone')->nullable();
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
        Schema::dropIfExists('vusers');
    }

}
