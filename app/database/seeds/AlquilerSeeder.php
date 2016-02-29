<?php

class AlquilerSeeder extends DatabaseSeeder{

	public function run()
    {
        $alquileres = [
            [
            	"idusuario" => 1,
            	"idcancha" => 1,
            	"estadoalquiler" => 'No Pagado',
            	"fecha" => '2014-02-24',
            	"horaingreso" => '07:00',
            	"horasalida" => '08:00',
            	"estadohora" => 'Reservado',
            	"monto" => 60
            ]
        ];
        foreach ($alquileres as $alquiler)
        {
            Alquiler::create($alquiler);
        }
    }

}