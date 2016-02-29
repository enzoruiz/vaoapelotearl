<?php

use Illuminate\Database\Migrations\Migration;

class Provincias extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('provincias', function($tabla){
			$tabla->increments('idprovincia');
			$tabla->integer('iddepartamento')->unsigned();
			$tabla->string('nombre');
			$tabla->foreign('iddepartamento')->references('iddepartamento')->on('departamentos');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('provincias');
	}

}