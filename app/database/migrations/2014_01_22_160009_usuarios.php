<?php

use Illuminate\Database\Migrations\Migration;

class Usuarios extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('usuarios', function($tabla){
			$tabla->increments('idusuario');
			$tabla->integer('idempresa')->unsigned()->nullable();
			$tabla->integer('idlocal')->unsigned()->nullable();
			$tabla->string('tipo', 15);
			$tabla->string('nombrecompleto', 45);
			$tabla->string('foto')->nullable();
			$tabla->string('dni', 8)->nullable();
			$tabla->string('email', 45)->unique()->nullable();
			$tabla->string('celular', 15)->nullable();
			$tabla->string('username', 45)->unique();
			$tabla->string('password', 100);
			$tabla->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('usuarios');
	}

}