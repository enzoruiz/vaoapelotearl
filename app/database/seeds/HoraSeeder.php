<?php

class HoraSeeder extends DatabaseSeeder{

	public function run()
    {
        $horas = [
            [
            	"idperiodo" => 1,
            	"horaingreso" => '07:00',
            	"horasalida" => '08:00'
            ],
            [
            	"idperiodo" => 2,
            	"horaingreso" => '07:00',
            	"horasalida" => '08:00'
            ],
            [
                "idperiodo" => 3,
                "horaingreso" => '10:00',
                "horasalida" => '11:00'
            ],
            [
                "idperiodo" => 4,
                "horaingreso" => '13:00',
                "horasalida" => '14:00'
            ],
            [
                "idperiodo" => 5,
                "horaingreso" => '07:00',
                "horasalida" => '08:00'
            ],
            [
                "idperiodo" => 6,
                "horaingreso" => '09:00',
                "horasalida" => '10:00'
            ],
            [
                "idperiodo" => 7,
                "horaingreso" => '14:00',
                "horasalida" => '15:00'
            ]
        ];
        foreach ($horas as $hora)
        {
            Hora::create($hora);
        }
    }

}