
<?php 
	$count= count( $this->data[$name_model]) ;

	if("primera"==$action){
		$count=$ini_add_form;
	}


	$candidato_cve=$this->data['Candidato']['candidato_cve'] ;



	$form_begin=  "primera"!=$action? "<div  class='formulario $name_template' data-form='$name_model' > ". $this->Form->create($name_model,  array( 'url'=>  array('controller'=>'Candidato','action' => 'guardar_actualizar_hasmany/'.$name_model ),
			        "class"=>'form-horizontal well save',
			        'data-component' => 'validationform ajaxform' 
			         ) ) :"";

	$form_end= "primera"!=$action?  $this->Form->submit("Guardar", array ("class"=>'btn_color pull-right',"div"=>array("class"=>'form-actions'))). "<input type='hidden' value='0' name='data[multiple]' />".
							$this->Form->end()."</div>":"" ;


	$button_delete="";
		 if ("primera"!=$action ){
		 	$button_delete="<p class=\" tool pull-right\" >". 
				"<button  class=\" btn_color remove\"  title=\"Eliminar Referencia $title \" ><i class=\"icon-remove\"> </i> </button>".		
			"</p>";
		 }
			

?>

<div class="work_area" data-template="<?=$name_template?>"  data-max="<?=$max_item?>"  data-component="workarea">
	<div class="agregados clearfix">

		<?php 
		$i=0;
		while ($i< $count):  ?>								
			<?=$form_begin ?>			
				<?php 
					if($i>0){						
						echo $button_delete ;
					}
					 echo $this->element($route_view,array ("i"=>$i,"count"=>$count ,
					"candidato_cve"=>$candidato_cve,"action"=>$action,"name_model"=>$name_model  )) ; 
					$i++;
				?>

			<?=$form_end?>

	<?php endwhile; ?>
		
	</div>


		<?php if("primera"!=$action): ?>

		  <a href="#" class="add"><i class="icon-plus"></i>&nbsp;&nbsp;&nbsp; <?=$title ?>  </a>&nbsp;(Sólo se pueden agregar <?=$max_item?> registros como m&aacute;ximo)
			
		<?php endif; ?>


	<?php if("primera"!=$action ) :?>
		<div class="template" style="display:none"> 
			<?=$form_begin   ?> 
				<?=$button_delete ?>
				<?=$this->element($route_view,array ("i"=>$i,"count"=>$count,"candidato_cve"=>$candidato_cve,"action"=>$action,"name_model"=>$name_model  ))  ?>			
	
		 <?= $form_end ?> 
			
		</div>
	<?php endif; ?>		
	<input class="count_register "  type="hidden" id="count" value="<?=$i?>" /> 


	
</div>