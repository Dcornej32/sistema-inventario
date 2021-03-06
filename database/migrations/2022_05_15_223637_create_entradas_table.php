<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntradasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entradas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idproveedores')->unsigned();
            $table->foreign('idproveedores')->references('id')->on('proveedores');
            $table->integer('idusuarios')->unsigned();
            $table->foreign('idusuarios')->references('id')->on('users');
            $table->date('fecha_entrada');
            $table->decimal('total_compra',11,2);
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
        Schema::dropIfExists('entradas');
    }
}
