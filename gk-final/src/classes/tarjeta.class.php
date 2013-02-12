<?php
class tarjeta
{
	private $idTarjeta;
	private $numeroTarjeta;
	private $codigBarraTarjeta;
	private $codigoRfid;
	private $estado;
	
	function __construct()
	{
		if(func_num_args()==5)
		{
			$this->idTarjeta= func_get_arg(0);
			$this->numeroTarjeta= func_get_arg(1);
			$this->codigBarraTarjeta= func_get_arg(2);
			$this->codigoRfid= func_get_arg(3);
			$this->estado= func_get_arg(4);
		}
	}
	public function setidTarjeta($value)
	{
		$this->idTarjeta = $value;
	}
	public function setnumeroTarjeta($value)
	{
		$this->numeroTarjeta = $value;
	}
	public function setcodigBarraTarjeta($value)
	{
		$this->codigBarraTarjeta = $value;
	}
	public function setcodigoRfid($value)
	{
		$this->codigoRfid = $value;
	}
	public function setestado($value)
	{
		$this->estado = $value;
	}
	//-------------------------------
	public function getidTarjeta()
	{
		return $this->idTarjeta;
	}
	public function getnumeroTarjeta()
	{
		return $this->numeroTarjeta;
	}
	public function getcodigBarraTarjeta()
	{
		return $this->codigBarraTarjeta;
	}
	public function getcodigoRfid()
	{
		return $this->codigoRfid;
	}
	public function getestado()
	{
		return $this->estado;
	}
}
?>