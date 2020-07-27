<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLocation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->decimal('lat',8,4)->nullable();
            $table->decimal('lon',8,4)->nullable();            
            $table->string('photo1',1000)->nullable();
            $table->string('photo2',1000)->nullable();
            $table->string('photo3',1000)->nullable();
            $table->string('photo4',1000)->nullable();
            $table->string('photo5',1000)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->dropColumn('lat');
            $table->dropColumn('lon');
            $table->dropColumn('photo1');
            $table->dropColumn('photo2');
            $table->dropColumn('photo3');
            $table->dropColumn('photo4');
            $table->dropColumn('photo5');
        });
    }
}
