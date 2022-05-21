<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleSalidasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_salidas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idsalidas')->unsigned();
            $table->foreign('idsalidas')->references('id')->on('salidas')->onDelete('cascade');
            $table->integer('idproductos')->unsigned();
            $table->foreign('idproductos')->references('id')->on('productos');
            $table->integer('cantidad');
            $table->decimal('precio_actual', 11, 2);

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
        Schema::dropIfExists('detalle_salidas');
    }
}