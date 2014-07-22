<?php
	foreach ($evaluaciones as $value) {		
		$evaluacion=array();
		$eva=$value["Evaluacion"];
		$evacan=$value["EvaCan"];
		$reclu=$value["ReclutadorContacto"];
		$r_contacto=$value["ReclutadorContacto"];		
		$evaluacion["nombre"]=$eva["evaluacion_nom"];
		$evaluacion["contacto_nombre"]= $r_contacto["con_nombre"] ." ". $r_contacto["con_paterno"]." " . $r_contacto["con_materno"];
		$evaluacion["label_status"]=$evacan["status"];
		$evaluacion["status"]=$evacan["evaluacion_status"];
		$evaluacion["idEva"]=$evacan["evaluacion_cve"];
		$evaluacion["id"]= $evacan["evaxcan_cve"];
		$evaluacion["tiempo"] =$eva["evaluacion_time"];
		$evaluacion["tipo"] =$eva["tipoeva_cve"];
		$evaluacion["nombre_empresa"] =$evacan["nombre_empresa"];
		$evaluacion['fecha_solicitud']=  array("order" => $evacan['created_order'] ,"str" =>$this->Time->dt($evacan['created']) ) ;
		$evaluacion['fecha_realizado']=  array("order" => $evacan['modified_order'] ,"str" =>$this->Time->dt($evacan['modified']) );
		$result[]=$evaluacion;

	}






  $this->_results = $result;
?> 