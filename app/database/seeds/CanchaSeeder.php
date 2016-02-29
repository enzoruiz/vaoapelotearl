<?php

class CanchaSeeder extends DatabaseSeeder{

	public function run()
    {
        $canchas = [
            [
            	"idlocal" => 1,
            	"descripcion" => '5 x 5'
            ],
            [
            	"idlocal" => 1,
            	"descripcion" => '5 x 5'
            ],
            [
            	"idlocal" => 1,
            	"descripcion" => '6 x 6'
            ],
            [
                "idlocal" => 2,
                "descripcion" => '6 x 6'
            ],
            [
                "idlocal" => 2,
                "descripcion" => '6 x 6'
            ],
            [
                "idlocal" => 3,
                "descripcion" => '7 x 7'
            ]
        ];
        foreach ($canchas as $cancha)
        {
            Cancha::create($cancha);
        }
    }

}