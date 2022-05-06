<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInformacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('informaciones', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 100);
            $table->string('direccion',256);
            $table->string('email', 100)->nullable();
            $table->string('telefono',15);
            $table->string('numero_tributario', 20)->nullable();
            $table->string('numero_registro', 20)->nullable();
            $table->string('giro', 150)->nullable();
            $table->string('nombre_contacto',150);
            $table->string('telefono_contacto',15);
            $table->string('cargo',60);
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
        Schema::dropIfExists('informaciones');
    }
}
