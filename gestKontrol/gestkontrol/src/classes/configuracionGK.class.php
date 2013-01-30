<?php

class configuracionGK 
{
	private $idconfiguracionGK;
	private $nombreFuncionalidad;
	private $nombreC;
	private $contraseC;
	private $fechaFrecuencia;
	private $horaFrecuencia;
	private $modulo;
	private $estado;
	
	function __construct()
	{
		if(func_num_args()==8)
		{
			$this->idconfiguracionGK = func_get_arg(0);
			$this->nombreFuncionalidad = func_get_arg(1);
			$this->nombreC = func_get_arg(2);
			$this->contraseC  = func_get_arg(3);
			$this->fechaFrecuencia = func_get_arg(4);
			$this->horaFrecuencia = func_get_arg(5);
			$this->modulo = func_get_arg(6);
			$this->estado = func_get_arg(7);
		}
	}
	
	/*
	 * Aqui los set
	 * no hay tiempo para eso ahora
	 * 
	 */
	
	public function getnombreFuncionalidad()
	{
		return $this->nombreFuncionalidad;
	}
	
	public function getnombreC()
	{
		return $this->nombreC;
	}
	
	public function getcontraC()
	{
		return $this->contraseC;
	}
	
	public function getfechaFrecuencia()
	{
		return $this->fechaFrecuencia;
	}
	
	public function gethoraFrecuente()
	{
		return $this->horaFrecuencia;
	}
	
	public function getmodulo()
	{
		return $this->modulo;
	}
	
	public function getestado()
	{
		return $this->estado;
	}
}
?>
