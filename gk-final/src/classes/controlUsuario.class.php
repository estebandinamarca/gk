<?php

//if(!defined('PATH_SOURCE_CORE')) die ('Directorio de fuentes del nucleo no esta definida, por favor contacte al administrador o implementador.');
require_once("src/core/conexionMySQLi.class.php");
require_once("src/core/conf.class.php");
require_once ('src/classes/usuario.php');


	class controlUsuario
	{
		public function preparaUsuario($post)
		{
			/*RETORNA 1 SI REALIZO LA INSERCION.
			 *RETORNA 0 SI LA INSERCION NO PUDO REALIZARSE porque habian valores nulos
			 *RETORNA -4 SI EL USUARIO YA ESTA REGISTRADO EN LA BD			  
			*/
			if( $post["userName"]!=null && $post["userFullName"] != null && $post["mail"] != null && $post["password"] != null && $post["password2"] != null && $post["level"] > 0 )
			{
				if (controlUsuario::getIdUsuario($post["userFullName"]) == null ) // PREGUNTA SI EL NOMBRE DE USUARIO NO ESTA EN LA BD 
				{	
					if($post["password"] == $post["password2"] ){
						$data =array($post["userName"], $post["userFullName"], $post["mail"],md5($post["password"]), $post["level"]);
						//print_r($post); die();
						controlUsuario::insertUsuario($data); // INSERTA EL USUARIO EN LA BD.
						$id = controlUsuario::getIdUsuario($post["userFullName"]);
						if($id != null){
							switch($post["level"]){
								case 1:
									$privileges = array(
													"verPropiedades"=>false,
													"Gestion"=>false,
													"prop_download"=>false,
													"buscar_download"=>false,
													"prop_deleteFiles"=>false,
													"buscar_deleteFiles"=>false,
													"prop_load"=>false,
													"buscar_load"=>false,
													"buscarPropiedad"=>true,
													"Estadistica"=>false,
													"rolesReport"=>true,
													"prop_print"=>false,
													"buscar_print"=>false,
													"Est_print"=>false,
													"prop_exportar_excel"=>false,
													"Est_exportar_excel"=>false,
													"prop_exportar_pdf"=>false,
													"Est_exportar_pdf"=>false
									);
								break;
								case 2:
									$privileges = array(
													"verPropiedades"=>true,
													"Gestion"=>false,
													"prop_download"=>true,
													"buscar_download"=>true,
													"prop_deleteFiles"=>false,
													"buscar_deleteFiles"=>false,
													"prop_load"=>false,
													"buscar_load"=>false,
													"buscarPropiedad"=>true,
													"Estadistica"=>true,
													"rolesReport"=>true,
													"prop_print"=>true,
													"buscar_print"=>true,
													"Est_print"=>true,
													"prop_exportar_excel"=>true,
													"Est_exportar_excel"=>true,
													"prop_exportar_pdf"=>true,
													"Est_exportar_pdf"=>true
						
									);
								break;
								case 3:
									$privileges = array(
													"verPropiedades"=>true,
													"Gestion"=>true,
													"prop_download"=>true,
													"buscar_download"=>true,
													"prop_deleteFiles"=>true,
													"buscar_deleteFiles"=>true,
													"prop_load"=>true,
													"buscar_load"=>true,
													"buscarPropiedad"=>true,
													"Estadistica"=>true,
													"rolesReport"=>true,
													"prop_print"=>true,
													"buscar_print"=>true,
													"Est_print"=>true,
													"prop_exportar_excel"=>true,
													"Est_exportar_excel"=>true,
													"prop_exportar_pdf"=>true,
													"Est_exportar_pdf"=>true
									);
								break;
								default:
									$privileges = array(
													"verPropiedades"=>false,
													"Gestion"=>false,
													"prop_download"=>false,
													"buscar_download"=>false,
													"prop_deleteFiles"=>false,
													"buscar_deleteFiles"=>false,
													"prop_load"=>false,
													"buscar_load"=>false,
													"buscarPropiedad"=>false,
													"Estadistica"=>false,
													"rolesReport"=>false,
													"prop_print"=>false,
													"buscar_print"=>false,
													"Est_print"=>false,
													"prop_exportar_excel"=>false,
													"Est_exportar_excel"=>false,
													"prop_exportar_pdf"=>false,
													"Est_exportar_pdf"=>false
						
									);

								break;
							}
							controlUsuario::setPermisos($id, $privileges);
						}
						return 1;
					}else {
						
						return -3;
					}										
				}
				else{
					return -4;
				}				
			}
			else
			{
				return 0;
			}
		}		
		public function verUsuarios()
		{
			return controlUsuario::listUsuarios();
		}
		
		public function deleteUser(){
			controlUsuario::deleteUser_(func_get_arg(0));
		}		
		
		public function getUser($id){
			$usuario = null;
			$sql = conexionMySQLi::getInstance();
			$usuario = array(); 
			$sentencia = "SELECT idUser, userName, userFullName, mail, password, level FROM usuarios WHERE idUser =".$id."";
			$resultset = $sql->devDatos($sentencia);
			if($value = $resultset->fetch_assoc()){
			  	$usuario = new usuario($value["idUser"], $value["userName"], $value["userFullName"], $value["mail"], $value["password"], $value["level"]);
			}
			
			if($usuario != null){
				$sentencia = "SELECT idUser,modulo,credencial FROM perfilUsuario WHERE idUser = ".$usuario->getIdUsuario();
				
				$result = $sql->devDatos($sentencia);
				$privileges = array();
				while($row = $result->fetch_assoc()){
					$privileges[$row["modulo"]] = $row["credencial"];
				}
				
				$usuario->setPermisos($privileges);
			}

			return $usuario;
		}		

		public function prepareEditUser($id,$POST){
			if ($POST['userName'] != null && $POST['userFullName'] != null && $POST['mail'] !=null && ($POST['password1'] == $POST['password2']) && $POST['cboNuevoPrivilegio'] != 0){
				$user = controlUsuario::getUser($id);
				controlUsuario::edituser($id,$POST);		
						
				if($user->getPrivilegio() != $POST['cboNuevoPrivilegio']){

						switch($POST['cboNuevoPrivilegio']){
								case 1:
									$privileges = array(
													"verPropiedades"=>false,
													"Gestion"=>false,
													"prop_download"=>false,
													"buscar_download"=>false,
													"prop_deleteFiles"=>false,
													"buscar_deleteFiles"=>false,
													"prop_load"=>false,
													"buscar_load"=>false,
													"buscarPropiedad"=>true,
													"Estadistica"=>false,
													"rolesReport"=>true,
													"prop_print"=>false,
													"buscar_print"=>false,
													"Est_print"=>false,
													"prop_exportar_excel"=>false,
													"Est_exportar_excel"=>false,
													"prop_exportar_pdf"=>false,
													"Est_exportar_pdf"=>false
						
									);
								break;
								case 2:
									$privileges = array(
													"verPropiedades"=>true,
													"Gestion"=>false,
													"prop_download"=>true,
													"buscar_download"=>true,
													"prop_deleteFiles"=>false,
													"buscar_deleteFiles"=>false,
													"prop_load"=>false,
													"buscar_load"=>false,
													"buscarPropiedad"=>true,
													"Estadistica"=>true,
													"rolesReport"=>true,
													"prop_print"=>true,
													"buscar_print"=>true,
													"Est_print"=>true,
													"prop_exportar_excel"=>true,
													"Est_exportar_excel"=>true,
													"prop_exportar_pdf"=>true,
													"Est_exportar_pdf"=>true
						
									);
								break;
								case 3:
									$privileges = array(
													"verPropiedades"=>true,
													"Gestion"=>true,
													"prop_download"=>true,
													"buscar_download"=>true,
													"prop_deleteFiles"=>true,
													"buscar_deleteFiles"=>true,
													"prop_load"=>true,
													"buscar_load"=>true,
													"buscarPropiedad"=>true,
													"Estadistica"=>true,
													"rolesReport"=>true,
													"prop_print"=>true,
													"buscar_print"=>true,
													"Est_print"=>true,
													"prop_exportar_excel"=>true,
													"Est_exportar_excel"=>true,
													"prop_exportar_pdf"=>true,
													"Est_exportar_pdf"=>true
									);
								break;
								default:
									$privileges = array(
													"verPropiedades"=>false,
													"Gestion"=>false,
													"prop_download"=>false,
													"buscar_download"=>false,
													"prop_deleteFiles"=>false,
													"buscar_deleteFiles"=>false,
													"prop_load"=>false,
													"buscar_load"=>false,
													"buscarPropiedad"=>false,
													"Estadistica"=>false,
													"rolesReport"=>false,
													"prop_print"=>false,
													"buscar_print"=>false,
													"Est_print"=>false,
													"prop_exportar_excel"=>false,
													"Est_exportar_excel"=>false,
													"prop_exportar_pdf"=>false,
													"Est_exportar_pdf"=>false
						
									);

								break;
							}
						controlUsuario::setPermisos($id, $privileges);
				}
			}
		}
		
		public function prepareCambiarPassword($user,$pass,$con){
			//echo $pass, $user, $con; die();			
			$usuario = controlUsuario::getLoginfromUser($user,$pass);
			//print_r($usuario); die();
			if( $usuario != null){ 
				$id = $usuario->getIdUsuario();
				//echo $id; die();
				//$confinal = md5($con);
										
				controlUsuario::CambiarPassword($id,$con);
				return 1;				
			}
			return null; 
		}
		
		public function CambiarPassword($pass,$id){
			//echo $id, $pass;		
			$sql= conexionMySQLi::getInstance();
			$sentencia = "UPDATE usuarios SET password = ? WHERE idUser = ?";
			//print_r($sentencia);
			$data = array($id,$pass);
			//print_r($data); die();			
			$sql->ejecutarSentencia($sentencia,$data);			
		}
		
		public function comparaLogin($user,$pass){
			$usuario = new usuario();
			//print_r($user)
			
			if($pass != null && $user != null){				
				return controlUsuario::getLoginfromUser($user,$pass);				 
			}else {
				return null;
			}						
		}

		########################################################## INSERCION DE USUARIO #######################################################
		public function getuserFullName($idUser)
		{
			
			$sql = conexionMySQLi::getInstance();
			$sentencia = "SELECT userFullName FROM usuarios WHERE idUser = ? ";
			$resulset = $sql->devDatos($sentencia,$idUser);
			$resulset-> bind_result($nombre);

			if($resulset->fetch())
			{
				return $nombre; //SI ENCUENTRA EN NOMBRE DE USUARIO, LO RETORNA.
					
			}
			return -1;	// retorna -1 si el NOMBRE DE USUARIO, no se encuentra en la BD
		}	
		public function getIdUsuario($userFullName)
		{
			
			$sql = conexionMySQLi::getInstance();
			$sentencia = "SELECT idUser FROM usuarios WHERE userFullName = ? ";
			$resulset = $sql->devDatos($sentencia,$userFullName);
			$resulset-> bind_result($id);

			if($resulset->fetch())
			{
				return $id; //SI ENCUENTRA EN NOMBRE DE USUARIO, LO RETORNA.
					
			}
			return null;	// retorna -1 si el NOMBRE DE USUARIO, no se encuentra en la BD
		}

		public function getIdUsername($userName)
		{
				
			$sql = conexionMySQLi::getInstance();
			$sentencia = "SELECT idUser FROM usuarios WHERE userName = ? ";
			$resulset = $sql->devDatos($sentencia,$userName);
			$resulset-> bind_result($id);
		
			if($resulset->fetch())
			{
				return $id; //SI ENCUENTRA EN NOMBRE DE USUARIO, LO RETORNA.
					
			}
			return null;	// retorna -1 si el NOMBRE DE USUARIO, no se encuentra en la BD
		}
		
		public function listadoUsuariosCliente($idCliente,$idU)
		{
			$sql = conexionMySQLi::getInstance();
			$usuario = null;
			$sentencia = "SELECT idUser,idCliente,userName,userFullName,mail,level FROM usuarios WHERE idCliente = ? AND idUser!=?";
			$resulset = $sql->devDatos($sentencia,array($idCliente,$idU));
				
			$resulset->bind_result($idUser,$idCliente,$userName,$userFullName,$mail,$level);
			while($resulset->fetch())
			{
				$usuario[] = new usuario($idUser,$idCliente,$userName,$userFullName,$mail,$level);
			}
			return $usuario;
				
		}
	
		public function insertUsuario($data)
		{
			$sql = conexionMySQLi::getInstance();
			$sentencia = "INSERT INTO usuarios (idCliente,userName, userFullName,password, mail, level,company)  VALUES (?,?,?,?,?,?,?)";
			if(controlUsuario::getIdUsername($data[1])==null)$resp=$sql-> ejecutarSentencia($sentencia,$data);
			else return "-2";
			if ($resp!="0")return "1";
			else return "2";
			
		}
		
		//###############################################################################################3
		// ########################## NICO #############################################################
	
		public function listUsuarios($idCliente=null,$idUsuario=null)
		{
			$sql = conexionMySQLi::getInstance();
			$sentencia = "SELECT * FROM usuarios WHERE userFullName != 'admin' AND userFullName != 'developer' AND userName <> 'null' "; // el filtro por developer no va es el nivel de privilegios el que manda...
			if($idCliente!=null) $sentencia=$sentencia." and idCliente = '".$idCliente."'";
			if($idUsuario!=null) $sentencia=$sentencia." and idUser = '".$idUsuario."'";
			$sentencia=$sentencia." order by company ASC,userFullName ASC";
			$result = $sql-> devDatos($sentencia);
			$response = array();
			while ($fila = $result->fetch_assoc())
			{
				$response[] = $fila;
			}
			return $response;
			
		}

		public function borrarUser($id)
		{
			$sql = conexionMySQLi::getInstance();
			$sentencia = "DELETE FROM usuarios WHERE idUser = '". $id ."'";
			return $result = $sql-> devDatos($sentencia);	
		}
		
		public function borrarUserG($nick) // Codigo Generado por Gonzalo
		{
			$sql = conexionMySQLi::getInstance();
			$sentencia = "DELETE FROM usuarios WHERE userName = '". $nick ."'";
			return $result = $sql-> devDatos($sentencia);
		}
		
		
	
		/********************************
		public function editUser($id,$elems)
		{
			$sql = conexionMySQLi::getInstance();
			
			if($elems["password1"]!=null){
				$sentencia = "UPDATE usuarios SET userName = ?, userFullName = ?, mail = ?, password = ?, level = ? WHERE idUser = ?";
				$data = array($elems["userName"],$elems["userFullName"],$elems["mail"], md5($elems["password1"]), $elems["cboNuevoPrivilegio"], $id);
			}else{
				$sentencia = "UPDATE usuarios SET userName = ?, userFullName = ?, mail = ?, level = ? WHERE idUser = ?";
				$data = array($elems["userName"],$elems["userFullName"],$elems["mail"], $elems["cboNuevoPrivilegio"], $id);
			}		
			return $sql-> ejecutarSentencia($sentencia,$data);	
		}
		*************/
		
		public function editUser($id,$elems)
		{
			$sql = conexionMySQLi::getInstance();
			//$elems=$elem[0];
			if($elems[2]!=null&&$elems[4]!=null){
				$sentencia = "UPDATE usuarios SET userName = ?, userFullName = ?, password = ?, mail = ?, level = ? WHERE idUser = ?";
				$data = array($elems[0],$elems[1],$elems[2], $elems[3], $elems[4], $id);
			}
			if($elems[2]!=null&&$elems[4]==null){
				$sentencia = "UPDATE usuarios SET userName = ?, userFullName = ?, password = ?, mail = ?  WHERE idUser = ?";
				$data = array($elems[0],$elems[1],$elems[2], $elems[3], $id);
			}
			if($elems[2]==null&&$elems[4]!=null){
				$sentencia = "UPDATE usuarios SET userName = ?, userFullName = ?, mail = ?,level = ? WHERE idUser = ?";
				$data = array($elems[0],$elems[1],$elems[3],$elems[4],$id);
			}
			if($elems[2]==null&&$elems[4]==null){
				$sentencia = "UPDATE usuarios SET userName = ?, userFullName = ?, mail = ? WHERE idUser = ?";
				$data = array($elems[0],$elems[1],$elems[3],$id);
			}
				
			
			return $sql-> ejecutarSentencia($sentencia,$data);
		}
		// #################################GONZALO#################################
		public function getUserG($idCliente=null,$userN=null,$userFullN=null,$correo=null,$nivel=null,$compan=null)
		{
			$sql = conexionMySQLi::getInstance();
			$sentencia = "SELECT idUser,idCliente,userName,userFullName,mail,password,level,company FROM usuarios";
			$usuario = null;
			$where = " WHERE ";
			$filtro = null;
			$and = false;
			$arrData = array();
			
			if($idCliente!=null)
			{
				$filtro.= $and?"AND idCliente = ?":"idCliente= ? ";
				$arrData[] = $idCliente;
				$and = true;
			}
			if($userN!=null)
			{
				$filtro.= $and?"AND userName = ?":"userName= ? ";
				$arrData[] = $userN;
				$and = true;
			}
			if($userFullN!=null)
			{
				$filtro.= $and?"AND userFullName = ?":"userFullName= ? ";
				$arrData[] = $userFullN;
				$and = true;
			}
			if($correo!=null)
			{
				$filtro.= $and?"AND mail = ?":"mail= ? ";
				$arrData[] = $correo;
				$and = true;
			}
			if($nivel!=null)
			{
				$filtro.= $and?"AND level = ?":"level= ? ";
				$arrData[] = $nivel;
				$and = true;
			}
			if($compan!=null)
			{
				$filtro.= $and?"AND company = ?":"company= ? ";
				$arrData[] = $compan;
				$and = true;
			}
			
			if($and)
			{
				$resulset = $sql->devDatos($sentencia.$where.$filtro,$arrData);
				$resulset ->bind_result($idUser,$idCliente,$userName,$userFullName,$mail,$password,$level,$company);
				while($resulset->fetch())
				{
					$usuario[] = new usuario($idUser,$idCliente,$userName,$userFullName,$mail,$password,$level,$company);
				}
			}
			else
			{
				$resulset = $sql->devDatos($sentencia);
				while($value = $resulset->fetch_assoc())
				{
					$usuario[] = new usuario($value["idUser"],$value["idCliente"],$value["userName"],$value["userFullName"],$value["mail"],$value["password"],$value["level"],$value["company"]);
				}	
			}
			return $usuario;
		}
		
		public function CambiaContraseOdata($userName,$userFullName,$pasActual,$pasNueva,$passNuevaConf,$correo,$level,$bool=null)
		{
			$usuario = null;
			$usuario = controlUsuario::getUserG(null,$userName);
			$respuesta = null;
			
			if($usuario!=null && count($usuario)==1)
			{
				if($pasActual!=null || $pasNueva!=null || $passNuevaConf!=null)
				{
					if($usuario[0]->getPassword()==md5($pasActual) || $bool!=null)
					{
						if($pasNueva!=null && $passNuevaConf!=null && $pasNueva==$passNuevaConf)
						{
							$respuesta = controlUsuario::editUserG($usuario[0]->getIdUsuario(),array($userName,$userFullName,md5($pasNueva),$correo,$level));
						}
						else
						{
							$respuesta = -3;
						}	
					}
					else
					{
						$respuesta = -2;	
					}
				}
				else
				{
					$level = $level==null? $usuario[0]->getPrivilegio():$level;
					if($userName!=null && $userFullName!=null && $level!=0 && $level!=null)
					{
						 
						$respuesta = controlUsuario::editUserG($usuario[0]->getIdUsuario(),array($userName,$userFullName,null,$correo,$level));
					}
					else
					{
						$respuesta = -5;
					}
					
				}	
			}
			else 
			{
				$respuesta = -6;
			}

			return $respuesta;
		}
		public function editUserG($idUser,$data)
		{
			$sql = conexionMySQLi::getInstance();
			$sentencia = "UPDATE usuarios SET ";
			$where = "WHERE idUser=?";
			$filtro = null;
			$arrData = array();
			$and = false;
				if($data!=null && count($data)>0 && $idUser!=null)
				{
					if($data[0]!=null)
					{
						$filtro.= $and? ", userName = ? ":"userName = ?";
						$arrData[] = $data[0];
						$and = true;
					}
					
					if($data[1]!=null)
					{
						$filtro.= $and? ", userFullName = ? ":"userFullName = ?";
						$arrData[] = $data[1];
						$and = true;
					}
					
					if($data[2]!=null)
					{
						$filtro.= $and? ", password = ? ":"password = ?";
						$arrData[] = $data[2];
						$and = true;
					}
					
					if($data[3]!=null)
					{
						$filtro.= $and? ", mail = ? ":"mail = ?";
						$arrData[] = $data[3];
						$and = true;
					}
					
					if($data[4]!=null)
					{
						$filtro.= $and? ", level = ? ":"level = ?";
						$arrData[] = $data[4];
						$and = true;
					}
					
					$arrData[] = $idUser;
					//return $arrData;
					return $sql-> ejecutarSentencia($sentencia.$filtro.$where,$arrData);
					
				}
				else 
				{
					return 43;
				}	
		}
		
		// ################################# END GONZALO#################################
		//###############################################################################################3
		// ########################## NICO #############################################################
		
		public function contarUsuarios($idCliente =null)
		{
			$sql = conexionMySQLi::getInstance();
			$sentencia = "select count(idUser) AS contar From usuarios";
			if ($idCliente!=null) $sentencia=$sentencia." where idCliente = ".$idCliente;
			$resulset = $sql->devDatos($sentencia);
						
			$data = null;
			while($value = $resulset->fetch_assoc())
			{
				$data = $value["contar"];
			}
			return $data;
		}
		public function getLoginfromUser($user,$pass)
		{
			$usuario = null;
			$sql = conexionMySQLi::getInstance();
			$sentencia = "SELECT idUser,idCliente, userName, userFullName, mail, level FROM usuarios WHERE userName = ? AND password = ?";
			$resultset = $sql->devDatos($sentencia,array($user,$pass));
			
			$resultset->bind_result($idUser,$idCliente,$userName,$userFullName,$mail,$level);
			if($resultset-> fetch()){
				$usuario = new usuario($idUser,$idCliente,$userName,$userFullName,$mail,$level);
			}
			
			$resultset->free_result();
			if($usuario != null){
				$sentencia = "SELECT idUser,modulo,credencial FROM perfilUsuario WHERE idUser = ".$usuario->getIdUsuario();
				
				$result = $sql->devDatos($sentencia);
				
				$privileges = array();
				while($row = $result->fetch_assoc()){
					$privileges[$row["modulo"]] = $row["credencial"];
				}
				
				$usuario->setPermisos($privileges);
			}
			
			return $usuario;		
		}
		
		public function setPermisos($userId,$permisos){
			//echo $userId.'<br />';
			//die("bind");
			$sql = conexionMySQLi::getInstance();
			$query = "INSERT INTO perfilUsuario(idUser,modulo,credencial) VALUES(?,?,?) ON DUPLICATE KEY UPDATE credencial=?";
			foreach($permisos as $id=>$value){
				$privileges = $value?array($userId,$id,1,1):array($userId,$id,0,0);
				$sql->ejecutarSentencia($query,$privileges);
			}
		}
	}
?>
