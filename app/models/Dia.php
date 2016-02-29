<?php

class Dia extends Eloquent{

	protected $fillable = array('idcancha', 'nombre');
	protected $primaryKey = "iddia";

	public function periodos(){
		return $this->hasMany('Periodo', 'iddia');
	}

	public function cancha(){
		return $this->belongsTo('Cancha', 'idcancha');
	}

}