<?php

class UsuarioSeeder extends DatabaseSeeder{

	public function run()
    {
        $users = [
            [
            	"idempresa" => null,
            	"idlocal" => null,
            	"tipo" => "Usuario",
            	"nombrecompleto" => "Enzo Arturo Ruiz Pelaez",
            	"foto" => null,
            	"dni" => "46189561",
            	"email"    => "enz_rp@hotmail.com",
            	"celular" => "949245402",
                "username" => "enxrp",
                "password" => Hash::make("123456789")
            ]
        ];
        foreach ($users as $user)
        {
            Usuario::create($user);
        }
    }

}