
<div class="container">

	<div class="forma_genral_tit">
	<h2>
		<?php if( $isAuthUser ) :?>
			Mis Eventos
		<?php else : ?>
			Eventos
		<?php endif; ?>

	</h2>
</div>

  <div class="alert alert-info fade in popup" data-alert="alert">
    <i class="icon-info-sign icon-3x"></i>&nbsp;&nbsp;&nbsp;
     Consulta los eventos de reclutamiento, da clic en el recuadro del día o selecciona el mes o la semana, para que veas toda la información relacionada con el evento.
  </div>

  <?=$this->Form->input("idEvento", array(
	  	"type" => "hidden",
	  	"id" => "idEvento",
	  	"value" => $idEvento ))
  	?>


	<?php if( $isAuthUser ) :?>

		<div class="span3" >
			<?=$this->element("candidatos/datos_candidato");?>
			<div class="span3 left pull-left" style="padding-top:10px" >				
				 <a href="http://ednica.org.mx/" target="_blank">
                	<img src="/img/clientes/convenio/ednica_horizontal.jpg" class="img-polaroid">
            	</a>
			</div>
		</div>

		<?=$this->element('candidatos/eventos/descrip_evento')?>

	<?php else :?>
		<?php


		  $this->AssetCompress->addScript(array(
		    'trentrichardson/jQuery-Timepicker-Addon/dist/jquery-ui-timepicker-addon.js',
        'trentrichardson/jQuery-Timepicker-Addon/dist/i18n/jquery-ui-timepicker-es.js',
		    'vendor/fullcalendar/fullcalendar.min.js',
		    'app/candidatos/calendar_view.js'
		  ),
		    'calendar_view.js'
		  );
?>

	<?php endif; ?>
	 <?=
	 	 $this->Form->input('estado_pref', array(
	 	 	"id" => "estadopref01",
	 	 	"value" => $cerca_est,
         	'type' =>"hidden"
          ))?>


		<!-- Calendario-->
	<div class="<?=$isAuthUser ? 'span9' :'span12_2'   ?>">
		<div class="row pull-left">
			<?=$this->Form->input("Estados",array(
														"class"=>" estaditos",
														"label" => false,
														"empty" => "Todos los eventos",
														"options" => $list['estados']
								))  ?>
		</div>
		<div class="row-fluid">
				<div id="calendar" data-url="<?=$this->Html->url(array("controller" => "eventosCan" ,"action" => "index"))?>" ></div>
		</div>


	</div>



<?php if( $isAuthUser ) :?>

	<div class="span9">
		   <div id="semblaza_carru" data-component="carrusel"  
              data-type="flexslider" data-isajax="true" data-url="<?=$this->Html->url(array("controller" => "candidato" , "action" => "semblazas" ))?>" 
              data-template-id="#tmpl-semblaza" data-content-type="json" data-direction="vertical" 
              data-num-item-display="2" data-paginate="true" data-limit="40"      >

		      <div id="semblaza_carrs" class="flexslider">
		        
		             
		      </div>

		    <?=$this->Template->insert(array(
		        'semblaza',
		      ), null, array(
		        'viewPath' => 'Candidato'
		      ));
		       ?>
		    </div>
		
	</div>


	<?php
		// $art=ClassRegistry::init("WPPost");
  // 		$semblazas=$art->articulos_liga(2,'Semblanzas');

		//   if(!empty($semblazas)){
		//      echo $this->element("candidatos/semblanza",array("value"=> $semblazas[0],"extra_class" => "pull-left span9" ));
		//      echo $this->element("candidatos/semblanza",array("value"=> $semblazas[1],"extra_class" => "pull-left span9" ));
		//   }


	?>



<?php endif; ?>


</div>



<div class="container" style="margin-bottom:20px;">

   <div class="span5 right pull-right" style="padding-top:10px; padding-right:10px;">
   		<img class="img-polaroid" src="/img/publicidad/horizontal_R.Askins.jpg">
   </div>
   <div class="span5 right pull-left" style="padding-top:10px; padding-right:10px;">
   		<img class="img-polaroid" src="/img/publicidad/horizontal_impresor.jpg">
   </div>
</div>





