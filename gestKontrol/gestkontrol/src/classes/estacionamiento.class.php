<?php
class estacionamiento
{
	private $idEstacionamiento;
	private $idCliente;
	private $subterraneo;
	private $numero;
	private $estado;

	function __construct()
	{
		if(func_num_args()==4)
		{
			$this->idEstacionamiento = func_get_arg(0);
			$this->idCliente = func_get_arg(1);
			$this->subterraneo = func_get_arg(2);
			$this->numero = func_get_arg(3);
		}
		
		if(func_num_args()==5)
		{
			$this->idEstacionamiento = func_get_arg(0);
			$this->idCliente = func_get_arg(1);
			$this->subterraneo = func_get_arg(2);
			$this->numero = func_get_arg(3);
			$this->estado = func_get_arg(4);
		}	
		
	}
	
	public function setidEstacionamiento($value)
	{
		$this->idEstacionamiento = $value;
	}
	
	public function setidCliente($value)
	{
		$this->idCliente = $value;
	}
	
	public function setsubterraneo($value)
	{
		$this->subterraneo = $value;
	}
	
	public function setnumero($value)
	{
		$this->numero = $value;
	}
	
	public function setestado($value)
	{
		$this->estado = $value;
	}	

	##############GET##############
	
	public function getidEstacionamiento()
	{
		return $this->idEstacionamiento;		
	}
	
	public function getidCliente()
	{
		return $this->idCliente;
	}
	
	public function getsubterraneo()
	{
		return $this->subterraneo;
	}
	
	public function getnumero()
	{
		return $this->numero;
	}
	
	public function getestado()
	{
		return $this->estado;
	}
	
}
?>
