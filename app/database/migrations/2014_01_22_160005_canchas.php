<?php

use Illuminate\Database\Migrations\Migration;

class Canchas extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('canchas', function($tabla){
			$tabla->increments('idcancha');
			$tabla->integer('idlocal')->unsigned();
			$tabla->string('descripcion', 7);
			$tabla->timestamps();
			$tabla->foreign('idlocal')->references('idlocal')->on('locales');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('canchas');
	}

}