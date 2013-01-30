<?php
define('PATH_SOURCE_CLASSES','src/classes/');
define('PATH_SOURCE_CORE','src/core/');
define('PATH_ABSOLUTE',dirname(__FILE__).DIRECTORY_SEPARATOR);
if(!defined('PATH_SOURCE_CORE')) die ('Directorio de fuentes del nucleo no esta definida, por favor contacte al administrador o implementador.');
require_once(PATH_SOURCE_CORE.'conexionMySQLi.class.php');
require_once(PATH_SOURCE_CORE.'conf.class.php');
require_once(PATH_SOURCE_CLASSES.'visita.class.php');
require_once(PATH_SOURCE_CLASSES.'controlDetalleVisita.class.php');
/*
 * esta capa control realiza las modificaciones sobre tabla visita y detalleVisita
 * pasaporte : en numero es el rut de la persona
 */
class controlVisita
{
	public function insertVisita($data,$idCliente=null)
	{
		$sql = conexionMySQLi::getInstance();
		$visita = null;
		$sentencia = "INSERT INTO visita (rut,dv,pasaporte,nombre,apellido,direccion,telefono,rubro,contacto,servicio,tipoVisita,empresa) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
		$compa=null;
		$dacontrol = null;
		$control = false;
		$yaAlmacenadaV = null;
		$return = 0;
		$idAutoIncrementable = null;
				
					
					if($data[0]==null)
					{
						$dacontrol = array($data[0],$data[1],$data[2],$data[3],$data[4],$data[5],$data[6],$data[7],$data[8],$data[9],$data[10],$data[11],$idCliente);
												
						$compa = controlVisita::verificaSiRutNoEx($data[0],$dacontrol); 
						// el primer parametro es rut, segundo los datos ordenados, y tercero el estado si es 1 significa que es para comprobar si existe el rut para la primera insercion!!
						//print_r($compa);
						$return = 3;
						$control = true;
					}
					else
					{
						
						$compa = controlVisita::verificaSiRutNoEx($data[0],null,null,null,$idCliente);
						$yaAlmacenadaV = controlVisita::verificaSiRutNoEx($data[0],null,null,null,null);
						$return = 1;
						
					}
					
					if($compa==null && $yaAlmacenadaV==null)
					{
						//die("solo es la primera prueba");
						//print_r($data);
						//die();
						$idAutoIncrementable = $sql-> ejecutarSentencia($sentencia,$data);
						//$visita = controlVisita::verificaSiRutNoEx($data[0],$dacontrol,123,1);
						if($idAutoIncrementable!=null && $idAutoIncrementable>0)
						{
							controlDetalleVisita::insertVisitaCliente($idAutoIncrementable,$idCliente);
						}
						else
						{
							$return = -4; // problemas en la inserción de la visita
						}
							
												
						return $return; // listo
					}
					else
					{
						if($compa==null && $yaAlmacenadaV!=null)
						{
							$idAutoIncrementable = $yaAlmacenadaV->getidVisista();
							//$visita = controlVisita::verificaSiRutNoEx($data[0],$dacontrol,123,1);
							if($idAutoIncrementable!=null && $idAutoIncrementable>0)
							{
								controlDetalleVisita::insertVisitaCliente($idAutoIncrementable,$idCliente);
							}
							else
							{
								$return = -4; // problemas en la inserción de la visita
							}
							return $return; // listo
						}
						else
						{
							return "-2";
						}
						/*if($control || $compa!=null)
						{
							return $compa;	//
						}
						else
						{
							 // rut ya esta ingresado
						} */
						  // rut ya esta ingresado
						
					}
		
				 
	}
	
	/*
	 * Para el calendario estaba mal pensado la primera insercion de datos en la tabla visita
	 */
	
