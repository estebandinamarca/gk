<?php
require_once ('src/classes/cliente.class.php');
require_once ('src/classes/visita.class.php');

class detalleVisita
{
	private $idDetalleVisita;
	private $cliente;
	private $visita;
	
	function __construct()
	{
		if(func_num_args()==24)
		{
			$this->idDetalleVisita = func_get_arg(0);
			$this->cliente = new cliente
			(
			   	func_get_arg(1),
			   	func_get_arg(2),
			   	func_get_arg(3),
			   	func_get_arg(4),
			   	func_get_arg(5),
				func_get_arg(6),
				func_get_arg(7),
				func_get_arg(8),
				func_get_arg(9),
				func_get_arg(10),
				func_get_arg(11)
					
			 );

			$this->visita = new visita
			(
				
					func_get_arg(12),
					func_get_arg(13),
					func_get_arg(14),
					func_get_arg(15),
					func_get_arg(16),
					func_get_arg(17),
					func_get_arg(18),
					func_get_arg(19),
					func_get_arg(20),
					func_get_arg(21),
					func_get_arg(22),
					func_get_arg(23)
					
			
			);
		}
		
		
	}	
	################SET###############
	
	###############GET################
	public function getidDetalleProveedor()
	{
		return $this->idDetalleProveedor;		
	}
	public function getcliente()
	{
		return $this->cliente;
	}
	
	public function getvisitante()
	{
		return $this->visita;
	}
}

?>