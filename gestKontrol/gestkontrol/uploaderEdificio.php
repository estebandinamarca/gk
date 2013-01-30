<?php
require_once 'src/classes/controlEdificio.class.php';

if($_POST)
{
	if(isset($_POST['ofConComa1']))
	{
		$piso=array();
		$oficinas=array();
		$orientacion=array();
		for($i=1;$i<=(count($_POST))/2;$i++)
		{
			if(isset($_POST['pisoConComa'.$i]))$piso[]=$_POST['pisoConComa'.$i];
			if(isset($_POST['ofConComa'.$i]))$grupoOficina[]=$_POST['ofConComa'.$i];
			if(isset($_POST['ori'.$i]))$orientacion[]=$_POST['ori'.$i];
		}
		
		for ($j=0;$j<count($grupoOficina);$j++)
		{
			$oficinas[]=explode(",",$grupoOficina[$j]);
			if (count($oficinas[$j]>1))
			{
				for ($l=0;$l<count($oficinas[$j]);$l++)
				{
					//insertar la oficina con el piso
					if(is_numeric($oficinas[$j][$l])&&is_numeric($piso[$j]))
					{
						if ($oficinas[$j][$l]!=""&&$piso[$j]!="")
						{
							$data=array($oficinas[$j][$l],$piso[$j]);
							$resultado[]=controlEdificio::insertPisoOficina($data);
						}
					}
					else
					{ 
						$l=10000*10000;
						$resultado="-2";//Datos mal ingresados
					}
					
				}
			}
			else 
			{
				if(is_numeric($oficinas[$j])&&is_numeric($piso[$j]))
				{
					if ($oficinas[$j]!=""&&$piso[$j]!="")
					{
						$data=array($oficinas[$j],$piso[$j]);
						$resultado[]=controlEdificio::insertPisoOficina($data);
					}
				}
				else
				{
					$j=10000*10000;
					$resultado="-2";//Datos mal ingresados
				}
			}
			
		}
		if($resultado=="-2") echo "-2";//Datos mal ingresados
		else 
		{
			if (in_array("-1",$resultado)) echo "-1"; // Algo salio mal en la Insercion
			else echo "1"; // Todo OK
		}
	}
	if(isset($_POST['estConComa1']))
	{
		$piso=array();
		$estacionamiento=array();
		for($i=1;$i<=(count($_POST))/2;$i++)
		{
			$piso[]=$_POST['pisoConComa'.$i];
			$grupoEstacionamiento[]=$_POST['estConComa'.$i];
			if (isset($_POST['esProv'.$i])) $esProv[]="1";
			else $esProv[]="0";
		}
			
		for ($j=0;$j<count($grupoEstacionamiento);$j++)
		{
			$estacionamiento[]=explode(",",$grupoEstacionamiento[$j]);
			if (count($estacionamiento[$j]>1))
			{
				for ($l=0;$l<count($estacionamiento[$j]);$l++)
				{
			//	insertar la oficina con el piso
					if(is_numeric($estacionamiento[$j][$l])&&is_numeric($piso[$j]))
					{
						if ($estacionamiento[$j][$l]!=""&&$piso[$j]!="")
						{
							$data=array($estacionamiento[$j][$l],$piso[$j],$esProv[$j]);
							$resultado[]=controlEdificio::insertSubEstacionamiento($data);
						}
					}
					else
					{
						$l=10000*10000;
						$resultado="-2";//Datos mal ingresados
					}
				}
			}
			else
			{
				if(is_numeric($estacionamiento[$j])&&is_numeric($piso[$j]))
				{
					if ($estacionamiento[$j]!=""&&$piso[$j]!="")
					{
						$data=array($estacionamiento[$j],$piso[$j],$esProv[$j]);
						$resultado[]=controlEdificio::insertSubEstacionamiento($data);
					}
				}
				else
				{
					$j=10000*10000;
					$resultado="-2";//Datos mal ingresados
				}
			}
	
		}
		if($resultado=="-2") echo "-2";//Datos mal ingresados
		else
		{
			if (in_array("-1",$resultado)) echo "-1"; // Algo salio mal en la Insercion
			else echo "1"; // Todo OK
		}
	}
}

?>
