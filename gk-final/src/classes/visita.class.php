<?php

class visita
{
	private $idVisita;
	private $rut;
	private $dv;
	private $pasaporte;
	private $nombre;
	private $apellito;
	private $direccion;
	private $telefono;
	private $contacto;
	private $rubro;
	private $servicio;
	private $tipoVisita;
	private $empresa;
	
	function __construct()
	{
		if(func_num_args()==13)
		{
			$this->idVisita = func_get_arg(0);
			$this->rut = func_get_arg(1);
			$this->dv = func_get_arg(2);
			$this->pasaporte = func_get_arg(3);
			$this->nombre = func_get_arg(4);
			$this->apellito = func_get_arg(5);
			$this->direccion = func_get_arg(6);
			$this->telefono = func_get_arg(7);
			$this->contacto = func_get_arg(8);
			$this->rubro = func_get_arg(9);
			$this->servicio = func_get_arg(10);
			$this->tipoVisita = func_get_arg(11);
			$this->empresa = func_get_arg(12);
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
	
	public function setpasaporte($value)
	{
		$this->pasaporte = $value;
	}
	
	public function setnombre($value)
	{
		$this->nombre = $value;
	}
	
	public function setdireccion($value)
	{
		$this->direccion = $value;
	}
	
	public function settelefono($value)
	{
		$this->telefono = $value;
	}
	
	public function setcontacto($value)
	{
		$this->contacto = $value;
	}
	
	public function setrubro($value)
	{
		$this->rubro = $value;
	}
	
	public function setservicio($value)
	{
		$this->servicio = $value;
	}
	
	public function settipoVisita($value)
	{
		$this->tipoVisita = $value;
	}
	
	public function setempresa($value)
	{
		$this->empresa = $value;
	}
	
	##############GET##############
	
	public function  getidVisista()
	{
		return $this->idVisita;
	}
	
	public function  getrut()
	{
		return $this->rut;
	}
	
	public function  getdv()
	{
		return $this->dv;
	}
	
	public function  getpasaporte()
	{
		return $this->pasaporte;
	}
	
	public function  getnombre()
	{
		return $this->nombre;
	}
	
	public function  getapellido()
	{
		return $this->apellito;
	}
	
	public function  getdireccion()
	{
		return $this->direccion;
	}
	
	public function  gettelefono()
	{
		return $this->telefono;
	}
	
	public function  getcontacto()
	{
		return $this->contacto;
	}
	
	public function  getrubro()
	{
		return $this->rubro;
	}
	
	public function  getservicio()
	{
		return $this->idVisita;
	}
	
	public function  gettipoVisita()
	{
		return $this->tipoVisita;
	}
	
	public function getempresa()
	{
		return $this->empresa;		
	}
}
?>