	public function insertVisitaYretId($data,$idCliente=null)
	{
		$sql = conexionMySQLi::getInstance();
		$visita = null;
		$sentencia = "INSERT INTO visita (rut,dv,pasaporte,nombre,apellido,direccion,telefono,rubro,contacto,servicio,tipoVisita,empresa) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
		$compa=null;
		$dacontrol = null;
		$control = false;
		$yaAlmacenadaV = null;
		$return = 0;
		$idAutoIncrementable = null;
		//var_dump($data);
	
			
		if($data[0]==null)
		{
			$dacontrol = array($data[0],$data[1],$data[2],$data[3],$data[4],$data[5],$data[6],$data[7],$data[8],$data[9],$data[10],$data[11],$idCliente);
	
			$compa = controlVisita::verificaSiRutNoEx($data[0],$dacontrol);
			// el primer parametro es rut, segundo los datos ordenados, y tercero el estado si es 1 significa que es para comprobar si existe el rut para la primera insercion!!
			//print_r($compa);
			$return = 3;
			$control = true;
		}
		else
		{
	
			$compa = controlVisita::verificaSiRutNoEx($data[0],null,null,null,$idCliente);
			$yaAlmacenadaV = controlVisita::verificaSiRutNoEx($data[0],null,null,null,null);
			$return = 1;
	
		}
			
		if($compa==null && $yaAlmacenadaV==null)
		{
			//echo $sentencia." ".print_r($data).print_r($dacontrol)."compa->".$compa;
			$idAutoIncrementable = $sql-> ejecutarSentencia($sentencia,$data);
			
			//$visita = controlVisita::verificaSiRutNoEx($data[0],$dacontrol,123,1);
			if($idAutoIncrementable!=null && $idAutoIncrementable>0)
			{
				 controlDetalleVisita::insertVisitaCliente($idAutoIncrementable,$idCliente);
				 $return = $idAutoIncrementable;
			}
			else
			{
				$return = -4; // problemas en la inserción de la visita
			}
				
	
			return $return; // listo
		}
		else
		{
			if($compa==null && $yaAlmacenadaV!=null)
			{
				$idAutoIncrementable = $yaAlmacenadaV->getidVisista();
				//$visita = controlVisita::verificaSiRutNoEx($data[0],$dacontrol,123,1);
				if($idAutoIncrementable!=null && $idAutoIncrementable>0)
				{
					controlDetalleVisita::insertVisitaCliente($idAutoIncrementable,$idCliente);
					$return = $idAutoIncrementable;
				}
				else
				{
					$return = -4; // problemas en la inserción de la visita
				}
				return $return; // listo
			}
			else
			{
				if($compa!=null && $yaAlmacenadaV!=null)
				{
					$idAutoIncrementable = $yaAlmacenadaV->getidVisista();
					//$visita = controlVisita::verificaSiRutNoEx($data[0],$dacontrol,123,1);
					if($idAutoIncrementable!=null && $idAutoIncrementable>0)
					{
						controlDetalleVisita::insertVisitaCliente($idAutoIncrementable,$idCliente);
						$return = $idAutoIncrementable;
					}
					else
					{
						$return = -4; // problemas en la inserción de la visita
					}
					return $return; // listo
				}
				else return  "-2";
			}
				
		}
	
			
	}
	
	/*
	 * fin parche de insercion de visitas
	*/
	
