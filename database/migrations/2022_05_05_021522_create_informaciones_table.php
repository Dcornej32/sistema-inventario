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
        DB::table('informaciones')->insert(array('id'=>'1','nombre'=>'Tienda Variedades(SJ)', 'direccion'=>'San Jacinto, San Salvador',
         'email'=>'variedades@gmail.com','telefono'=>'77895467', 'numero_tributario'=>'', 'numero_registro'=>'',
         'giro'=>'Cereales-Bebidas','nombre_contacto'=>'Sandra Amelia Sandoval Linares','telefono_contacto'=>'71234567','cargo'=>'Vendedora'));
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
