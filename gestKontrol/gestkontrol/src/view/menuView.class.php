<?php
require_once ('src/classes/usuario.php');
require_once ('src/classes/controlCliente.class.php');
require_once ('src/classes/cliente.class.php');
require_once ('src/classes/controlVisita.class.php');
require_once ('src/classes/controlUsuario.class.php');
require_once ('src/classes/controlConfiguracionGK.class.php');

require_once ('src/view/gestionVerificaValidaView.class.php');
require_once ('src/view/gestionClienteView.php');
require_once ('src/view/gestionUsuarioView.php');
require_once ('src/view/gestionVisitasView.class.php');
require_once ('src/view/gestionEdificioView.class.php');
require_once ('src/view/gestionProveedorView.class.php');
require_once ('src/view/gestionTarjetaView.class.php');
require_once ('src/view/gestionPanelControlView.php');
require_once ('src/view/gestionMensajeriaView.class.php');


class menuView
{
	public function getMenu($usuario) // el parametro generará el filtro para presentar el sistema dependiendo de los perfiles 
	{
		
		?>
	
		
		
			
		<div data-role="content">
		<?php
			//print_r($usuario);
			//die(); 
			$tipoVisitan = "normal";
			$tipoVisitap = "proveedor";
			$cliente = controlCliente::getCliente($usuario->getidCliente());
			$totalUsuarios = 0;
			$totalVisitaDeCliente = controlVisita::countVisitaCliente($usuario->getidCliente(),$tipoVisitan);
			$totalProveedorCliente = controlVisita::countVisitaCliente($usuario->getidCliente(),$tipoVisitap);
			
			if($usuario->getPrivilegio()>=5)
			{
				$totalUsuarios = controlUsuario::contarUsuarios();
			}
			else 
			{
				$totalUsuarios = controlUsuario::contarUsuarios($cliente->getidCliente());
			}
			
			//print_r();
			//die();
	
				//print_r($usuario);
				//print_r($usuario); 
				//die;
				if($usuario->getPrivilegio()>5) //developer
				{
					?>
					 <ul data-role="listview" data-inset="true" data-dividertheme="b" data-count-theme="b">
						<li data-role="list-divider">Gestión de Visitas</li>
						<li><a href="#nueva-visita" data-transition="slide" class="botonVistaVisitas"><img src="src/img/user.png" alt="Descripcion" class="ui-li-icon iconos"><h3 class="ui-li-heading">Nueva Visita</h3><p class="ui-li-desc">Agregar nueva visita, ingrese los detalles y confirme.</p></a></li>
						<li><a href="#editar-visitas" data-transition="slide" class="botonVistaVisitas"><img src="src/img/agendar.png" alt="Descripcion" class="ui-li-icon iconos"><h3 class="ui-li-heading">Agendar y Editar Visitas</h3><p class="ui-li-desc">Revise el listado completo de reservas. Edite o Elimine alguna visita activa.</p><span class="ui-li-count ui-btn-up-b ui-btn-corner-all"><?php echo $totalVisitaDeCliente;?></span></a></li>
						<li><a href="nueva-visita-calendario.php" rel="external"><img src="src/img/agendar.png" alt="Descripcion" class="ui-li-icon iconos"><h3 class="ui-li-heading">Agenda Rápida</h3><p class="ui-li-desc">Agregue nueva visita o Modifíquela utilizando calendario.</p></a></li>   
					</ul>
					
					<ul data-role="listview" data-inset="true" data-dividertheme="b" data-count-theme="b">
						<li data-role="list-divider">Gestión de Proveedores</li>
						<li><a href="#nuevo-proveedor" data-transition="slide" class="botonVistaProveedor"><img src="src/img/user.png" alt="Descripcion" class="ui-li-icon iconos"><h3 class="ui-li-heading">Agregar Proveedores</h3><p class="ui-li-desc">Ingrese los datos de un nuevo Proveedor.</p></a></li>
						<li><a href="#editar-proveedor" data-transition="slide" class="botonVistaProveedor"><img src="src/img/agendar.png" alt="Descripcion" class="ui-li-icon iconos"><h3 class="ui-li-heading">Agendar y/o Editar un proveedor</h3><p class="ui-li-desc">Agende y Edite un proveedor</p> <span class="ui-li-count ui-btn-up-b ui-btn-corner-all"><?php echo $totalProveedorCliente;?></span></a></li>
					</ul>
								
					<ul data-role="listview" data-inset="true" data-dividertheme="b">
					<li data-role="list-divider">Gestión de Clientes</li>
						<li><a href="#nuevo-cliente" data-transition="slide" class="botonVistaCliente"><img src="src/img/user.png" alt="Descripcion" class="ui-li-icon iconos"><h3 class="ui-li-heading">Agregar Cliente</h3>
						<p class="ui-li-desc">Ingrese los datos de un nuevo Cliente.</p></a></li>
						<li><a href="#editar-cliente" data-transition="slide" class="botonVistaCliente"><img src="src/img/editar.png" alt="Descripcion" class="ui-li-icon iconos"><h3 class="ui-li-heading">Editar Cliente</h3>
						<p class="ui-li-desc">Edite algun cliente.</p></a></li>  
				    </ul>
				   
				    <!-- ####################### NICO ##############################################################3 -->
				   <ul data-role="listview" data-inset="true" data-dividertheme="b" data-count-theme="b">
						 <li data-role="list-divider">Gestión de Usuarios</li>
						<li><a href="#nuevo-usuario" data-transition="slide" class="botonVistaUsuario"><img src="src/img/user.png" alt="Descripcion" class="ui-li-icon iconos"><h3 class="ui-li-heading">Nuevo Usuario</h3><p class="ui-li-desc">Agregar un nuevo usuario al sistema.</p></a></li>
						<li><a href="#editar-usuario" data-transition="slide" class="botonVistaUsuario"><img src="src/img/editar.png" alt="Descripcion" class="ui-li-icon iconos"><h3 class="ui-li-heading">Editar Usuarios</h3><p class="ui-li-desc">Revise el listado completo de usuarios. Edite algun privilegio o elimine algun usuario.</p><span class="ui-li-count ui-btn-up-b ui-btn-corner-all"><?php echo $totalUsuarios;?></span></a></li>
						
					</ul>
					
					<ul data-role="listview" data-inset="true" data-dividertheme="b" data-count-theme="b">
						 <li data-role="list-divider">Gestión de Edificio</li>
						<li><a href="#nuevo-piso" data-transition="slide" class="botonVistaEdificio"><img src="src/img/user.png" alt="Descripcion" class="ui-li-icon iconos"><h3 class="ui-li-heading">Agregar Piso y Oficina</h3><p class="ui-li-desc">Agrega un nuevo piso y oficina al sistema.</p></a></li>
						<li><a href="#edit-piso" data-transition="slide" class="botonVistaEdificio"><img src="src/img/editar.png" alt="Descripcion" class="ui-li-icon iconos"><h3 class="ui-li-heading">Editar Piso y Oficina</h3><p class="ui-li-desc">Edita un piso y/o oficina creada anteriormente.</p></a></li>
						<li><a href="#nuevo-estacionamiento" data-transition="slide" class="botonVistaEdificio"><img src="src/img/user.png" alt="Descripcion" class="ui-li-icon iconos"><h3 class="ui-li-heading">Agregar Estacionamientos</h3><p class="ui-li-desc">Agrega un nuevo estacionamiento al sistema.</p></a></li>
						<li><a href="#edit-estacionamiento" data-transition="slide" class="botonVistaEdificio"><img src="src/img/editar.png" alt="Descripcion" class="ui-li-icon iconos"><h3 class="ui-li-heading">Editar Estacionamiento</h3><p class="ui-li-desc">Edita un estacionamiento creado anteriormente.</p></a></li>
						
						
					</ul>
					<!-- ####################### NICO ##############################################################3 -->
				    
				     <ul data-role="listview" data-inset="true" data-dividertheme="b">
						<li data-role="list-divider">Verificación y Validación</li>
						<li><a href="#validar-visitas-global" data-transition="slide" class="botonVistaVal"><img src="src/img/validar.png" alt="Descripcion" class="ui-li-icon iconos"><h3 class="ui-li-heading">Validar Visitas</h3>
						<p class="ui-li-desc">Valide alguna visita peatonal o vehicular específica.</p></a></li>
						<!--  <li><a href="#validar-visitas-peaton" data-transition="slide"><img src="src/img/validar.png" alt="Descripcion" class="ui-li-icon iconos"><h3 class="ui-li-heading">Validar Visitas Peatonales</h3>
						<p class="ui-li-desc">Valide alguna visita peatonal específica.</p></a></li>
						<li><a href="#validar-visitas-vehiculo" data-transition="slide"><img src="src/img/validar.png" alt="Descripcion" class="ui-li-icon iconos"><h3 class="ui-li-heading">Validar Visitas Vehiculares</h3>
						<p class="ui-li-desc">Valide alguna visita vehicular específica.</p></a></li>-->
						<li><a href="#modificar-visitas" data-transition="slide" class="botonVistaVal"><img src="src/img/modificar.png" alt="Descripcion" class="ui-li-icon iconos"><h3 class="ui-li-heading">Modificar Validaciones Efectuadas</h3>
						<p class="ui-li-desc">Modifique alguna visita validada anteriormente.</p></a></li>
						<li><a href="#verificar-visitas" data-transition="slide" class="botonVistaVal"><img src="src/img/radar.png" alt="Descripcion" class="ui-li-icon iconos"><h3 class="ui-li-heading">Verificar Visitas</h3>
						<p class="ui-li-desc">Verifique alguna visita específica.</p></a></li>
				    </ul>
				     <?php 
				    if (controlConfiguracionGK::getConfiguracion(null,"Tarjetas")!=null&& controlConfiguracionGK::getConfiguracion(null,"Tarjetas")->getestado()=="1"){?>
				    <ul data-role="listview" data-inset="true" data-dividertheme="b" data-count-theme="b">
						<li data-role="list-divider">Gestión de Tarjetas</li>
						<li>
							<a href="#ingresa-tarjeta" data-transition="slide" class="botonVistaTarjeta"><img src="src/img/user.png" alt="Descripcion" class="ui-li-icon iconos">
								<h3 class="ui-li-heading">Agregar nueva Tarjeta</h3>
								<p class="ui-li-desc">Agrega una nueva tarjeta.</p>
							</a>
						</li>
						<li>
							<a href="#editar-tarjeta" data-transition="slide" class="botonVistaTarjeta"><img src="src/img/user.png" alt="Descripcion" class="ui-li-icon iconos">
								<h3 class="ui-li-heading">Editar tarjeta</h3>
								<p class="ui-li-desc">Edita o elimina una tarjeta existente.</p>
							</a>
						</li>
					</ul>
				    
				   
				    
					<?php 
					}
				}
				if($usuario->getPrivilegio() >4 && $usuario->getPrivilegio() < 6 ) //5 administrador
				{
				?>    
	 				 <ul data-role="listview" data-inset="true" data-dividertheme="b" data-count-theme="b">
						<li data-role="list-divider">Gestión de Visitas</li>
						<li><a href="#nueva-visita" data-transition="slide" class="botonVistaVisitas"><img src="src/img/user.png" alt="Descripcion" class="ui-li-icon iconos"><h3 class="ui-li-heading">Nueva Visita</h3><p class="ui-li-desc">Agregar nueva visita, ingrese los detalles y confirme.</p></a></li>
						<li><a href="#editar-visitas" data-transition="slide" class="botonVistaVisitas"><img src="src/img/agendar.png" alt="Descripcion" class="ui-li-icon iconos"><h3 class="ui-li-heading">Agendar y Editar Visitas</h3><p class="ui-li-desc">Revise el listado completo de reservas. Edite o Elimine alguna visita activa.</p><span class="ui-li-count ui-btn-up-b ui-btn-corner-all"><?php echo $totalVisitaDeCliente;?></span></a></li>
						<li><a href="nueva-visita-calendario.php" rel="external"><img src="src/img/agendar.png" alt="Descripcion" class="ui-li-icon iconos"><h3 class="ui-li-heading">Agenda Rápida</h3><p class="ui-li-desc">Agregue nueva visita o Modifíquela utilizando calendario.</p></a></li>
					</ul>
					
					<ul data-role="listview" data-inset="true" data-dividertheme="b" data-count-theme="b">
						<li data-role="list-divider">Gestión de Proveedores</li>
						<li><a href="#nuevo-proveedor" data-transition="slide" class="botonVistaProveedor"><img src="src/img/user.png" alt="Descripcion" class="ui-li-icon iconos"><h3 class="ui-li-heading">Agregar Proveedores</h3><p class="ui-li-desc">Ingrese los datos de un nuevo Proveedor.</p></a></li>
						<li><a href="#editar-proveedor" data-transition="slide" class="botonVistaProveedor"><img src="src/img/agendar.png" alt="Descripcion" class="ui-li-icon iconos"><h3 class="ui-li-heading">Agendar y/o Editar un proveedor</h3><p class="ui-li-desc">Agende y Edite un proveedor</p> <span class="ui-li-count ui-btn-up-b ui-btn-corner-all"><?php echo $totalProveedorCliente;?></span></a></li>
					</ul>
								
					<ul data-role="listview" data-inset="true" data-dividertheme="b">
					<li data-role="list-divider">Gestión de Clientes</li>
						<li><a href="#nuevo-cliente" data-transition="slide" class="botonVistaCliente"><img src="src/img/user.png" alt="Descripcion" class="ui-li-icon iconos"><h3 class="ui-li-heading">Agregar Cliente</h3>
						<p class="ui-li-desc">Ingrese los datos de un nuevo Cliente.</p></a></li>
						<li><a href="#editar-cliente" data-transition="slide" class="botonVistaCliente"><img src="src/img/user.png" alt="Descripcion" class="ui-li-icon iconos"><h3 class="ui-li-heading">Editar Cliente</h3>
						<p class="ui-li-desc">Edite algun cliente.</p></a></li>  
				    </ul>
				   
				    <!-- ####################### NICO ##############################################################3 -->
				   <ul data-role="listview" data-inset="true" data-dividertheme="b" data-count-theme="b">
						 <li data-role="list-divider">Gestión de Usuarios</li>
						<li><a href="#nuevo-usuario" data-transition="slide" class="botonVistaUsuario"><img src="src/img/user.png" alt="Descripcion" class="ui-li-icon iconos"><h3 class="ui-li-heading">Nuevo Usuario</h3><p class="ui-li-desc">Agregar un nuevo usuario al sistema.</p></a></li>
						<li><a href="#editar-usuario" data-transition="slide" class="botonVistaUsuario"><img src="src/img/editar.png" alt="Descripcion" class="ui-li-icon iconos"><h3 class="ui-li-heading">Editar Usuarios</h3><p class="ui-li-desc">Revise el listado completo de usuarios. Edite algun privilegio o elimine algun usuario.</p><span class="ui-li-count ui-btn-up-b ui-btn-corner-all"><?php echo $totalUsuarios;?></span></a></li>
						
					</ul>
					
					<!--  <ul data-role="listview" data-inset="true" data-dividertheme="b" data-count-theme="b">
						 <li data-role="list-divider">Gestión de Edificio</li>
						<li><a href="#nuevo-piso" data-transition="slide"><img src="src/img/user.png" alt="Descripcion" class="ui-li-icon iconos"><h3 class="ui-li-heading">Agregar Piso y Oficina</h3><p class="ui-li-desc">Agrega un nuevo piso y oficina al sistema.</p></a></li>
						
						
					</ul>-->
					<!-- ####################### NICO ##############################################################3 -->
				    
				     <ul data-role="listview" data-inset="true" data-dividertheme="b">
						<li data-role="list-divider">Verificación y Validación</li>
						<li><a href="#validar-visitas-global" data-transition="slide" class="botonVistaVal"><img src="src/img/validar.png" alt="Descripcion" class="ui-li-icon iconos"><h3 class="ui-li-heading">Validar Visitas</h3>
						<p class="ui-li-desc">Valide alguna visita peatonal o vehicular específica.</p></a></li>
						<!--  <li><a href="#validar-visitas-peaton" data-transition="slide"><img src="src/img/validar.png" alt="Descripcion" class="ui-li-icon iconos"><h3 class="ui-li-heading">Validar Visitas Peatonales</h3>
						<p class="ui-li-desc">Valide alguna visita peatonal específica.</p></a></li>
						<li><a href="#validar-visitas-vehiculo" data-transition="slide"><img src="src/img/validar.png" alt="Descripcion" class="ui-li-icon iconos"><h3 class="ui-li-heading">Validar Visitas Vehiculares</h3>
						<p class="ui-li-desc">Valide alguna visita vehicular específica.</p></a></li>-->
						<li><a href="#modificar-visitas" data-transition="slide" class="botonVistaVal"><img src="src/img/modificar.png" alt="Descripcion" class="ui-li-icon iconos"><h3 class="ui-li-heading">Modificar Validaciones Efectuadas</h3>
						<p class="ui-li-desc">Modifique alguna visita validada anteriormente.</p></a></li>
						<li><a href="#verificar-visitas" data-transition="slide" class="botonVistaVal"><img src="src/img/radar.png" alt="Descripcion" class="ui-li-icon iconos"><h3 class="ui-li-heading">Verificar Visitas</h3>
						<p class="ui-li-desc">Verifique alguna visita específica.</p></a></li>
				    </ul>
				    <?php 
				    if (controlConfiguracionGK::getConfiguracion(null,"Tarjetas")->getestado()=="1"){?>
				     <ul data-role="listview" data-inset="true" data-dividertheme="b" data-count-theme="b">
						<li data-role="list-divider">Gestión de Tarjetas</li>
						<li>
							<a href="#ingresa-tarjeta" data-transition="slide" class="botonVistaTarjeta"><img src="src/img/user.png" alt="Descripcion" class="ui-li-icon iconos">
								<h3 class="ui-li-heading">Agregar nueva Tarjeta</h3>
								<p class="ui-li-desc">Agrega una nueva tarjeta.</p>
							</a>
						</li>
						<li>
							<a href="#editar-tarjeta" data-transition="slide" class="botonVistaTarjeta"><img src="src/img/user.png" alt="Descripcion" class="ui-li-icon iconos">
								<h3 class="ui-li-heading">Editar tarjeta</h3>
								<p class="ui-li-desc">Edita o elimina una tarjeta existente.</p>
							</a>
						</li>
					</ul>
								
				<?php 
					}
				}
				?>
				
				<?php 
				if($usuario->getPrivilegio() > 3 && $usuario->getPrivilegio() < 5) //4 adminitristador de empresas
				{
				?>
					 <ul data-role="listview" data-inset="true" data-dividertheme="b" data-count-theme="b">
						<li data-role="list-divider">Gestión de Visitas</li>
						<li><a href="#nueva-visita" data-transition="slide" class="botonVistaVisitas"><img src="src/img/user.png" alt="Descripcion" class="ui-li-icon iconos"><h3 class="ui-li-heading">Nueva Visita</h3><p class="ui-li-desc">Agregar nueva visita, ingrese los detalles y confirme.</p></a></li>
						<li><a href="#editar-visitas" data-transition="slide" class="botonVistaVisitas"><img src="src/img/agendar.png" alt="Descripcion" class="ui-li-icon iconos"><h3 class="ui-li-heading">Agendar y Editar Visitas</h3><p class="ui-li-desc">Revise el listado completo de reservas. Edite o Elimine alguna visita activa.</p><span class="ui-li-count ui-btn-up-b ui-btn-corner-all"><?php echo $totalVisitaDeCliente;?></span></a></li>
						<li><a href="nueva-visita-calendario.php" rel="external"><img src="src/img/agendar.png" alt="Descripcion" class="ui-li-icon iconos"><h3 class="ui-li-heading">Agenda Rápida</h3><p class="ui-li-desc">Agregue nueva visita o Modifíquela utilizando calendario.</p></a></li>
					</ul>
					
					<ul data-role="listview" data-inset="true" data-dividertheme="b" data-count-theme="b">
						<li data-role="list-divider">Gestión de Proveedores</li>
						<li><a href="#nuevo-proveedor" data-transition="slide" class="botonVistaProveedor"><img src="src/img/user.png" alt="Descripcion" class="ui-li-icon iconos"><h3 class="ui-li-heading">Agregar Proveedores</h3><p class="ui-li-desc">Ingrese los datos de un nuevo Proveedor.</p></a></li>
						<li><a href="#editar-proveedor" data-transition="slide" class="botonVistaProveedor"><img src="src/img/agendar.png" alt="Descripcion" class="ui-li-icon iconos"><h3 class="ui-li-heading">Agendar y/o Editar un proveedor</h3><p class="ui-li-desc">Agende y Edite un proveedor</p> <span class="ui-li-count ui-btn-up-b ui-btn-corner-all"><?php echo $totalProveedorCliente;?></span></a></li>
					</ul>
					<!--  <ul data-role="listview" data-inset="true" data-dividertheme="b" data-count-theme="b">
						 <li data-role="list-divider">Gestión de Usuarios</li>
						<li><a href="#nuevo-usuario" data-transition="slide"><img src="src/img/user.png" alt="Descripcion" class="ui-li-icon iconos"><h3 class="ui-li-heading">Nuevo Usuario</h3><p class="ui-li-desc">Agregar un nuevo usuario al sistema.</p></a></li>
						<li><a href="#editar-usuario" data-transition="slide"><img src="src/img/editar.png" alt="Descripcion" class="ui-li-icon iconos"><h3 class="ui-li-heading">Editar Usuarios</h3><p class="ui-li-desc">Revise el listado completo de usuarios. Edite algun privilegio o elimine algun usuario.</p><span class="ui-li-count ui-btn-up-b ui-btn-corner-all"><?php echo $totalUsuarios;?></span></a></li>
						
					</ul>-->
					
					
				<?php 
				}
				?>
				<?php 
				if($usuario->getPrivilegio() > 2 && $usuario->getPrivilegio() < 4) //3
				{ 
				?>
					<ul data-role="listview" data-inset="true" data-dividertheme="b" data-count-theme="b">
						<li data-role="list-divider">Gestión de Visitas</li>
						<li><a href="#nueva-visita" data-transition="slide" class="botonVistaVisitas"><img src="src/img/user.png" alt="Descripcion" class="ui-li-icon iconos"><h3 class="ui-li-heading">Nueva Visita</h3><p class="ui-li-desc">Agregar nueva visita, ingrese los detalles y confirme.</p></a></li>
						<li><a href="#editar-visitas" data-transition="slide" class="botonVistaVisitas"><img src="src/img/agendar.png" alt="Descripcion" class="ui-li-icon iconos"><h3 class="ui-li-heading">Agendar y Editar Visitas</h3><p class="ui-li-desc">Revise el listado completo de reservas. Edite o Elimine alguna visita activa.</p><span class="ui-li-count ui-btn-up-b ui-btn-corner-all"><?php echo $totalVisitaDeCliente;?></span></a></li>
					</ul>
				
				<?php 
				}
				?>
				<?php 
				if($usuario->getPrivilegio() > 1 && $usuario->getPrivilegio() < 3) //2 
				{
				?>
				 <ul data-role="listview" data-inset="true" data-dividertheme="b">
					<li data-role="list-divider">Verificación y Validación</li>
					<li><a href="#validar-visitas-global" data-transition="slide" class="botonVistaVal"><img src="src/img/validar.png" alt="Descripcion" class="ui-li-icon iconos"><h3 class="ui-li-heading">Validar Visitas</h3>
					<p class="ui-li-desc">Valide alguna visita peatonal o vehicular específica.</p></a></li>
					<!-- <li><a href="#validar-visitas-peaton" data-transition="slide"><img src="src/img/validar.png" alt="Descripcion" class="ui-li-icon iconos"><h3 class="ui-li-heading">Validar Visitas Recepcion</h3>
					<p class="ui-li-desc">Valide alguna visita peatonal específica.</p></a></li>
					<li><a href="#validar-visitas-vehiculo" data-transition="slide"><img src="src/img/validar.png" alt="Descripcion" class="ui-li-icon iconos"><h3 class="ui-li-heading">Validar Visitas Vehiculares</h3>
					<p class="ui-li-desc">Valide alguna visita vehicular específica.</p></a></li> -->
					<li><a href="#modificar-visitas" data-transition="slide" class="botonVistaVal"><img src="src/img/modificar.png" alt="Descripcion" class="ui-li-icon iconos"><h3 class="ui-li-heading">Modificar Validaciones Efectuadas</h3>
					<p class="ui-li-desc">Modifique alguna visita validada anteriormente.</p></a></li>
					<li><a href="#verificar-visitas" data-transition="slide" class="botonVistaVal"><img src="src/img/radar.png" alt="Descripcion" class="ui-li-icon iconos"><h3 class="ui-li-heading">Verificar Visitas</h3>
					<p class="ui-li-desc">Verifique alguna visita específica.</p></a></li>
				</ul>
				<?php 
				}
				?>
				<?php 
				if($usuario->getPrivilegio() > 0 && $usuario->getPrivilegio() < 2) //1
				{
				?>
				 <ul data-role="listview" data-inset="true" data-dividertheme="b">
					<li data-role="list-divider">Verificación y Validación</li>
					<li><a href="#validar-visitas-global" data-transition="slide" class="botonVistaVal"><img src="src/img/validar.png" alt="Descripcion" class="ui-li-icon iconos"><h3 class="ui-li-heading">Validar Visitas</h3>
					<p class="ui-li-desc">Valide alguna visita peatonal o vehicular específica.</p></a></li>
					<!-- <li><a href="#validar-visitas-peaton" data-transition="slide"><img src="src/img/validar.png" alt="Descripcion" class="ui-li-icon iconos"><h3 class="ui-li-heading">Validar Visitas Recepcion</h3>
					<p class="ui-li-desc">Valide alguna visita peatonal específica.</p></a></li>
					<li><a href="#validar-visitas-vehiculo" data-transition="slide"><img src="src/img/validar.png" alt="Descripcion" class="ui-li-icon iconos"><h3 class="ui-li-heading">Validar Visitas Vehiculares</h3>
					<p class="ui-li-desc">Valide alguna visita vehicular específica.</p></a></li> -->
					<li><a href="#modificar-visitas" data-transition="slide" class="botonVistaVal"><img src="src/img/modificar.png" alt="Descripcion" class="ui-li-icon iconos"><h3 class="ui-li-heading">Modificar Validaciones Efectuadas</h3>
					<p class="ui-li-desc">Modifique alguna visita validada anteriormente.</p></a></li>
					<li><a href="#verificar-visitas" data-transition="slide" class="botonVistaVal"><img src="src/img/radar.png" alt="Descripcion" class="ui-li-icon iconos"><h3 class="ui-li-heading">Verificar Visitas</h3>
					<p class="ui-li-desc">Verifique alguna visita específica.</p></a></li>
				</ul>
				<?php 
				}
				?>

			<ul data-role="listview" data-dividertheme="d" data-inset="true">
					<li data-role="list-divider">Perfil</li> 
					<?php 
					switch ($usuario->getPrivilegio())
					{
						case 6:
							?>
								<li><a href="#mi-perfil" value="gestionUsuario" class="botonVistaUsuario">Mi Perfil</a></li>
								<li><a href="#Administrar-perfiles" class="botonVistaUsuario">Agregar Usuario</a></li>
								<li><a href="#editar-usuario-cliente" class="botonVistaUsuario">Editar Usuarios</a></li>
								<li><a href="#Panel-de-control" class="botonVistaPanelControl">Panel de Control</a></li>
							
							<?php 
							break;
							
						case 5:
							?>
							<li><a href="#mi-perfil" class="botonVistaUsuario">Mi Perfil</a></li>
							<li><a href="#Administrar-perfiles" class="botonVistaUsuario">Agregar Usuario</a></li>
							<li><a href="#editar-usuario-cliente" class="botonVistaUsuario">Editar Usuarios</a></li>
							<li><a href="#Panel-de-control" class="botonVistaPanelControl">Panel de Control</a></li>
							<?php 
							break;
							
						case 4:
							?>
							  <li><a href="#mi-perfil" class="botonVistaUsuario">Mi Perfil</a></li>
							  <li><a href="#Administrar-perfiles" class="botonVistaUsuario">Agregar Usuario</a></li>
							  <li><a href="#editar-usuario-cliente" class="botonVistaUsuario"> Editar Usuarios</a></li>
							<?php 
							break;
							
						case 2 || 1:
							?>
								<li><a href="#mi-perfil" class="botonVistaUsuario">Mi Perfil</a></li> 
							<?php 
							break;
					}
					?>
						
					
					
				</ul> 

			</div><!-- /content --> 
	</div>
			
				
		<?php
		switch($usuario->getPrivilegio())
		{
			case 1:
				
				gestionMensajeriaView::vistasMensajeria();
				gestionVerificaValidaView::vistasValidacion();
				gestionUsuarioView::vistasUsuario($usuario->getPrivilegio());
				
				/*gestionVerificaValidaView::getViewValidarVisitasGlobal();
				//gestionVerificaValidaView::getViewValidarVisitasPeaton();
				//gestionVerificaValidaView::getViewValidarVisitasVehiculo();
				gestionVerificaValidaView::getViewVerificarVisitas();
				gestionVerificaValidaView::enviaMensajeVisitaEspera();
				gestionVerificaValidaView::getViewModificarVisitas();*/
				
				
				
				//gestionUsuarioView::getMiPerfil(null,$usuario);
				
				
				/*gestionMensajeriaView::bandejaEntrada($usuario->getIdUsuario());
				gestionMensajeriaView::mensajesEnviados($usuario->getIdUsuario());
				gestionMensajeriaView::mensajesEliminados($usuario->getIdUsuario());
				gestionMensajeriaView::viewMensaje();
				gestionMensajeriaView::nuevoMensaje($usuario->getIdUsuario());*/
				
				
				
				
				
				break;
				
			case 2:
				
				gestionMensajeriaView::vistasMensajeria();
				gestionVerificaValidaView::vistasValidacion();
				gestionUsuarioView::vistasUsuario($usuario->getPrivilegio());
				
				/*gestionVerificaValidaView::getViewValidarVisitasGlobal();
				//gestionVerificaValidaView::getViewValidarVisitasPeaton();
				//gestionVerificaValidaView::getViewValidarVisitasVehiculo();
				gestionVerificaValidaView::getViewVerificarVisitas();
				gestionVerificaValidaView::getViewModificarVisitas();
				gestionVerificaValidaView::enviaMensajeVisitaEspera();*/
				
				
				
				//gestionUsuarioView::getMiPerfil(null,$usuario);
				
				/*gestionMensajeriaView::bandejaEntrada($usuario->getIdUsuario());
				gestionMensajeriaView::mensajesEnviados($usuario->getIdUsuario());
				gestionMensajeriaView::mensajesEliminados($usuario->getIdUsuario());
				gestionMensajeriaView::viewMensaje();
				gestionMensajeriaView::nuevoMensaje($usuario->getIdUsuario());*/
				
				
				
				
				break;
			case 3: // cliente
				
				gestionVisitasView::getReservaVisitaDiv();
				gestionVisitasView::getEditarVisitaDatosPersonales();
				
				gestionVisitasView::getVisitasEnEspera($usuario->getidCliente());
				gestionVisitasView::vistasVisitas();
				gestionMensajeriaView::vistasMensajeria();
				gestionUsuarioView::vistasUsuario($usuario->getPrivilegio());
				/*
				 * //gestionVisitasView::getVisitas($usuario->getidCliente())
				gestionVisitasView::getIngresoVisita(null,$usuario->getidCliente());
				gestionVisitasView::getEditarVisitaDatosPersonales();
				gestionVisitasView::getReservaVisitaDiv();*/
				//gestionVisitasView::getEditarVisitaReserva($usuario->getidCliente());
				/*gestionVisitasView::getVisitas($usuario->getidCliente());
				gestionVisitasView::getVisitasEnEspera($usuario->getidCliente());*/
				
				//gestionUsuarioView::getMiPerfil(null,$usuario);	
				
				/*gestionMensajeriaView::bandejaEntrada($usuario->getIdUsuario());
				gestionMensajeriaView::mensajesEnviados($usuario->getIdUsuario());
				gestionMensajeriaView::mensajesEliminados($usuario->getIdUsuario());
				gestionMensajeriaView::viewMensaje();
				gestionMensajeriaView::nuevoMensaje($usuario->getIdUsuario());*/
				
				
				break;
				
			case 4: //Administrador de clientes 
				
				gestionVisitasView::getReservaVisitaDiv();
				gestionVisitasView::getEditarVisitaDatosPersonales();
				
				gestionVisitasView::getVisitasEnEspera($usuario->getidCliente());
				gestionVisitasView::vistasVisitas();
				
				/*gestionVisitasView::getIngresoVisita(null,$usuario->getidCliente());
				gestionVisitasView::getEditarVisitaDatosPersonales();
				gestionVisitasView::getReservaVisitaDiv();
				gestionVisitasView::getVisitas($usuario->getidCliente());
				gestionVisitasView::getVisitasEnEspera($usuario->getidCliente());*/
				
				gestionUsuarioView::vistasUsuario($usuario->getPrivilegio());
				gestionUsuarioView::getVentanaEdicionUsuarios($usuario->getPrivilegio());
				gestionUsuarioView::getVentanaEdicionOperador($usuario->getPrivilegio());
				gestionUsuarioView::getformIgresDiv();
				
				
				/*gestionUsuarioView::getIngresoUsuario($usuario->getPrivilegio(),$usuario->getidCliente());
				gestionUsuarioView::getEditarUsuario($usuario->getPrivilegio(),$usuario->getidCliente());*/
				
				gestionProveedorView::vistasProveedor();
				gestionProveedorView::geteditarPerfilProveedorDiv();
				gestionProveedorView::getReservaProveedorDiv();
				
				/*gestionProveedorView::getIngresoProveedor($usuario->getidCliente());
				gestionProveedorView::getEditarProveedor($usuario->getidCliente()); // falta el eliminar
				gestionProveedorView::geteditarPerfilProveedorDiv();
				gestionProveedorView::getReservaProveedorDiv();

				/*gestionUsuarioView::getMiPerfil(null,$usuario);
				gestionUsuarioView::getAdministrarPerfiles(null,$usuario);
				gestionUsuarioView::getEditarUsuariosCliente($usuario);
				gestionUsuarioView::getformIgresDiv();
				//****** NICO########3
				/*gestionUsuarioView::getIngresoUsuario($usuario->getPrivilegio(),$usuario->getidCliente());
				gestionUsuarioView::getEditarUsuario($usuario->getPrivilegio(),$usuario->getidCliente());
				gestionUsuarioView::getVentanaEdicionUsuarios($usuario->getPrivilegio());
				gestionUsuarioView::getVentanaEdicionOperador($usuario->getPrivilegio());*/
				//****** NICO########3
				
				//****** NICO########3
				/*nico	*/
				//gestionVisitasView::getIngresoVisita();
				//gestionClienteView::getIngresoCliente();
				//gestionClienteView::getEditarCliente();
				//gestionVerificaValidaView::getViewValidarVisitasPeaton();
				//gestionVerificaValidaView::getViewValidarVisitasVehiculo();
				//gestionVerificaValidaView::getViewVerificarVisitas();
				//gestionVerificaValidaView::getViewModificarVisitas();
				/*
				gestionMensajeriaView::bandejaEntrada($usuario->getIdUsuario());
				gestionMensajeriaView::mensajesEnviados($usuario->getIdUsuario());
				gestionMensajeriaView::mensajesEliminados($usuario->getIdUsuario());
				gestionMensajeriaView::viewMensaje();
				gestionMensajeriaView::nuevoMensaje($usuario->getIdUsuario());*/
				gestionMensajeriaView::vistasMensajeria();
				
				

				break;

			case 5:  ///* esta parte es solo del administrador
				
				gestionVisitasView::getReservaVisitaDiv();
				gestionVisitasView::getEditarVisitaDatosPersonales();
				
				gestionVisitasView::getVisitasEnEspera($usuario->getidCliente());
				gestionVisitasView::vistasVisitas();
				
				
				
				gestionUsuarioView::vistasUsuario($usuario->getPrivilegio());
				gestionUsuarioView::getVentanaEdicionUsuarios($usuario->getPrivilegio());
				gestionUsuarioView::getVentanaEdicionOperador($usuario->getPrivilegio());
				gestionUsuarioView::getformIgresDiv();
				
				gestionClienteView::vistasCliente();
				gestionClienteView::getEditarPisosClienteDivInicial();
				gestionClienteView::geteditarEstacionamientosDiv();
				gestionClienteView::getEditDatosPersoalesClientes();
				
				
				gestionProveedorView::vistasProveedor();
				gestionProveedorView::geteditarPerfilProveedorDiv();
				gestionProveedorView::getReservaProveedorDiv();
				
				/*gestionVisitasView::getIngresoVisita(null,$usuario->getidCliente());
				gestionVisitasView::getEditarVisitaDatosPersonales();
				gestionVisitasView::getReservaVisitaDiv();
				gestionVisitasView::getVisitas($usuario->getidCliente());
				gestionVisitasView::getVisitasEnEspera($usuario->getidCliente());
				
				
				gestionProveedorView::getIngresoProveedor($usuario->getidCliente());
				gestionProveedorView::getEditarProveedor($usuario->getidCliente()); // falta el eliminar
				gestionProveedorView::geteditarPerfilProveedorDiv();
				gestionProveedorView::getReservaProveedorDiv();
				/*nico*/
				/*gestionClienteView::getIngresoCliente();
				gestionClienteView::getEditarCliente();
				gestionClienteView::getEditDatosPersoalesClientes();
				gestionClienteView::getEditarPisosClienteDivInicial();
				gestionClienteView::geteditarEstacionamientosDiv();
				//****** NICO########3
				gestionUsuarioView::getIngresoUsuario($usuario->getPrivilegio(),$usuario->getidCliente());
				gestionUsuarioView::getEditarUsuario($usuario->getPrivilegio(),$usuario->getidCliente());
				//****** NICO########3
				gestionUsuarioView::getVentanaEdicionUsuarios($usuario->getPrivilegio());
				gestionUsuarioView::getVentanaEdicionOperador($usuario->getPrivilegio());
				//****** NICO########3					
				//gestionUsuarioView::getIngresoUsuario();
				//gestionUsuarioView::getEditarUsuario();
				gestionVerificaValidaView::getViewValidarVisitasGlobal();
				gestionVerificaValidaView::getViewVerificarVisitas();
				gestionVerificaValidaView::getViewModificarVisitas();
				/*gestionVerificaValidaView::getViewValidarVisitasPeaton($usuario->getidCliente(),$usuario->getPrivilegio());
				gestionVerificaValidaView::getViewValidarVisitasVehiculo();
				gestionVerificaValidaView::getViewVerificarVisitas();
				gestionVerificaValidaView::getViewModificarVisitas();*/

				/*gestionUsuarioView::getMiPerfil(null,$usuario);
				gestionUsuarioView::getAdministrarPerfiles(null,$usuario);
				gestionUsuarioView::getEditarUsuariosCliente($usuario);
				gestionUsuarioView::getformIgresDiv();
				/*
				gestionMensajeriaView::bandejaEntrada($usuario->getIdUsuario());
				gestionMensajeriaView::mensajesEnviados($usuario->getIdUsuario());
				gestionMensajeriaView::mensajesEliminados($usuario->getIdUsuario());
				gestionMensajeriaView::viewMensaje();
				gestionMensajeriaView::nuevoMensaje($usuario->getIdUsuario());
				*/
				gestionPanelControl::vistasPanelControl();
				gestionMensajeriaView::vistasMensajeria();

				if (controlConfiguracionGK::getConfiguracion(null,"Tarjetas")!=null && controlConfiguracionGK::getConfiguracion(null,"Tarjetas")->getestado()=="1")
				{
					gestionTarjetaView::vistasTarjeta();
					/*gestionTarjetaView::ingresaTarjeta();
					gestionTarjetaView::editaTarjeta();
					gestionTarjetaView::edicionTarjeta();*/
				}
				
								
				break;
				
			case 6: /* solo developer*/
				/***********************************************************************
				* 
				* 					INICIO MODULO VISITAS 
				* 
				************************************************************************
				gestionVisitasView::getIngresoVisita(null,$usuario->getidCliente());
				gestionVisitasView::getEditarVisitaDatosPersonales();*/
				//gestionVisitasView::getEditarVisitaReserva($usuario->getidCliente()); //EN CAMBIOS!!!
				
				gestionVisitasView::getReservaVisitaDiv();
				gestionVisitasView::getEditarVisitaDatosPersonales();
				//gestionVisitasView::getVisitas($usuario->getidCliente());
				gestionVisitasView::getVisitasEnEspera($usuario->getidCliente());
				gestionVisitasView::vistasVisitas();
				/***********************************************************************
				 *
				* 					FIN MODULO VISITAS
				*
				************************************************************************/
				/***********************************************************************
				*
				* 					INICIO MODULO PROVEEDOR
				*
				************************************************************************
				gestionProveedorView::getIngresoProveedor($usuario->getidCliente());
				gestionProveedorView::getEditarProveedor($usuario->getidCliente()); // falta el eliminar*/
				gestionProveedorView::vistasProveedor();
				gestionProveedorView::geteditarPerfilProveedorDiv();
				gestionProveedorView::getReservaProveedorDiv();
				/***********************************************************************
				*
				* 					FIN MODULO PROVEEDOR
				*
				************************************************************************/
				
				/***********************************************************************
				*
				* 					INICIO MODULO CLIENTE
				*
				************************************************************************
				
				gestionClienteView::getIngresoCliente();
				gestionClienteView::getEditarCliente();
				gestionClienteView::getEditDatosPersoalesClientes();*/
				
				gestionClienteView::vistasCliente();
				gestionClienteView::getEditarPisosClienteDivInicial();
				gestionClienteView::geteditarEstacionamientosDiv();
				gestionClienteView::getEditDatosPersoalesClientes();
				
				/***********************************************************************
				*
				* 					FIN MODULO CLIENTE
				*
				************************************************************************/
				
				/*nico*/
				/*gestionClienteView::getIngresoCliente();
				gestionClienteView::getEditarCliente();*/
				/*
				gestionUsuarioView::getIngresoUsuario();
				gestionUsuarioView::getEditarUsuario();*/
				//****** NICO########3
				
				/***********************************************************************
				 *
				* 					INICIO MODULO USUARIO
				*
				************************************************************************
				gestionUsuarioView::getIngresoUsuario($usuario->getPrivilegio(),$usuario->getidCliente());
				gestionUsuarioView::getEditarUsuario($usuario->getPrivilegio(),$usuario->getidCliente());
				gestionUsuarioView::getVentanaEdicionUsuarios($usuario->getPrivilegio());
				gestionUsuarioView::getVentanaEdicionOperador($usuario->getPrivilegio());
				gestionUsuarioView::getMiPerfil(null,$usuario);
				gestionUsuarioView::getAdministrarPerfiles(null,$usuario);
				gestionUsuarioView::getEditarUsuariosCliente($usuario);
				gestionUsuarioView::getformIgresDiv();*/
				
				gestionUsuarioView::vistasUsuario($usuario->getPrivilegio());
				gestionUsuarioView::getVentanaEdicionUsuarios($usuario->getPrivilegio());
				gestionUsuarioView::getVentanaEdicionOperador($usuario->getPrivilegio());
				gestionUsuarioView::getformIgresDiv();
				/***********************************************************************
				 *
				* 					FIN MODULO USUARIO
				*
				************************************************************************/
				
				/***********************************************************************
				 *
				* 					INICIO MODULO EDIFICIO
				*
				*************************************************************************/
				gestionEdificioView::vistasEdificio();
				/*
				gestionEdificioView::getIngresoPisoOficina(); //gestion de edificios
				gestionEdificioView::getIngresoPisoEstacionamiento(); //gestion de edificios
				gestionEdificioView::editPisosOficinas();
				gestionEdificioView::edicionOficina();
				gestionEdificioView::editEstacionamientos();
				gestionEdificioView::edicionEstacionamiento();*/
				/***********************************************************************
				 *
				* 					FIN MODULO EDIFICIO
				*
				************************************************************************/
				
				//****** NICO########3
				/***********************************************************************
				 *
				* 					INICIO MODULO VALIDACION/VERIFICACION
				*
				************************************************************************/
				gestionVerificaValidaView::vistasValidacion();
				
				/*gestionVerificaValidaView::getViewValidarVisitasGlobal();
				gestionVerificaValidaView::getViewVerificarVisitas();
				gestionVerificaValidaView::getViewModificarVisitas();
				gestionVerificaValidaView::enviaMensajeVisitaEspera();*/
				
				/*gestionVerificaValidaView::getViewValidarVisitasPeaton($usuario->getidCliente(),$usuario->getPrivilegio());
				gestionVerificaValidaView::getViewValidarVisitasVehiculo();
				gestionVerificaValidaView::getViewVerificarVisitas();
				gestionVerificaValidaView::getViewModificarVisitas();*/
				
				
				
				/***********************************************************************
				 *
				* 					FIN MODULO VALIDACION/VERIFICACION
				*
				************************************************************************/
				
				
				
				/***********************************************************************
				 *
				* 					INICIO MODULO MENSAJERIA
				*
				************************************************************************/
				gestionMensajeriaView::vistasMensajeria();
				
				/*gestionMensajeriaView::bandejaEntrada($usuario->getIdUsuario());
				gestionMensajeriaView::mensajesEnviados($usuario->getIdUsuario());
				gestionMensajeriaView::mensajesEliminados($usuario->getIdUsuario());
				gestionMensajeriaView::viewMensaje();
				gestionMensajeriaView::nuevoMensaje($usuario->getIdUsuario());*/
				
				/***********************************************************************
				 *
				* 					FIN MODULO MENSAJERIA
				*
				************************************************************************/
				
				
				/***********************************************************************
				 *
				* 					INICIO MODULO PANEL DE CONTROL
				*
				************************************************************************/
				//gestionPanelControl::getPanelControl($usuario);
				gestionPanelControl::vistasPanelControl();
				/***********************************************************************
				 *
				* 					FIN MODULO PANEL DE CONTROL
				*
				************************************************************************/
				
				/***********************************************************************
				 *
				* 					INICIO MODULO TARJETAS
				*
				************************************************************************/
				if (controlConfiguracionGK::getConfiguracion(null,"Tarjetas")!=null && controlConfiguracionGK::getConfiguracion(null,"Tarjetas")->getestado()=="1")
				{
					gestionTarjetaView::vistasTarjeta();
				/*	gestionTarjetaView::ingresaTarjeta();
					gestionTarjetaView::editaTarjeta();
					gestionTarjetaView::edicionTarjeta();
				*/
				}
				/***********************************************************************
				 *
				* 					FIN MODULO TARJETAS
				*
				************************************************************************/
				
				
				break;
		}
		
	}
	
}
?>