	public function verificaSiRutNoEx($rutc,$mas=null,$estado=null,$inicio=null,$idCliente=null)
	{
		
		$sql = conexionMySQLi::getInstance();
		
			$visita = null;
			$and = false;
						
		if($rutc!=null && $mas==null && $estado==null && $inicio==null && $idCliente==null)//esta parte fue un parche, pero puede servir.
		{
			$sentencia = "SELECT visita.idVisita,visita.rut,visita.dv,visita.pasaporte,visita.nombre,visita.apellido,visita.direccion,visita.telefono,visita.contacto,visita.rubro,visita.servicio,visita.tipoVisita,visita.empresa FROM visita WHERE visita.rut = ?";
			$resulset = $sql->devDatos($sentencia,array($rutc));
			$resulset ->bind_result($idVisita,$rut,$dv,$pasaporte,$nombre,$apellido,$direccion,$telefono,$contacto,$rubro,$servicio,$tipoVisita,$empresa);
				
			if($resulset->fetch())
			{
				$visita = new visita($idVisita,$rut,$dv,$pasaporte,$nombre,$apellido,$direccion,$telefono,$contacto,$rubro,$servicio,$tipoVisita,$empresa);
			}
		}
		else
		{	
			
			$sentencia = "SELECT visita.idVisita,visita.rut,visita.dv,visita.pasaporte,visita.nombre,visita.apellido,visita.direccion,visita.telefono,visita.contacto,visita.rubro,visita.servicio,visita.tipoVisita,visita.empresa FROM ";
			if($mas==null && $rutc!=null && $idCliente!=null)
			{	
				$filtro = "visita,detalleVisita WHERE visita.rut = ? AND detalleVisita.idCliente = ? AND visita.idVisita = detalleVisita.idVisita";
				$resulset = $sql->devDatos($sentencia.$filtro,array($rutc,$idCliente));
				$resulset ->bind_result($idVisita,$rut,$dv,$pasaporte,$nombre,$apellido,$direccion,$telefono,$contacto,$rubro,$servicio,$tipoVisita,$empresa);
				//echo "aqui";
				//die();
				if($resulset->fetch())
				{
					$visita = new visita($idVisita,$rut,$dv,$pasaporte,$nombre,$apellido,$direccion,$telefono,$contacto,$rubro,$servicio,$tipoVisita,$empresa);
				}
			}
			else
			{
				//order del arreglo $mas requerido: rut,dv,pasaporte,nombre,direccion,telefono,contacto,rubro,servicio,tipoVisita,empresa,idCliente
				$filtro = " visita,detalleVisita WHERE ";
				$arrData = array();
				if($mas[0]!=null)
				{
					$filtro.= $and? " AND rut=?":" rut=?";
					$and = true;
					$arrData[] = $mas[0];
				}
				if($mas[1]!=null)
				{
					$filtro.= $and? " AND dv=?":" dv=?";
					$and = true;
					$arrData[] = $mas[1];
				}
				if($mas[2]!=null)
				{
					$filtro.= $and? " AND pasaporte=?":" pasaporte=?";
					$and = true;
					$arrData[] = $mas[2];
				}
				if($mas[3]!=null)
				{
					$filtro.= $and? " AND nombre=?":" nombre=?";
					$and = true;
					$arrData[] = $mas[3];
				}
				if($mas[4]!=null)
				{
					$filtro.= $and? " AND apellido=?":" apellido=?";
					$and = true;
					$arrData[] = $mas[4];
				}
				if($mas[5]!=null)
				{
					$filtro.= $and? " AND direccion = ?":" direccion = ?";
					$and = true;
					$arrData[] = $mas[5];
				}
		
				if($mas[6]!=null)
				{
					$filtro.= $and? " AND telefono = ?":" telefono = ?";
					$and = true;
					$arrData[] = $mas[6];
				}
			
				if($mas[7]!=null)
				{
					$filtro.= $and? " AND contacto = ?":" contacto = ?";
					$and = true;
					$arrData[] = $mas[7];
				}
			
				if($mas[8]!=null)
				{
					$filtro.= $and? " AND rubro = ?":" rubro = ?";
					$and = true;
					$arrData[] = $mas[8];
				}
			
				if($mas[9]!=null)
				{//servicio
					$filtro.= $and? " AND servicio = ? AND tipoVisita = ? ":" servicio = ?";
					$and = true;
					$arrData[] = $mas[9];
				}
			
				if($mas[11]!=null)
				{//empresa
					$filtro.= $and? " AND empresa = ?":" empresa = ?";
					$and = true;
					$arrData[] = $mas[11];
				}
				if($mas[12]!=null)
				{
					$filtro.= $and? " AND detalleVisita.idCliente = ?":" detalleVisita.idCliente = ?";
					$and = true;
					$arrData[] = $mas[12];
				}
				$filtro.=" AND detalleVisita.idVisita=visita.idVisita";
			
				/*print_r($filtro);
				echo "<br>";
				print_r($mas);
				echo "<br>";
				print_r($arrData);
				echo "<br>";
				echo "<br>";
				die();*/
			
				$resulset = $sql->devDatos($sentencia.$filtro,$arrData);
				$resulset ->bind_result($idVisita,$rut,$dv,$pasaporte,$nombre,$apellido,$direccion,$telefono,$contacto,$rubro,$servicio,$tipoVisita,$empresa);
			
				while($resulset->fetch())
				{
					$visita[] = new visita($idVisita,$rut,$dv,$pasaporte,$nombre,$apellido,$direccion,$telefono,$contacto,$rubro,$servicio,$tipoVisita,$empresa);
				}
				if(count($visita)==1)
				{
					$visita = $visita[0];
				}
				else 
				{
					if($estado!=null && $estado!=1) 
					{
						$visita = controlVisita::getlastVisitaAssCliente($mas[12]); //mas[12], es el idCliente 
					}
					//
				}
			
			}
		}	
			
			return $visita;
		
	}
	public function countVisitaCliente($idCliente,$tipoVisita=null)
	{
		$sql = conexionMySQLi::getInstance();//from visita,detalleVisita Where detalleVisita.idVisita = visita.idVisita AND detalleVisita.idCliente = 42
		$data = null;
		if($tipoVisita==null)
		{
		  $sentencia = "SELECT COUNT(visita.idVisita) AS contar From visita,detalleVisita Where detalleVisita.idVisita = visita.idVisita AND detalleVisita.idCliente =".$idCliente;
		}
		else 
		{
			//echo $idCliente."_".$tipoVisita;
			
			
		  //$sentencia = "SELECT COUNT(visita.idVisita) AS contar From visita,detalleVisita Where detalleVisita.idVisita = visita.idVisita AND detalleVisita.idCliente =".$idCliente."AND visita.tipoVisita = normal";
		  $sentencia = "select count(visita.idVisita) as contar from detalleVisita,visita where detalleVisita.idVisita=visita.idVisita AND detalleVisita.idCliente=".$idCliente." AND visita.tipoVisita='$tipoVisita'";
		  //die($sentencia);
		}
		$resulset = $sql->devDatos($sentencia);
				
		while($value = $resulset->fetch_assoc())
		{
			$data = $value["contar"];
		}
		return $data;
		
	}
	public function getVisitaWithId($id)
	{
		$sql = conexionMySQLi::getInstance();
		$visita = null;
		$sentencia = "SELECT idVisita,rut,dv,pasaporte,nombre,apellido,direccion,telefono,contacto,rubro,servicio,tipoVisita,empresa FROM visita WHERE idVisita = ?";
		$resulset = $sql->devDatos($sentencia,array($id));
		$resulset ->bind_result($idVisita,$rut,$dv,$pasaporte,$nombre,$apellido,$direccion,$telefono,$contacto,$rubro,$servicio,$tipoVisita,$empresa);
		
		if($resulset->fetch())
		{
			$visita = new visita($idVisita,$rut,$dv,$pasaporte,$nombre,$apellido,$direccion,$telefono,$contacto,$rubro,$servicio,$tipoVisita,$empresa);
		}
		
		return $visita;
		
	}
	
