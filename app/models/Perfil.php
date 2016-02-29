<?php

class Perfil extends Eloquent{

	protected $primaryKey = "idperfil";
	protected $table = 'perfiles';
	protected $fillable = array('idusuario', 'proviene', 'username', 'uid', 'access_token', 'access_token_secret');

	public function usuario(){
		return $this->belongsTo('Usuario', 'idusuario');
	}



}