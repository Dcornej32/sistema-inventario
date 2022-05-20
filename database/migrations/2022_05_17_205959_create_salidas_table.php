<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalidasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salidas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idclientes')->unsigned();
            $table->foreign('idclientes')->references('id')->on('personas');
            $table->integer('idusuarios')->unsigned();
            $table->foreign('idusuarios')->references('id')->on('users');
            $table->date('fecha_salida');
            $table->decimal('total', 11,2);
            $table->boolean('condicion')->default(1);
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
        Schema::dropIfExists('salidas');
    }
}
