<?php
class detalleTarjeta
{
	private $idDetalleTarjeta;
	private $idTarjeta;
	private $idVisita;
	private $idReserva;
	private $fechaSolicitud;
	
	function __construct()
	{
		if(func_num_args()==5)
		{
			$this->$idDetalleTarjeta= func_get_arg(0);
			$this->$idTarjeta= func_get_arg(1);
			$this->$idVisita= func_get_arg(2);
			$this->$idReserva= func_get_arg(3);
			$this->$fechaSolicitud= func_get_arg(4);
		}
	}
	public function setidDetalleTarjeta($value)
	{
		$this->idDetalleTarjeta = $value;
	}
	public function setidTarjeta($value)
	{
		$this->idTarjeta = $value;
	}
	public function setidVisita($value)
	{
		$this->idVisita = $value;
	}
	public function setidReserva($value)
	{
		$this->idReserva = $value;
	}
	public function setfechaSolicitud($value)
	{
		$this->fechaSolicitud = $value;
	}
	//-------------------------------
	public function getidDetalleTarjeta()
	{
		return $this->idDetalleTarjeta;
	}
	public function getidTarjeta()
	{
		return $this->idTarjeta;
	}
	public function getidVisita()
	{
		return $this->idVisita;
	}
	public function getidReserva()
	{
		return $this->idReserva;
	}
	public function getfechaSolicitud()
	{
		return $this->fechaSolicitud;
	}
}
?>