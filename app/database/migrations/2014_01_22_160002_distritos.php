<?php

use Illuminate\Database\Migrations\Migration;

class Distritos extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('distritos', function($tabla){
			$tabla->increments('iddistrito');
			$tabla->integer('idprovincia')->unsigned();
			$tabla->string('nombre');
			$tabla->foreign('idprovincia')->references('idprovincia')->on('provincias');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('distritos');
	}

}