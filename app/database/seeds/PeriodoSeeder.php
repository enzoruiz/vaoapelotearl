<?php

class PeriodoSeeder extends DatabaseSeeder{

	public function run()
    {
        $periodos = [
            [
            	"iddia" => 1,
            	"horainicio" => '07:00',
            	"horafin" => '08:00',
            	"precio" => 60
            ],
            [
                "iddia" => 2,
                "horainicio" => '07:00',
                "horafin" => '08:00',
                "precio" => 65
            ],
            [
                "iddia" => 3,
                "horainicio" => '10:00',
                "horafin" => '11:00',
                "precio" => 65
            ],
            [
                "iddia" => 4,
                "horainicio" => '13:00',
                "horafin" => '14:00',
                "precio" => 70
            ],
            [
                "iddia" => 5,
                "horainicio" => '07:00',
                "horafin" => '08:00',
                "precio" => 90
            ],
            [
                "iddia" => 6,
                "horainicio" => '09:00',
                "horafin" => '10:00',
                "precio" => 120
            ],
            [
                "iddia" => 7,
                "horainicio" => '14:00',
                "horafin" => '15:00',
                "precio" => 100
            ]
        ];
        foreach ($periodos as $periodo)
        {
            Periodo::create($periodo);
        }
    }

}