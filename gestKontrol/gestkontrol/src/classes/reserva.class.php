<?php

class reserva
{
	private $idReserva;
	private $idCliente;
	private $idOperador;
	private $idVisita;
	private $fechaEntrada;
	private $fechaSalida;
	private $tipoReserva;
	private $tipoFrecuencia;
	private $piso;
	private $oficina;
	private $estacionamientoAsignado;
	private $estadoValidacion;
	private $momentoReserva;
	private $codigoReserva;
	private $patenteVehiculo;
	
	private $idreservaFrecuente;
	private $lunes;
	private $martes;
	private $miercoles;
	private $jueves;
	private $viernes;
	private $sabado;
	private $domingo;
	

	function __construct()
	{
		if(func_num_args()==23)
		{
			$this->idReserva = func_get_arg(0);
			$this->idCliente = func_get_arg(1);
			$this->idOperador = func_get_arg(2);
			$this->idVisita = func_get_arg(3);
			$this->fechaEntrada = func_get_arg(4);
			$this->fechaSalida = func_get_arg(5);
			$this->tipoReserva = func_get_arg(6);
			$this->tipoFrecuencia = func_get_arg(7);
			$this->piso = func_get_arg(8);
			$this->oficina = func_get_arg(9);
			$this->estacionamientoAsignado = func_get_arg(10);
			$this->estadoValidacion = func_get_arg(11);
			$this->momentoValidacion = func_get_arg(12);
			$this->codigoReserva = func_get_arg(13);
			$this->patenteVehiculo = func_get_arg(14);
			$this->idreservaFrecuente = func_get_arg(15);
			$this->lunes = func_get_arg(16);
			$this->martes = func_get_arg(17);
			$this->miercoles = func_get_arg(18);
			$this->jueves = func_get_arg(19);
			$this->viernes = func_get_arg(20);
			$this->sabado = func_get_arg(21);
			$this->domingo = func_get_arg(22);
		}
		if(func_num_args()==15)
		{
			$this->idReserva = func_get_arg(0);
			$this->idCliente = func_get_arg(1);
			$this->idOperador = func_get_arg(2);
			$this->idVisita = func_get_arg(3);
			$this->fechaEntrada = func_get_arg(4);
			$this->fechaSalida = func_get_arg(5);
			$this->tipoReserva = func_get_arg(6);
			$this->tipoFrecuencia = func_get_arg(7);
			$this->piso = func_get_arg(8);
			$this->oficina = func_get_arg(9);
			$this->estacionamientoAsignado = func_get_arg(10);
			$this->estadoValidacion = func_get_arg(11);
			$this->momentoValidacion = func_get_arg(12);
			$this->codigoReserva = func_get_arg(13);
			$this->patenteVehiculo = func_get_arg(14);
			
		}
		if(func_num_args()==9)
		{
			$this->idreservaFrecuente = func_get_arg(0);
			$this->idReserva  = func_get_arg(1);;
			$this->lunes = func_get_arg(2);
			$this->martes = func_get_arg(3);
			$this->miercoles = func_get_arg(4);
			$this->jueves = func_get_arg(5);
			$this->viernes = func_get_arg(6);
			$this->sabado = func_get_arg(7);
			$this->domingo = func_get_arg(8);
			
		}
		
		if(func_num_args()==8)
		{
			$this->idReserva = func_get_arg(0);
			$this->idCliente = func_get_arg(1);
			$this->idVisita = func_get_arg(2);
			$this->fechaEntrada = func_get_arg(3);
			$this->tipoReserva = func_get_arg(4);
			$this->piso = func_get_arg(5);
			$this->oficina = func_get_arg(6);
			$this->estadoValidacion = func_get_arg(7);
			
		}
			
	}
	public function setidReserva($value)
	{
		$this->idReserva = $value;
	}
	
	public function setidCliente($value)
	{
		$this->idCliente = $value;
	}
	
	public function setidOperador($value)
	{
		$this->idOperador = $value;
	}
	
	public function setidVisita($value)
	{
		$this->idVisita = $value;
	}
	
	public function setfechaEntrada($value)
	{
		$this->fechaEntrada = $value;
	}
	
	public function setfechaSalida($value)
	{
		$this->fechaSalida = $value;
	}
	
	public function settipoReserva($value)
	{
		$this->tipoReserva = $value;
	}
	
	public function setpiso($value)
	{
		$this->piso = $value;
	}
	
	public function setoficina($value)
	{
		$this->oficina = $value;
	}
	
	public function setestacionamientoAsingado($value)
	{
		$this->estacionamientoAsignado = $value;
	}
	
	public function setestadoValidacion($value)
	{
		$this->estadoValidacion = $value;
	}
	
	public function setmomentoReserva($value)
	{
		$this->momentoReserva = $value;
	}
	
	public function setcodigoReserva($value)
	{
		$this->codigoReserva = $value;
	}
	
	public function setpatenteVehiculo($value)
	{
		$this->patenteVehiculo = $value;
	}
	
	#################GET####################
	
	public function getidReserva()
	{
		return $this->idReserva;
	}
	
	public function getidCliente()
	{
		return $this->idCliente;
	}
	
	public function getidOperador()
	{
		return $this->idOperador;
	}
	
	public function getidVisita()
	{
		return $this->idVisita;
	}
	
	public function getfechaEntrada()
	{
		return $this->fechaEntrada;
	}
	
	public function getfechaSalida()
	{
		return $this->fechaSalida;
	}
	
	public function gettipoReserva()
	{
		return $this->tipoReserva;
	}
	public function getttipoFrecuencia()
	{
		return $this->tipoFrecuencia;
	}
	public function getpiso()
	{
		return $this->piso;
	}
	
	public function getoficina()
	{
		return $this->oficina;
	}
	
	public function getestacionamientoAsignado()
	{
		return $this->estacionamientoAsignado;
	}
	
	public function getestadoValidacion()
	{
		return $this->estadoValidacion;
	}
	
	public function getmomentoReserva()
	{
		return $this->momentoReserva;
	}
	
	public function getcodigoReserva()
	{
		return $this->codigoReserva;
	}
	
	public function getpatenteVehiculo()
	{
		return $this->patenteVehiculo;
	}
	
	public function getidreservaFrecuente()
	{
		return $this->idreservaFrecuente;
	}
	public function getlunes()
	{
		return $this->lunes;
	}
	public function getmartes()
	{
		return $this->martes;
	}
	public function getmiercoles()
	{
		return $this->miercoles;
	}
	public function getjueves()
	{
		return $this->jueves;
	}
	public function getviernes()
	{
		return $this->viernes;
	}
	public function getsabado()
	{
		return $this->sabado;
	}
	public function getdomingo()
	{
		return $this->domingo;
	}
}
?>