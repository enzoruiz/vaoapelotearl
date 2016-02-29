<?php

use Illuminate\Database\Migrations\Migration;

class Locales extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('locales', function($tabla){
			$tabla->increments('idlocal');
			$tabla->integer('idempresa')->unsigned();
			$tabla->integer('iddistrito')->unsigned();
			$tabla->string('nombre', 45)->unique();
			$tabla->string('direccion', 45);
			$tabla->string('telefono', 45);
			$tabla->string('fotoprincipal', 45);
			$tabla->string('foto2', 45);
			$tabla->string('foto3', 45);
			$tabla->text('servicios');
			$tabla->integer('calificacion')->nullable();
			$tabla->timestamps();
			$tabla->foreign('idempresa')->references('idempresa')->on('empresas');
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
		Schema::drop('locales');
	}

}