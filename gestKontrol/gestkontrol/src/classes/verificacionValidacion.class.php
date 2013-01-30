<?php

class verificacionValidacion
{
	private $nombreEmpresa;
	private $idReserva;
	private $nombreVisita;
	private $apellido;
	private $rut;
	private $dv;
	private $pasaporte;
	private $patente;
	private $estacionamientoAsignado;
	private $piso;
	private $oficina;
	private $tipoFrecuencia;
	private $fechaEntrada;
	private $fechaSalida;
	private $estadoValidacion;
	private $momentoValidacion;
	private $ubicacion;
	private $nomOperador;

	function __construct()
	{
	if(func_num_args()==17)
		{
			$this->nombreEmpresa = func_get_arg(0);
			$this->idReserva = func_get_arg(1);
			$this->nombreVisita = func_get_arg(2);
			$this->apellido=func_get_arg(3);
			$this->rut = func_get_arg(4);
			$this->dv = func_get_arg(5);
			$this->pasaporte = func_get_arg(6);
			$this->patente = func_get_arg(7);
			$this->estacionamientoAsignado = func_get_arg(8);
			$this->piso = func_get_arg(9);
			$this->oficina = func_get_arg(10);
			$this->tipoFrecuencia= func_get_arg(11);
			$this->fechaEntrada = func_get_arg(12);
			$this->fechaSalida = func_get_arg(13);
			$this->estadoValidacion = func_get_arg(14);
			$this->momentoValidacion = func_get_arg(15);
			$this->ubicacion = func_get_arg(16);
			
		}
		if(func_num_args()==18)
			{
				$this->nombreEmpresa = func_get_arg(0);
				$this->idReserva = func_get_arg(1);
				$this->nombreVisita = func_get_arg(2);
				$this->apellido=func_get_arg(3);
				$this->rut = func_get_arg(4);
				$this->dv = func_get_arg(5);
				$this->pasaporte = func_get_arg(6);
				$this->patente = func_get_arg(7);
				$this->estacionamientoAsignado = func_get_arg(8);
				$this->piso = func_get_arg(9);
				$this->oficina = func_get_arg(10);
				$this->tipoFrecuencia= func_get_arg(11);
				$this->fechaEntrada = func_get_arg(12);
				$this->fechaSalida = func_get_arg(13);
				$this->estadoValidacion = func_get_arg(14);
				$this->momentoValidacion = func_get_arg(15);
				$this->ubicacion = func_get_arg(16);
				$this->nomOperador = func_get_arg(17);
					
			}
		

	}

	public function setnombreEmpresa($value)
	{
		$this->nombreEmpresa = $value;

	}

	public function setidReserva($value)
	{
		$this->idReserva = $value;
	}

	public function nombreVisita($value)
	{
		$this->nombreVisita = $value;
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

	public function setpatente($value)
	{
		$this->patente = $value;
	}

	public function setestacionamientoAsignado($value)
	{
		$this->estacionamientoAsignado = $value;
	}

	public function setpiso($value)
	{
		$this->piso = $value;
	}
	
	public function setoficina($value)
	{
		$this->oficina = $value;
	}
	
	public function settipoFrecuencia($value)
	{
		$this->tipoFrecuencia = $value;
	}
	
	public function setfechaEntrada($value)
	{
		$this->fechaEntrada = $value;
	}
	
	public function setfechaSalida($value)
	{
		$this->fechaSalida = $value;
	}
	
	public function setestadoValidacion($value)
	{
		$this->estadoValidacion = $value;
	}
	
	public function setmomentoValidacion($value)
	{
		$this->momentoValidacion = $value;
	}
		
	public function setubicacion($value)
	{
		$this->ubicacion = $value;
	}
	public function setnomOperador($value)
	{
		$this->nomOperador = $value;
	}
	######################GET#####################

	public function getnombreEmpresa()
	{
	return $this->nombreEmpresa;
	}

	public function getidReserva()
	{
	return $this->idReserva;
	}

	public function getnombreVisita()
	{
	return $this->nombreVisita;
	}
	public function getapellido()
	{
		return $this->apellido;
	}
	public function getrut()
	{
	return $this->rut;
	}

	public function getdv()
	{
	return $this->dv;
	}

	public function getpasaporte()
	{
	return $this->pasaporte;
	}

	public function getpatente()
	{
	return $this->patente;
	}

	public function getestacionamientoAsignado()
	{
	return $this->estacionamientoAsignado;
	}

	public function getpiso()
	{
	return $this->piso;
	}
	
	public function getoficina()
	{
		return $this->oficina;
	}
	
	public function gettipoFrecuencia()
	{
		return $this->tipoFrecuencia;
	}
	
	public function getfechaEntrada()
	{
		return $this->fechaEntrada;
	}
	
	public function getfechaSalida()
	{
		return $this->fechaSalida;
	}
	
	public function getestadoValidacion()
	{
		return $this->estadoValidacion;
	}
	
	public function getmomentoValidacion()
	{
		return $this->momentoValidacion;
	}
		
	public function getubicacion()
	{
		return $this->ubicacion;
	}
	public function getnomOperador()
	{
		return $this->nomOperador;
	}
	
}


?>