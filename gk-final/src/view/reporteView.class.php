<?php
require_once ('src/classes/visita.class.php');
require_once ('src/classes/controlCliente.class.php');
require_once ('src/classes/controlVisita.class.php');
require_once ('src/classes/controlReserva.class.php');
class reporteView{
	
	public function getReporteForm(){
		?>		
		<div data-role="page" id="reporte">
			<div data-role="content" id="reporte_c"></div>
		</div>
		<script>
		$(document).ready(function(){
			var ur = window.location.href;
			if(ur.indexOf("#reporte")>0){
				$('#reporte_c').load('reporteView.php',function(){
					 $('#reporte_c').trigger('create');
			 	});
			}			
			$('#reporte_').click(function(){
				/* $('#editarReservaVisita').load('cargaVisitaReserva.php?idCliente='+arrD[1]+'&idVisitaEdir='+arrD[0],function(){
				 $('#editarReservaVisita').trigger('create');
		 			});*/
				$('#reporte_c').load('reporteView.php',function(){
					 $('#reporte_c').trigger('create');
			 			});
			});
		});
		</script>
<?php
	}
}
?>