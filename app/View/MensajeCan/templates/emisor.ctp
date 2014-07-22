  
	<?php 
		$leido= $this->action!='enviados' ? "{{? !it.leido   }}unread {{?}}":"";
	 ?>

  <p class="remitente <?=$leido?>">
    {{= it.emisor.nombre}}<br/>
  <!--   <span class="label label-info">
      <small>{{= it.emisor.tipo ? 'Candidato' : 'Reclutador' }}</small>
  </span> -->
  </p>