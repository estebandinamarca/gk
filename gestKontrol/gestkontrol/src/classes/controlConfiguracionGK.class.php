<?php
require_once ('src/core/conexionMySQLi.class.php');
require_once ('src/core/conexionBD.php');
require_once ('src/core/conf.class.php');
require_once ('src/classes/configuracionGK.class.php');
/*
 * Esta clase establece las opciones que tendrá gestkontrol como sistema.
 * En este caso tendrá pa opción de habilitar o deshabilitar la opcion de envio de correos.
 * 
 */
  
class controlConfiguracionGK 
{
	
	public function getConfiguracion($idconfiguracion=null,$nombreFuncional=null,$nomC=null,$contraC=null,$fecFrecuencia=null,$horaF=null,$mod=null,$estad=null)
	{
		$sql = conexionMySQLi::getInstance();
		$sentencia = "SELECT idconfiguracionGK,nombreFuncionalidad,nombreC,contraseC,fechaFrecuencia,horaFrecuencia,modulo,estado FROM configuracionGK ";
		$filtro = null;
		$capFiltro = array();
		$and = false;
		$where = null;
		$dataConfig = null;
		
		if($idconfiguracion!=null)
		{
			$filtro.= $and?" AND idconfiguracionGK = ?":" idconfiguracionGK = ?";
			$capFiltro[] = $idconfiguracion;
			$and = true;
		}
		if($nombreFuncional!=null)
		{
			$filtro.= $and?" AND nombreFuncionalidad = ?":" nombreFuncionalidad = ?";
			$capFiltro[] = $nombreFuncional; 
			$and = true;
		}
		if($nomC!=null)
		{
			$filtro.= $and? " AND nombreC = ?":" nombreC = ?";
			$capFiltro[] = $nomC;
			$and = true;
		}
		if($contraC!=null)
		{
			$filtro.= $and? " AND contraseC = ?":" contraseC = ?";
			$capFiltro[] = $contraC;
			$and = true;
		}
		if($fecFrecuencia!=null)
		{
			$filtro.= $and? " AND fechaFrecuencia = ?":" fechaFrecuencia = ?";
			$capFiltro[] = $fecFrecuencia;
			$and = true;
		}
		if($horaF!=null)
		{
			$filtro.= $and? " AND horaFrecuencia = ?":" horaFrecuencia = ?";
			$capFiltro[] = $horaF;
			$and = true;
		}
		if($mod!=null)
		{
			
			$filtro.= $and? " AND modulo = ?":" modulo = ?";
			$capFiltro[] = $mod;
			$and = true;
		}
		if($estad!=null)
		{
			$filtro.= $and? " AND estado = ?":" estado = ?";
			$capFiltro[] = $estad;
			$and = true;
		}
		
		if($and)
		{
			$where = "WHERE";
			
			$resulset = $sql->devDatos($sentencia.$where.$filtro,$capFiltro);
			$resulset ->bind_result($idconfiguracionGK,$nombreFuncionalidad,$nombreC,$contraseC,$fechaFrecuencia,$horaFrecuencia,$modulo,$estado);
			
			while($resulset->fetch())
			{
				$dataConfig = new configuracionGK($idconfiguracionGK,$nombreFuncionalidad,$nombreC,$contraseC,$fechaFrecuencia,$horaFrecuencia,$modulo,$estado);
			}
		}
		else
		{
			$resulset = $sql->devDatos($sentencia);
			while($value = $resulset->fetch_assoc())
			{
				$dataConfig =  new configuracionGK($value["idconfiguracionGK"],$value["nombreFuncionalidad"],$value["nombreC"],$value["contraseC"],$value["fechaFrecuencia"],$value["horaFrecuencia"],$value["modulo"],$value["estado"]);
			}
		}
		
		return $dataConfig;
	}
	
	public function updateConfiguracion($configuracion=null,$estado=null)
	{
		$sql = conexionMySQLi::getInstance();
		if ($configuracion!=null&&$estado!=null)
		{
			$sentencia = "UPDATE configuracionGK set estado = ? WHERE nombreFuncionalidad = ?";
			return $sql-> ejecutarSentencia($sentencia,array($estado,$configuracion));
		}
		else return "-1";
	}
	
}

?>