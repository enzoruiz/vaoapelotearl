<?php

use Illuminate\Database\Migrations\Migration;

class Horas extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('horas', function($tabla){
			$tabla->increments('idhora');
			$tabla->integer('idperiodo')->unsigned();
			$tabla->string('horaingreso', 5);
			$tabla->string('horasalida', 5);
			$tabla->timestamps();
			$tabla->foreign('idperiodo')->references('idperiodo')->on('periodos');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('horas');
	}

}