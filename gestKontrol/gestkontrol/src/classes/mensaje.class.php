<?php
class mensaje
{
	private $idMensaje;
	private $from;
	private $to;
	private $asunto;
	private $contenido;
	private $estado;
	private $fecha;
	
	
	function __construct()
	{
		if(func_num_args()==7)
		{
			$this->idMensaje= func_get_arg(0);
			$this->from= func_get_arg(1);
			$this->to= func_get_arg(2);
			$this->asunto= func_get_arg(3);
			$this->contenido= func_get_arg(4);
			$this->estado= func_get_arg(5);
			$this->fecha= func_get_arg(6);
		}
	}
	public function setidMensaje($value)
	{
		$this->idMensaje = $value;
	}
	public function setfrom($value)
	{
		$this->from = $value;
	}
	public function setto($value)
	{
		$this->to = $value;
	}
	public function setasunto($value)
	{
		$this->asunto = $value;
	}
	public function setcontenido($value)
	{
		$this->contenido = $value;
	}
	public function setestado($value)
	{
		$this->estado = $value;
	}
	public function setfecha($value)
	{
		$this->fecha = $value;
	}
	//-------------------------------
	public function getidMensaje()
	{
		return $this->idMensaje;
	}
	public function getfrom()
	{
		return $this->from;
	}
	public function getto()
	{
		return $this->to;
	}
	public function getasunto()
	{
		return $this->asunto;
	}
	public function getcontenido()
	{
		return $this->contenido;
	}
	public function getestado()
	{
		return $this->estado;
	}
	public function getfecha()
	{
		return $this->fecha;
	}
}
?>