	public function getlastVisitaAssCliente($idCliente)
	{
		$sql = conexionMySQLi::getInstance();
		$visita = null;
		if($idCliente!=null)
		{
			$sentencia = " SELECT visita.idVisita,visita.rut,visita.dv,visita.pasaporte,visita.nombre,visita.apellido,visita.direccion,visita.telefono,visita.rubro,visita.contacto,visita.servicio,visita.tipoVisita,visita.empresa FROM cliente,detalleVisita,visita WHERE cliente.idCliente = ? and cliente.idCliente = detalleVisita.idCliente  group by visita.idVisita desc LIMIT 0,1";
			$resulset = $sql->devDatos($sentencia,array($idCliente));
			$resulset ->bind_result($idVisita,$rut,$dv,$pasaporte,$nombre,$apellido,$direccion,$telefono,$contacto,$rubro,$servicio,$tipoVisita,$empresa);
			if($resulset->fetch())
			{
				$visita = new visita($idVisita,$rut,$dv,$pasaporte,$nombre,$apellido,$direccion,$telefono,$contacto,$rubro,$servicio,$tipoVisita,$empresa);
			}
			
		}
		return $visita;
		
	}
	
	public function getVisita($idCliente=null,$tipoVisita=null)
	{ //select * from cliente,visita,detalleVisita where cliente.idCliente = 42 and cliente.idCliente = detalleVisita.idCliente and detalleVisita.idVisita = visita.idVisita;
		
		$sql = conexionMySQLi::getInstance();
		$visita = array();
		$bandera = true;
		$sentencia = "SELECT visita.idVisita,visita.rut,visita.dv,visita.pasaporte,visita.nombre,visita.apellido,visita.direccion,visita.telefono,visita.rubro,visita.contacto,visita.servicio,visita.tipoVisita,visita.empresa ";
		//echo $idCliente."-".$tipoVisita;
		//echo $tipoVisita!=null? "hola" : "adios";
		if($idCliente!=null && $tipoVisita==null)
		{
			
			$query = "From cliente,visita,detalleVisita WHERE cliente.idCliente = ? and cliente.idCliente = detalleVisita.idCliente and detalleVisita.idVisita = visita.idVisita and visita.tipoVisita= 'normal' ORDER BY visita.nombre asc";
			$sentencia = $sentencia.$query;
			//print_r($sentencia);
			//die();
			$resulset = $sql->devDatos($sentencia,array($idCliente));
			$resulset ->bind_result($idVisita,$rut,$dv,$pasaporte,$nombre,$apellido,$direccion,$telefono,$rubro,$contacto,$servicio,$tipoVisita,$empresa);
			while($resulset->fetch())
			{
				//$visita[] = new visita($value["idVisita"],$value["rut"],$value["dv"],$value["pasaporte"],$value["nombre"],$value["direccion"],$value["telefono"],$value["contacto"],$value["rubro"],$value["servicio"],$value["tipoVisita"],$value["empresa"]);
				$visita[] = new visita($idVisita,$rut,$dv,$pasaporte,$nombre,$apellido,$direccion,$telefono,$contacto,$rubro,$servicio,$tipoVisita,$empresa);
			}
			$bandera = false;
		}
		
		if($idCliente!=null && $tipoVisita!=null && $bandera)
		{
			$query = "From cliente,visita,detalleVisita WHERE cliente.idCliente = ? and visita.tipoVisita = ? and cliente.idCliente = detalleVisita.idCliente and detalleVisita.idVisita = visita.idVisita ORDER BY visita.nombre asc";
			$sentencia = $sentencia.$query;
			//print_r("hola");
			//die();
			$resulset = $sql->devDatos($sentencia,array($idCliente,$tipoVisita));
			$resulset ->bind_result($idVisita,$rut,$dv,$pasaporte,$nombre,$apellido,$direccion,$telefono,$rubro,$contacto,$servicio,$tipoVisita,$empresa);
			while($resulset->fetch())
			{
				//$visita[] = new visita($value["idVisita"],$value["rut"],$value["dv"],$value["pasaporte"],$value["nombre"],$value["direccion"],$value["telefono"],$value["contacto"],$value["rubro"],$value["servicio"],$value["tipoVisita"],$value["empresa"]);
				$visita[] = new visita($idVisita,$rut,$dv,$pasaporte,$nombre,$apellido,$direccion,$telefono,$contacto,$rubro,$servicio,$tipoVisita,$empresa);
			}
			
		}
		
		if($idCliente==null && $tipoVisita==null)
		{
			$query2 = "FROM visita ORDER BY nombre ASC";
			$sentencia = $sentencia.$query2;
			//print_r($sentencia);
			//die();
			$resulset = $sql->devDatos($sentencia);
			while($value = $resulset->fetch_assoc())
			{
				$visita[] = new visita($value["idVisita"],$value["rut"],$value["dv"],$value["pasaporte"],$value["nombre"],$value["apellido"],$value["direccion"],$value["telefono"],$value["contacto"],$value["rubro"],$value["servicio"],$value["tipoVisita"],$value["empresa"]);
			}
		}
		//$resulset ->bind_result($idVisita,$rut,$dv,$pasaporte,$nombre,$direccion,$telefono,$contacto,$rubro,$servicio,$tipoVisita,$empresa);
		
		
		return $visita;
	}
	
