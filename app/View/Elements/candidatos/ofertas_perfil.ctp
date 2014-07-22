<?php  foreach ($ofertas_perfil  as $k=> $o):
   $oferta= $o['OfertaB']
?>

  <div class="pull-left <?= $oferta['oferta_status'] == 3? 'destacadas_candidato2': ($oferta['oferta_status']==2 ? 'destacadas_candidato':'ofertas_segun_perfil')  ?>   span12">
    <p style="text-align:justify">

    	 <?=$this->Html->link ($oferta['puesto_nom'],array(
            "controller" => "postulacionesCan",
            "action" => "oferta_detalles",
            "id" => $oferta['oferta_cve']
          ), array(                     
            "data-toggle" =>"modal-ajax",
            "data-target" =>"#oferta_detalles01"

          ) ) ?>
		<br>
       <small><?=$oferta['pais_nom']?>   <?=$oferta['est_nom']?>  <?=$oferta['oferta_sueldo']?> </small>

    </p>

  </div>


<?php  endforeach;?>

