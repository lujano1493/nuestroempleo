  <!-- eventos -->

<?php 
		$idEstado=null;
		if(!empty($this->data['CodigoPostal'])){
			$idEstado=$this->data['CodigoPostal']['est_cve'];

		}

    $evento=ClassRegistry::init("Evento");
    $evento->micrositio=$micrositio;
	$rs=$evento->eventosEstado($idEstado);
?>	
<div class="span3 pull-left eventos">
    <?php  if ( !empty($rs))  :?>
        <div class="tabular-center"><legend>Pr&oacute;ximos Eventos</legend></div>
    <?php  endif; ?>
    <?php  foreach ($rs as $key => $value) : ?>
    	<?php $value=$value["Evento"];?>
        	<div class="tabular">
            <?php
                    $url=$this->Html->url(array("controller" =>"eventosCan","action" => "index","?"=>"idEvento=$value[evento_cve]"));                                    
                    echo $this->Html->link($value['fecha_ini_'],$url,array("class" => "btn btn_color strong"));
                    echo $this->Html->link($value['evento_nombre'],$url,array("class" => "strong"));

            ?>                        
        	</div><br>

    <?php endforeach; ?>
<!--<div class="tabular"><img src="/img/face.png" width="306" height="48"></div>-->
</div>