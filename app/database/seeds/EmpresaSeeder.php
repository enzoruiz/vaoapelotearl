<?php

class EmpresaSeeder extends DatabaseSeeder{

	public function run()
    {
        $empresas = [
            [
            	"iddistrito" => 1200,
                "razonsocial" => 'MALL AVENTURA E.I.R.L.',
            	"direccion" => 'Av. Mansiche 34534',
            	"telefono" => '506298',
            	"correo" => 'mallaventura@gmail.com'
            ],
            [
                "iddistrito" => 1200,
                "razonsocial" => 'SOCCER CITY S.A.C.',
                "direccion" => 'Av. Por el Ovalo Papal 3214',
                "telefono" => '875421',
                "correo" => 'soccercity@yahoo.com'
            ],
            [
                "iddistrito" => 1200,
                "razonsocial" => 'LUDICUS S.A.',
                "direccion" => 'Av. Detras del Mall Aventura',
                "telefono" => '659832',
                "correo" => 'ludicus@hotmail.com'
            ]
        ];
        foreach ($empresas as $empresa)
        {
            Empresa::create($empresa);
        }
    }

}