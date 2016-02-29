<?php

$users = DB::select('SELECT CONCAT(l.nombre, "  (", p.nombre, " - ", p.nombre, ")") as value FROM locales l 
					INNER JOIN distritos d ON l.iddistrito = d.iddistrito 
					INNER JOIN provincias p ON d.idprovincia = p.idprovincia');

echo json_encode($users);
//echo Response::json($users);