	public function editaVisita($dataEdit)
	{
		$sql = conexionMySQLi::getInstance();
		$sentencia = "UPDATE visita SET rut = ?,dv = ?,pasaporte = ?,nombre =?,apellido = ?, contacto = ?,telefono= ?,empresa = ?,rubro = ?,direccion = ? WHERE idVisita = ?";
		$sql-> ejecutarSentencia($sentencia,$dataEdit);
		return 1;
	}
	public function AllDatosVisita($idVisita)
	{
		$sql=conexionMySQLi::getInstance();
		$visita = null;
		$consulta = "SELECT visita.idVisita,visita.rut,visita.dv,visita.pasaporte,visita.nombre,visita.apellido,visita.direccion,visita.telefono,visita.contacto,visita.rubro,visita.servicio,visita.tipoVisita,visita.empresa FROM visita WHERE visita.idVisita=?";
		$result= $sql->devDatos($consulta,array($idVisita));
			$result->bind_result($idVisita,$rut,$dv,$pasaporte,$nombre,$apellido,$direccion,$telefono,$contacto,$rubro,$servicio,$tipoVisita,$empresa);
		
			if  ($result->fetch())
			{
	
				$visita[] =new visita($idVisita,$rut,$dv,$pasaporte,$nombre,$apellido,$direccion,$telefono,$contacto,$rubro,$servicio,$tipoVisita,$empresa);
	
			}
			return $visita;
	}
	public function busquedaGlobalDeVisitas($busqueda,$idV=null) //order de parametros:  rut,dv,pasaporte,nombre,apellido,direccion,telefono,contacto,rubro,servicios,empresa,idCliente
	{
	
		$sql = conexionMySQLi::getInstance();
	
		$visita = null;
		$and = false;
		$sentencia = "SELECT visita.idVisita,visita.rut,visita.dv,visita.pasaporte,visita.nombre,visita.apellido,visita.direccion,visita.telefono,visita.contacto,visita.rubro,visita.servicio,visita.tipoVisita,visita.empresa FROM ";
		$filtro = " visita,detalleVisita WHERE ";
		$arrData = array();
	
		if($busqueda[0]!=null)
		{
			$filtro.= $and? " AND rut=?":" rut=?";
			$and = true;
			$arrData[] = $busqueda[0];
		}
		if($busqueda[1]!=null)
		{
			$filtro.= $and? " AND dv=?":" dv=?";
			$and = true;
			$arrData[] = $busqueda[1];
		}
		if($busqueda[2]!=null)
		{
			$filtro.= $and? " AND pasaporte=?":" pasaporte=?";
			$and = true;
			$arrData[] = $busqueda[2];
		}
		if($busqueda[3]!=null)
		{
			$filtro.= $and? " AND nombre=?":" nombre=?";
			$and = true;
			$arrData[] = $busqueda[3];
		}
		if($busqueda[4]!=null)
		{
			$filtro.= $and? " AND apellido=?":" apellido=?";
			$and = true;
			$arrData[] = $busqueda[4];
		}
		if($busqueda[5]!=null)
		{
			$filtro.= $and? " AND direccion = ?":" direccion = ?";
			$and = true;
			$arrData[] = $busqueda[5];
		}
	
		if($busqueda[6]!=null)
		{
			$filtro.= $and? " AND telefono = ?":" telefono = ?";
			$and = true;
			$arrData[] = $busqueda[6];
		}
			
		if($busqueda[7]!=null)
		{
			$filtro.= $and? " AND contacto = ?":" contacto = ?";
			$and = true;
			$arrData[] = $busqueda[7];
		}
			
		if($busqueda[8]!=null)
		{
			$filtro.= $and? " AND rubro = ?":" rubro = ?";
			$and = true;
			$arrData[] = $busqueda[8];
		}
			
		if($busqueda[9]!=null)
		{//servicio
			$filtro.= $and? " AND servicio = ? AND tipoVisita = ? ":" servicio = ?";
			$and = true;
			$arrData[] = $busqueda[9];
		}
			
		if($busqueda[11]!=null)
		{//empresa
			$filtro.= $and? " AND empresa = ?":" empresa = ?";
			$and = true;
			$arrData[] = $busqueda[11];
		}
		if($busqueda[12]!=null)
		{
			$filtro.= $and? " AND detalleVisita.idCliente = ?":" detalleVisita.idCliente = ?";
			$and = true;
			$arrData[] = $busqueda[12];
		}
		$filtro.=" AND detalleVisita.idVisita=visita.idVisita";
		/*print_r($filtro);
		 echo "<br>";
		print_r($mas);
		echo "<br>";
		print_r($arrData);
		echo "<br>";
		echo "<br>";
		die();*/
			
		$resulset = $sql->devDatos($sentencia.$filtro,$arrData);
		$resulset ->bind_result($idVisita,$rut,$dv,$pasaporte,$nombre,$apellido,$direccion,$telefono,$contacto,$rubro,$servicio,$tipoVisita,$empresa);
			
		while($resulset->fetch())
		{
			$visita[] = new visita($idVisita,$rut,$dv,$pasaporte,$nombre,$apellido,$direccion,$telefono,$contacto,$rubro,$servicio,$tipoVisita,$empresa);
		}
		/*
			if(count($visita)==1)
			{
		$visita = $visita[0];
		}
		else
		{
		if($estado!=null && $estado!=1)
		{
		$visita = controlVisita::getlastVisitaAssCliente($busqueda[12]); //mas[12], es el idCliente
		}
		//
		}*/
		return $visita;
	
	}	
/*
################################ funciones nico ###########################3
*/
function datosVisita($idVisita)
	{
		$sql=conexionMySQLi::getInstance(); //falta agregar el nuevo campo apellido!!!
		$arr= array();
		$consulta="SELECT visita.nombre,visita.rut,visita.dv,visita.pasaporte from visita,reserva	where visita.idVisita = reserva.idVisita and reserva.idVisita = ?";
		$result= $sql->devDatos($consulta,array($idVisita));
		$result->bind_result($nombre,$rut,$dv,$pasaporte);
		if  ($result->fetch())
		{
	
			$arr[] =array($nombre,$rut,$dv,$pasaporte);
	
		}
		return $arr;
	
	}

