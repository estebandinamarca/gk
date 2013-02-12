<?php

date_default_timezone_set('America/Santiago');

class FechaHora{
	protected $dia;
	protected $mes;
	protected $anio;
	protected $hora;
	protected $minuto;
	protected $segundo;
	
	public function __construct(){
		switch(func_num_args()) {
			//"aaaa-mm-dd hh:mm:ss"
			case 1:
				$this->set(func_get_arg(0));
			break;
			default:
				$this->set(FechaHora::getNowI());
			break;
		}
	}
	
	public function set($var){
			$arr = explode(" ", $var);
			if(count($arr)==2){
				$fecha = explode("-",$arr[0]);
				$hora = explode(":",$arr[1]);
				if(count($fecha) == 3 && count($hora) == 3){
					if(strlen($fecha[0])==4){
						$this->anio = $fecha[0];
						$this->mes = $fecha[1];
						$this->dia = $fecha[2];
					}else{
						$this->anio = $fecha[2];
						$this->mes = $fecha[1];
						$this->dia = $fecha[0];
					}
					$this->hora = $hora[0];
					$this->minuto = $hora[1];
					$this->segundo = $hora[2];
					$isset = true;
				}else $this->set(FechaHora::getNowI());
			}else $this->set(FechaHora::getNowI());		
	}
	
	//hh:mm:ss
	public function getTime(){
		return $this->hora.':'.$this->minuto.':'.$this->segundo;
	}
	
	//hh
	public function getHora(){
		return $this->hora;
	}
	
	//mm
	public function getMinutos(){
		return $this->minuto;
	}	

	//ss
	public function getSegundos(){
		return $this->segundo;
	}
	//dd-mm-aaaa
	public function getFecha(){
		return $this->dia.'-'.$this->mes.'-'.$this->anio; 
	}
	
	public function getDia(){
		return $this->dia;
	}
	
	public function getAno(){
		return $this->anio;
	}
	
	//aaaa-mm-dd
	public function getFechaI()
	{
		return $this->anio.'-'.$this->mes.'-'.$this->dia;
	}
	
	//dd-mm-aaaa hh:mm:ss
	public function getFechaHora(){
		return $this->dia.'-'.$this->mes.'-'.$this->anio.' '.$this->hora.':'.$this->minuto.':'.$this->segundo;
	}

	//aaaa-mm-dd hh:mm:ss
	public function getFechaHoraI(){
		return $this->anio.'-'.$this->mes.'-'.$this->dia.' '.$this->hora.':'.$this->minuto.':'.$this->segundo;
	}
	
	//Febrero
	public function getNombreMes(){
		$meses  = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembe","Diciembre");
		return $meses[intval($this->mes)-1];
	}

	//Feb
	public function getNombreMesAbr(){
		$meses  = array("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");
		return $meses[intval($this->mes)-1];
	}
	
	public function invertir($valor){
		if(strlen($valor)==10){
			$datas = explode("-", $valor);
			if(count($datas)==3)return $datas[2].'-'.$datas[1].'-'.$datas[0];
		}else{
			if(strlen($valor)>=10){
				$datas = explode("-", substr($valor,0,10));
				if(count($datas)==3)return $datas[2].'-'.$datas[1].'-'.$datas[0].substr($valor,10);
			}
		}
		return null;
	}
	
	public function getNow(){
		return date("d-m-Y H:i:s");
	}
	
	public function getNowI(){
		return date("Y-m-d H:i:s");
	}
	
	public function getTodayEnLetras(){
		$fecha = new fechaHora();
		//print_r($fecha); die;
		return  $fecha->getDia()." de ".$fecha->getNombreMes()." de ".$fecha->getAno();
	}
	
	public function mes2dias($mes){
		$meses = array(31,28,31,30,31,30,31,31,30,31,30,31);
		$dias = 0;
		for($i=($mes-1);$i>=0;$i--) $dias+=$meses[$i]; 
		return $dias;
	}
	
	public function year2dias($year){
		return $year*365;
	}
	
	public function year2meses($year){
		return $year*12;
	}
	
	public function getDifDays($fecha1, $fecha2){
		$Fecha1 = explode("-",$fecha1);
		$Fecha2 = explode("-",$fecha2);
		
		$anio1 = 0;
		$anio2 = 0;
		$mes1 = 0;
		$mes2 = 0;
		$dia1 = 0;
		$dia2 = 0;

		if(strlen($Fecha1[0])==4){
			$anio1 = $Fecha1[0];
			$mes1 = $Fecha1[1];
			$dia1 = $Fecha1[2];
		}else{
			$anio1 = $Fecha1[2];
			$mes1 = $Fecha1[1];
			$dia1 = $Fecha1[0];
		}
		if(strlen($Fecha1[0])==4){
			$anio2 = $Fecha2[0];
			$mes2 = $Fecha2[1];
			$dia2 = $Fecha2[2];
		}else{
			$anio2 = $Fecha2[2];
			$mes2 = $Fecha2[1];
			$dia2 = $Fecha2[0];
		}

		$dif = (FechaHora::year2dias($anio1)+FechaHora::mes2dias($mes1)+$dia1)-(FechaHora::year2dias($anio2)+FechaHora::mes2dias($mes2)+$dia2);
		
		return $dif<0?($dif*-1):($dif);
	}
	public function inverFecha($fecha) // formato 26/07/2012 y retorna anio-mes-dia
	{
		if(strpos($fecha,"/")>0)
		{
			$corteFecha = split("/", $fecha);
			$invertir = $corteFecha[2]."-".$corteFecha[1]."-".$corteFecha[0];
			return $invertir;
			
		}
		else{return $fecha;}
	}
}

	//USAGE
	//$asdf = "aaaa-mm-dd hh:mm:ss";
	//$asdf = "dd-mm-aaaa";
	//echo FechaHora::invertir($asdf);
	//$fechahora = new FechaHora();
	//echo $fechahora->getNombreMesAbr();
	//echo '<br />';
	//echo FechaHora::getNowI();
/*	
	foreach($arr as $a){
		echo $a.'<br />';
	}
*/
/*	$fecha1 = "2011-01-01";
	$fecha2 = "2011-05-02";
	
	echo FechaHora::getDifDays($fecha1,$fecha2);*/
	
	//echo strpos($fecha1,"-").', '.strlen($fecha1).', dias: '.fechaHora::mes2dias(6);
	//echo fechaHora::getDifDays($fecha1,$fecha2);

?>
