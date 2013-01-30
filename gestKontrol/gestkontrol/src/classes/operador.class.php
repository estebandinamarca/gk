<?php

class operador
{
	private $idOperador;
	private $nombreComOperador;
	private $mailOperador;
	private $passOperador;
	private $privilegiosOperador;
	private $telefono;
	private $celular;
	private $ubicacionEdificio;
	private $orientacionPos;
	private $idUser;
	
	function __construct()
	{
		if(func_num_args()==9)
		{
			$this->idOperador = func_get_arg(0);
			$this->nombreComOperador = func_get_arg(1);
			$this->mailOperador = func_get_arg(2);
			$this->passOperador = func_get_arg(3);
			$this->privilegiosOperador = func_get_arg(4);
			$this->telefono = func_get_arg(5);
			$this->celular = func_get_arg(6);
			$this->ubicacionEdificio = func_get_arg(7);
			$this->orientacionPos = func_get_arg(8);
		}
		if(func_num_args()==6)
		{
			$this->idOperador = func_get_arg(0);
			$this->telefono = func_get_arg(1);
			$this->celular = func_get_arg(2);
			$this->ubicacionEdificio = func_get_arg(3);
			$this->orientacionPos = func_get_arg(4);
			$this->idUser = func_get_arg(5);
		}
		
	}
	
	public function setidOperador($value)
	{
		$this->idOperador = $value;
		
	}
	
	public function setnombreComOperador($value)
	{
		$this->nombreComOperador = $value;	
	}
	
	public function setmailOperador($value)
	{
		$this->mailOperador = $value;	
	}
	
	public function setpassOperador($value)
	{
		$this->passOperador = $value;	
	}
	
	public function setprivilgiosOperador($value)
	{
		$this->privilegiosOperador = $value;
	}
	
	public function settelefono($value)
	{
		$this->telefono = $value;	
	}
	
	public function setcelular($value)
	{
		$this->celular = $value;	
	}
	
	public function setubicacionEdificio($value)
	{
		$this->ubicacionEdificio = $value;	
	}
	
	public function setorientacionPos($value)
	{
		$this->orientacionPos = $value;	
	}
	
	public function setidUser($value)
	{
		$this->idUser = $value;
	
	}
	
	######################GET#####################
	
	public function getidOperador()
	{
		return $this->idOperador;
	}
	
	public function getnombreComOperador()
	{
		return $this->nombreComOperador;
	}
	
	public function getmailOperador()
	{
		return $this->mailOperador;
	}
	
	public function getpassOperador()
	{
		return $this->passOperador;
	}
	
	public function getprivilegiosOperador()
	{
		return $this->privilegiosOperador;
	}
	
	public function gettelefono()
	{
		return $this->telefono;
	}
	
	public function getcelular()
	{
		return $this->celular;
	}
	
	public function getubicacionEdificio()
	{
		return $this->ubicacionEdificio;
	}
	
	public function getorientacionPos()
	{
		return $this->orientacionPos;
	}
	
	public function getidUser()
	{
		return $this->idUser;
	}
}

?>