	public function existeRut($idReserva)
	{
		$sql=conexionMySQLi::getInstance();
		$arr=null;
		$consulta="SELECT visita.idvisita,visita.rut,visita.dv
		FROM visita,reserva
		WHERE visita.idVisita = reserva.idVisita
		AND reserva.idReserva = ?";
		$result= $sql->devDatos($consulta,array($idReserva));
		$result->bind_result($idvis,$rut,$dv);
		if($result->fetch())$arr=new visita($idvis,$rut,$dv,null,null,null,null,null,null,null,null,null,null);
		return $arr;
	}
	
	public function actualizaRut($idVisita,$rut,$dv)
	{
		$sql = conexionMySQLi::getInstance();
		$sentencia = "UPDATE visita SET rut = '".$rut."',dv = '".$dv."' WHERE idVisita = ?";
		$retorno = $sql-> ejecutarSentencia($sentencia,array($idVisita));
		if ($retorno!=0) return "1";
		else return "0";
	
	}	
	
	public function getVisitaByIdReserva($id)
	{
		$sql = conexionMySQLi::getInstance();
		$visita = null;
		$sentencia = "SELECT visita.idVisita,rut,dv,pasaporte,nombre,apellido,direccion,telefono,contacto,rubro,servicio,
		tipoVisita,empresa
		FROM visita,reserva
		WHERE reserva.idVisita = visita.idVisita
		AND reserva.idReserva = ?";
		$resulset = $sql->devDatos($sentencia,array($id));
		$resulset ->bind_result($idVisita,$rut,$dv,$pasaporte,$nombre,$apellido,$direccion,$telefono,$contacto,$rubro,$servicio,$tipoVisita,$empresa);
	
		if($resulset->fetch())
		{
			$visita = new visita($idVisita,$rut,$dv,$pasaporte,$nombre,$apellido,$direccion,$telefono,$contacto,$rubro,$servicio,$tipoVisita,$empresa);
		}
	
		return $visita;
	
	}
	public function cambiaEstadoEsperaVisita($idVisita,$estado)
	{
		$sql = conexionMySQLi::getInstance();
		$sentencia = "UPDATE visita SET ";
		switch ($estado)
		{
			case "esp":
				$sentencia.=" enEspera = 1 ";
				break;
					
			case "ocu":
				$sentencia.=" enEspera=0 ";
				break;
					
		}
	
		$sentencia.=" WHERE idVisita = ?";
		$retorno = $sql-> ejecutarSentencia($sentencia,array($idVisita));
		if ($retorno!=0) return "1";
		else return "0";
	
	}
	
