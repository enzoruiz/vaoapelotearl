<?php

use Illuminate\Database\Migrations\Migration;

class Perfiles extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('perfiles', function($tabla){
			$tabla->increments('idperfil');
			$tabla->integer('idusuario')->unsigned();
			$tabla->string('proviene', 45);
			$tabla->string('username', 45);
            $tabla->biginteger('uid')->unsigned()->nullable();
            $tabla->string('access_token')->nullable();
            $tabla->string('access_token_secret')->nullable();
            $tabla->timestamps();
            $tabla->foreign('idusuario')->references('idusuario')->on('usuarios');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('perfiles');
	}

}