<?php  

	 if (!empty($callback) && !empty($compartir)) {
	 	$results=array();
	 	if($tipo==='oferta'){
	 		foreach ($compartir as $k) {
		    $oferta=$k['Oferta'];
		    $usuario=$k['UsuarioEmpresa'];
		    $empresa=$k['Empresa'];
		    $results[]=array(
		        'id' => $oferta['oferta_cve'],
		        'tipoCompartir' =>  'oferta',
		        'codigo' => $oferta['oferta_cvealter'],
		        'nombre' => $oferta['puesto_nom'],
		        'vigencia' => $oferta['vigencia'],
		        'empresa' => $empresa['cia_nombre'],
		        'liga' => $oferta['oferta_link'],
		        'fecha' => array(
		              'val' =>$oferta['created'],
		              'str' =>$this->Time->d($oferta['created']) 
		          ),
		        'veces_compartidas' => (int)$oferta['compartido'],
		        'compartir' => array(
		                'facebook' => (int)$oferta['compartido_facebook'],
		                'twitter' => (int)$oferta['compartido_twitter'],
		                'linkedin'=> (int)$oferta['compartido_linkedin']
		          )

		      );
		  	}	 

	 	}		  	
	 	else  if ($tipo==='evento'){
	 		foreach ($compartir as $k) {
				    $evento=$k['Evento'];
				    $usuario=$k['Reclutador'];
				    $empresa=$k['Empresa'];
				    $results[]=array(
				        'id' => $evento['evento_cve'],
				        'tipoCompartir' =>  'evento',
				        'nombre' => $evento['evento_nombre'],				        
				        'descripcion' => $evento['evento_resena'],
				        'direccion' => $evento['evento_dir'],
				        'ciudad' => $evento['ciudad_nom'],
				        'estado' => $evento['est_nom'],
				        'tipo' => $evento['tipo_nombre'],
				        'empresa' => $empresa['cia_nombre'],
				        'liga' => $evento['evento_link'],
				        'fecha_inicio' => array(
				              'val' =>$evento['evento_fecini'],
				              'str' =>$this->Time->d($evento['evento_fecini']) 
				          ),
				        'fecha_fin' => array(
				              'val' =>$evento['evento_fecfin'],
				              'str' =>$this->Time->d($evento['evento_fecfin']) 
				          ),
				        'veces_compartidas' => (int)$evento['compartido'],
				        'compartir' => array(
				                'facebook' => (int)$evento['compartido_facebook'],
				                'twitter' => (int)$evento['compartido_twitter'],
				                'linkedin'=> (int)$evento['compartido_linkedin']
				          )

				      );
				  }
	 		


	 	}
	    $callback['args'] = array(
	      $results
	    );
	    $this->set(compact('callback'));
  }


?>