<?php
class email
{
	public $url;
	public $destino;
	public $cabeceras;
	public $asunto;
	public $mensaje;
	public $imagenes;
	
	function __construct()
	{
		if(func_num_args()==6)
		{
			$this->url = func_get_arg(0);
			$this->destino = func_get_arg(1);
			$this->cabeceras  = func_get_arg(2);
			$this->asunto = func_get_arg(3);
			$this->mensaje = func_get_arg(4);
			$this->imagenes = func_get_arg(5);
		}
		
	}
	
	
	
	
	
}
?>