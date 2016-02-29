<?php 

class Hora extends Eloquent{

	protected $table = "horas";
	protected $primaryKey = "idhora";
	protected $fillable = array("idperiodo", "horaingreso", "horasalida");

	public function periodo(){
		return $this->belongsTo('Periodo', 'idperiodo');
	}

}