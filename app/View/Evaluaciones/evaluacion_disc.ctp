

<?php 
	if($status==0){
		$link_result= $this->Html->url(array(
	      'controller' => 'Evaluaciones',
	      'action' => 'evaluacion_disc_gracias',
	       $id,
	      $status
	    ), true);
		$link_result= str_replace("http://","",$link_result);
		$link_result= str_replace("/","%252F",$link_result);
	    //$link_result=urlencode($link_result);
		$id=$authUser['candidato_cve'];
		$nom=$authUser['Candidato']['candidato_nom'] ;
		$apellidos=$authUser['Candidato']['candidato_pat']." ".$authUser['Candidato']['candidato_mat'] ;
		$email=$authUser['cc_email'];
		$genero=$authUser['Candidato']['candidato_sex']=="M" ? "m":"f";

		$url="http://imx.obail.net?q=profile&h=disc&s=igntr&r=$id&f=$nom&l=$apellidos&e=$email&g=$genero&u=$link_result&i=es";	
	}		

	/*
	tp%3A%2F%2Fnuestroempleo.dev%2FEvaluaciones%2Fevaluacion_disc_resultados%2F1%2F0&i=e
	http://imx.obail.net?q=profile&h=disc&s=igntr&r=11001000008&f=GERALDO&l=…%253A%252F%252Fwww.igenter.net%252Fcolabs%252Fjsp%252FsrvlTermEva.jsp&i=es
	http://imx.obail.net?q=profile&h=disc&s=igntr&r=11001000008&f=GERALDO&l=…www.nuestroempleo.com.mx/&i=es

	*/
	else {
		$url="/Evaluaciones/evaluacion_disc_resultados/$id/$status";

	}	
?>

<div style="padding-top:50px"></div>


<iframe   src="<?=$url?>" width="100%" height="600px" frameborder="0" scrolling="auto" onload='javascript:resizeIframe(this);' marginheight="0" marginwidth="0"  data-status="<?=$status?>"  > <p>Your browser does not support iframes.</p>
</iframe>



<?php 

		 $script=
		  'function resizeIframe(obj) {
		  			var status=$(obj).data("status");
		  	 		if( status!=0 ){
		  	 			console.log(obj.contentWindow.document.body.scrollHeight );
				  		//obj.style.height = obj.contentWindow.document.body.scrollHeight + "px";
				  			obj.style.height = obj.contentWindow.document.body.scrollHeight + "px";
				  	}      	
		  }
		  ';
			$this->Html->scriptBlock($script,array("inline"=>false));


?>