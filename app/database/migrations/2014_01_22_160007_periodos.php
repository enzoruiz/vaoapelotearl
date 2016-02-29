<?php

use Illuminate\Database\Migrations\Migration;

class Periodos extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('periodos', function($tabla){
			$tabla->increments('idperiodo');
			$tabla->integer('iddia')->unsigned();
			$tabla->string('horainicio');
			$tabla->string('horafin');
			$tabla->float('precio');
			$tabla->timestamps();
			$tabla->foreign('iddia')->references('iddia')->on('dias');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('periodos');
	}

}