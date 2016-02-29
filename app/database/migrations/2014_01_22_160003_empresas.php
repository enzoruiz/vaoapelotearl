<?php

use Illuminate\Database\Migrations\Migration;

class Empresas extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('empresas', function($tabla){
			$tabla->increments('idempresa');
			$tabla->integer('iddistrito')->unsigned();
			$tabla->string('razonsocial', 45);
			$tabla->string('direccion', 45);
			$tabla->string('telefono', 45);
			$tabla->string('correo', 25);
			$tabla->timestamps();
			$tabla->foreign('iddistrito')->references('iddistrito')->on('distritos');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('empresas');
	}

}