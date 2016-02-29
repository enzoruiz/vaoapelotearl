<?php

use Illuminate\Database\Migrations\Migration;

class Dias extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dias', function($tabla){
			$tabla->increments('iddia');
			$tabla->integer('idcancha')->unsigned();
			$tabla->string('nombre', 10);
			$tabla->timestamps();
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
		Schema::drop('dias');
	}

}