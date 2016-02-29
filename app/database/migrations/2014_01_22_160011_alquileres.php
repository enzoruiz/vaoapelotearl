<?php

use Illuminate\Database\Migrations\Migration;

class Alquileres extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('alquileres', function($tabla){
			$tabla->increments('idalquiler');
			$tabla->integer('idusuario')->unsigned();
			$tabla->integer('idcancha')->unsigned();
			$tabla->string('estadoalquiler');
			$tabla->date('fecha');
			$tabla->string('horaingreso');
			$tabla->string('horasalida');
			$tabla->string('estadohora');
			$tabla->double('monto');
			$tabla->timestamps();
			$tabla->foreign('idusuario')->references('idusuario')->on('usuarios');
			$tabla->foreign('idcancha')->references('idcancha')->on('canchas');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('alquileres');
	}

}