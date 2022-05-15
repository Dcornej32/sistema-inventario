ç<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleEntradasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_entradas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('identradas')->unsigned();
            $table->foreign('identradas')->references('id')->on('entradas')->onDelete('cascade');
            $table->integer('idproductos')->unsigned();
            $table->foreign('idproductos')->references('id')->on('productos');
            $table->integer('cantidad');
            $table->decimal('precio_compra',11,2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalle_entradas');
    }
}
