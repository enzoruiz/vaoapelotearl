<?php

class DiaSeeder extends DatabaseSeeder{

	public function run()
    {
        $dias = [
            [
            	"idcancha" => 1,
            	"nombre" => 'Lunes'
            ],
            [
                "idcancha" => 2,
                "nombre" => 'Lunes'
            ],
            [
                "idcancha" => 4,
                "nombre" => 'Martes'
            ],
            [
                "idcancha" => 6,
                "nombre" => 'Miercoles'
            ],
            [
                "idcancha" => 5,
                "nombre" => 'Lunes'
            ],
            [
                "idcancha" => 3,
                "nombre" => 'Jueves'
            ],
            [
                "idcancha" => 1,
                "nombre" => 'Viernes'
            ]
        ];
        foreach ($dias as $dia)
        {
            Dia::create($dia);
        }
    }

}