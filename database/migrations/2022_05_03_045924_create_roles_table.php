<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 200)->unique();
            $table->string('descripcion', 100)->nullable();
            $table->boolean('condicion')->default(1);    
            
            $table->timestamps();
            
        });
        //DB::table('roles')->insert(array('id'=>'1','nombre'=>'Administrador', 'descripcion'=>'Administrador de área'));
        //DB::table('roles')->insert(array('id'=>'2','nombre'=>'Gerente', 'descripcion'=>'Gerente de área'));
        //DB::table('roles')->insert(array('id'=>'3','nombre'=>'Bodeguero', 'descripcion'=>'Almacenero de área '));

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
