<?php

class detalleCliente
{
	private $idDetalleCliente;
	private $idCliente;
	private $oficina;
	private $piso;
	private $orientacion;
	private $telefono;
	private $contacto;
	private $email;
	
	function __construct()
	{
		if(func_num_args()==8)
		{
			$this->idDetalleCliente = func_get_arg(0);
			$this->idCliente = func_get_arg(1);
			$this->oficina = func_get_arg(2);
			$this->piso = func_get_arg(3);
			$this->orientacion = func_get_arg(4);
			$this->telefono = func_get_arg(5);
			$this->contacto = func_get_arg(6);
			$this->email = func_get_arg(7);
		}
		
	}
	public function getidDetallecliente()
	{
		return $this->idDetalleCliente;
	}
	
	public function getidCliente()
	{
		return $this->idCliente;
	}
	
	public function getoficina()
	{
		return $this->oficina;
	}
	
	public function getpiso()
	{
		return $this->piso;
	}
	
	public function getorientacion()
	{
		return $this->orientacion;
	}
	
	public function gettelefono()
	{
		return $this->telefono;
	}
	
	public function getcontacto()
	{
		return $this->contacto;
	}
	
	public function getemail()
	{
		return $this->email;
	}
}
?>