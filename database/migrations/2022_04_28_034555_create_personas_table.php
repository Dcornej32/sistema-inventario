<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class CreatePersonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 150)->nullable();
            $table->string('tipo_documento', 20)->nullable();
            $table->string('numero_documento', 20)->nullable();
            $table->string('direccion', 256)->nullable();
            $table->string('telefono', 15)->nullable();
            $table->string('email', 100)->nullable();
            $table->boolean('condicion')->default(1);
            $table->timestamps();
        });
        DB::table('personas')->insert(array('id'=>'1','nombre'=>'Administrador', 'tipo_documento'=>'','numero_documento'=>'','direccion'=>'','telefono'=>'','email'=>''));

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personas');
    }
}