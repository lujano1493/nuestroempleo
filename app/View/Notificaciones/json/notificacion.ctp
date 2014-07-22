<?php 
  App::import("Vendor",array( "funciones" ));


	$totales= $notificaciones['totales'];
	$notificaciones	=$notificaciones['results'];

	$results=array();

	foreach ($notificaciones as $key => $value) {
		$ntfy=$value['Notificacion'];
		$from=$value['From'];
		$cia_logo=  !empty($from['cia_cve']) ? Funciones::check_image_cia($from['cia_cve']) :null;


		$link= $ntfy['notificacion_controlador'];


		// $link = !empty($link) && $link!=='#' ? $link."/".$ntfy['notificacion_id']:"#";  
		$data=array(
						"id" => $ntfy['notificacion_cve'],					 
						"no_leido" => $ntfy['notificacion_leido'] ==0,
						"link" => $link,
						"titulo" => $ntfy['notificacion_titulo'],
						"texto" => $ntfy['notificacion_texto'],
						"fecha" =>$this->Time->dt($ntfy['created']),
						"cia_nombre"=>$from['cia_nombre'],
						"cia_logo" => $cia_logo,
						"email" => $from['email'],
						"nombre" => $from['nombre'],
						"tipo" => $ntfy['tipo'],
						"icon" => $ntfy['icon'],
						"clazz" => $ntfy['clazz'],

			);
		$results[]=$data;
	}
	$this->_results=compact("totales", "results");

?>