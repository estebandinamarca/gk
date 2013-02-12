<?php
require_once ('src/classes/visita.class.php');
require_once ('src/classes/controlCliente.class.php');
require_once ('src/classes/controlVisita.class.php');
require_once ('src/classes/controlReserva.class.php');
class reporteView{
	
	public function getReporteForm(){
		?>		
		<div data-role="page" id="reporte">
		</div>
		<script>
		$(document).ready(function(){
			var ur = window.location.href;
			if(ur.indexOf("#reporte")>0){
				$('#reporte').load('reporteView.php',function(){
					 $('#reporte').trigger('create');
			 	});
			}			
			$('#reporte_').click(function(){
				/* $('#editarReservaVisita').load('cargaVisitaReserva.php?idCliente='+arrD[1]+'&idVisitaEdir='+arrD[0],function(){
				 $('#editarReservaVisita').trigger('create');
		 			});*/
				$('#reporte').load('reporteView.php',function(){
					 $('#reporte').trigger('create');
			 			});
			});
		});
		</script><?php
	}
}
?>