	public function getVisitasEspera($idCliente,$opc=null)
	{
		$sql = conexionMySQLi::getInstance();
		$visita = null;
		if($opc==null)
			$sentencia = "SELECT visita.idVisita,rut,dv,pasaporte,nombre,apellido";
		else
			$sentencia="SELECT count(visita.idVisita)";
	
		$sentencia.=" FROM visita,cliente,detalleVisita
		WHERE  visita.idVisita = detalleVisita.`idVisita`
		AND cliente.idCliente = detalleVisita.idCliente
		AND cliente.idCliente =  ?
		AND visita.enEspera = 1
		AND visita.idVisitaEnEspera <> 0";
		$resulset = $sql->devDatos($sentencia,array($idCliente));
		if($opc==null)
		{
			$resulset ->bind_result($idVisita,$rut,$dv,$pasaporte,$nombre,$apellido);
				
			while($resulset->fetch())
			{
				$visita[] = new visita($idVisita,$rut,$dv,$pasaporte,$nombre,$apellido,null,null,null,null,null,null,null);
	
			}
				
			return $visita;
		}
		else
		{
			$resulset->bind_result($contador);
			if ($resulset->fetch()) return $contador;
		}
	}
	
	public function eliminaVisitaEspera($idVisita,$idCliente)
	{
		$sql = conexionMySQLi::getInstance();
		$sentencia = "DELETE FROM  detalleVisita WHERE idVisita = ? AND idCliente = ? ";
		$retorno = $sql-> ejecutarSentencia($sentencia,array($idVisita,$idCliente));
		if ($retorno!=0) return "1";
		else return "0";
	
	}
	
	public function getIdVisitasEnEspera($idVisita=null)
	{
		$sql = conexionMySQLi::getInstance();
		$query = "SELECT idVisitaEnEspera FROM visita WHERE idVisita = ? ";
		$result = $sql->devDatos($query,$idVisita);
		$result->bind_result($idVisEsp);
		if ($result->fetch())
		{
			$retorno = $idVisEsp;
		}
		
		return $retorno;
	
	}
}
?>
