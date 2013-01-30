<?php

class cliente
{
	private $idCliente;
	private $rut;
	private $dv;
	private $nombreEmpresa;
	private $direccion;
	private $oficina;
	private $piso;
	private $orientacion;
	private $telefono;
	private $contacto;
	private $email;
	
	
	function __construct()
	{
		if(func_num_args()==11)
		{
			$this->idCliente = func_get_arg(0);
			$this->rut = func_get_arg(1);
			$this->dv  = func_get_arg(2);
			$this->nombreEmpresa = func_get_arg(3);
			$this->direccion = func_get_arg(4);
			$this->oficina = func_get_arg(5);
			$this->piso = func_get_arg(6);
			$this->orientacion = func_get_arg(7);
			$this->telefono = func_get_arg(8);
			$this->contacto = func_get_arg(9);
			$this->email = func_get_arg(10);
			
			
		}
		if(func_num_args()==5)
		{
			$this->idCliente = func_get_arg(0);
			$this->rut = func_get_arg(1);
			$this->dv  = func_get_arg(2);
			$this->nombreEmpresa = func_get_arg(3);
			$this->direccion = func_get_arg(4);
		}
		
	}
	public function setrut($value)
	{
		
		$this->rut = $value;
	}
	public function setdv($value)
	{
	
		$this->dv = $value;
	}
	public function setnombreEmpresa($value)
	{
	
		$this->nombreEmpresa = $value;
	}
	public function setdireccion($value)
	{
	
		$this->direccion = $value;
	}
	public function setofcina($value)
	{
	
		$this->oficina = $value;
	}
	public function setpiso($value)
	{
	
		$this->piso = $value;
	}
	public function setorientacion($value)
	{
	
		$this->orientacion = $value;
	}
	public function settelefono($value)
	{
	
		$this->telefono = $value;
	}
	public function setcontacto($value)
	{
	
		$this->contacto = $value;
	}
	public function setemail($value)
	{
	
		$this->email = $value;
	}
	public function setidUser($value)
	{
		$this->idUser = $value;
	}
	#####################################
	
	public function getidCliente()
	{
		return $this->idCliente;
	}
	
	public function getrut()
	{
		return $this->rut;
	}
	
	public function getdv()
	{
		return $this->dv;
	}
	
	public function getnombreEmpresa()
	{
		return $this->nombreEmpresa;
	}
	
	public function getdireccion()
	{
		return $this->direccion;
	}
	public function getpiso()
	{
		return $this->piso;
	}
	public function getoficina()
	{
		return $this->oficina;
	}
	
	public function gettelefono()
	{
		return $this->telefono;
	}
	
	public function getcontacto()
	{
		return $this->contacto;
	}
	public function getorientacion()
	{
		return $this->orientacion;
	}
	
	public function getemail()
	{
		return $this->email;
	}
	
	
	
}
?>