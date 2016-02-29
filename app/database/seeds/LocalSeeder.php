<?php

class LocalSeeder extends DatabaseSeeder{

	public function run()
    {
        $locales = [
            [
                "idempresa" => 1,
                "iddistrito" => 1200,
            	"nombre" => 'MALL AVENTURA SOCCER',
            	"direccion" => 'Av. Mansiche 34534',
            	"telefono" => '506298',
                "servicios" => 'locales amplios, baños con terma, vestuarios y pelotas oficiales',
                "fotoprincipal" => 'imagen.jpg',
                "foto2" => 'imagen.jpg',
                "foto3" => 'imagen.jpg',
            	"calificacion" => 3
            ],
            [
                "idempresa" => 2,
                "iddistrito" => 1200,
                "nombre" => 'SOCCER CITY',
                "direccion" => 'Av. Por el Ovalo Papal 3214',
                "telefono" => '875421',
                "servicios" => 'locales amplios, baños con terma, vestuarios y pelotas oficiales',
                "fotoprincipal" => 'imagen.jpg',
                "foto2" => 'imagen.jpg',
                "foto3" => 'imagen.jpg',
                "calificacion" => 4
            ],
            [
                "idempresa" => 3,
                "iddistrito" => 1200,
                "nombre" => 'LUDICUS SPORT CENTER',
                "direccion" => 'Av. Detras del Mall Aventura',
                "telefono" => '659832',
                "servicios" => 'locales amplios, baños con terma, vestuarios y pelotas oficiales',
                "fotoprincipal" => 'imagen.jpg',
                "foto2" => 'imagen.jpg',
                "foto3" => 'imagen.jpg',
                "calificacion" => 5
            ]
        ];
        foreach ($locales as $local)
        {
            Local::create($local);
        }
    }

}