
<?php		
		$result=	Funciones::getStatusGraf($this->data['GrafCan'],$authUser['candidato_cve']);

?>
	<div class="chart status-candidato" >
		<?=$this->Html->link(
					"status",
					array(
							"controller" => "candidato",
							"action" => "grafica"
						),
					array(
							"style" => "display:none",
							"id" =>"status-cv"
					)
		)?>		
	     <div class="percentage tabular center" data-percent="<?=$result['total_percent']?>" data-bar-color="<?=$result['color']?>">
	     	<i class="icon-file"></i>&nbsp;<span><?=$result['total_percent']?></span>%
	     </div>
	     <!--<div class="left">Estatus de Mi currículum</div>-->
	     <div  class="text"style="text-align:left;margin-left:-8%">
	     		<?=$result['text']?>

	     </div>
	</div>


