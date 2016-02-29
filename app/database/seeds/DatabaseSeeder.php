<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('DepartamentoSeeder');
		$this->call('ProvinciaSeeder');
		$this->call('DistritoSeeder');
		$this->call('EmpresaSeeder');
		$this->call('LocalSeeder');
		$this->call('CanchaSeeder');
		$this->call('DiaSeeder');
		$this->call('PeriodoSeeder');
		$this->call('HoraSeeder');
		$this->call('UsuarioSeeder');
		$this->call('AlquilerSeeder');
		
	}

}