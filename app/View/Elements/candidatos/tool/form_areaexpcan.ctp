<?php  
	$value_ini=array();

	if(!empty($this->data['AreaExpCan'] )){
		$val_arr=array();
		foreach ($this->data['AreaExpCan']  as $valor) {		

			$value_ini[]= array("area_cve"=>$valor['AreaInt']['area_cve'],"area_nom"=>$valor['AreaInt']['area_nom'],"tiempo_cve"=>$valor['tiempo_cve']);
		}

	}
	$option_magics= array("displayField"=>"area_nom",
					"valueField"=>"area_cve",
					"emptyText"=> 'Ingresa Áreas de experiencia',
					"data"=> $list['area_int'],
					"value_ini"=> $value_ini,
					"width" =>500,
					"maxSelection"=> 3,					 
					"selectionPosition"=>'bottom',
					"selectionStacked"=> true,
					"required"=>true,
					"messageValidation"=>"Elige un Área de experiencia",
					"element_extra"=>array(array("id"=>"area_cve","type"=>"hidden","name"=>"data[AreaExpCan]"),
								   array("id"=>"tiempo_cve","type"=>"select","name"=>"data[AreaExpCan]","options"=>$list['tiempo_cve']   ))
		);

		if($this->action=="actualizar"){
				$option_magics["maxDropHeight"]=120;

		}
	$option_magics=json_encode($option_magics);
	$form_begin= "primera"!=$action? "<div class='formulario areas_experiencia' > ".$this->Form->create("AreaExpCan",  array( 'url'=>  array('controller'=>'Candidato','action' => 'guardar_lista/AreaExpCan'),
			        "class"=>'form-horizontal well',
			        'data-component' => 'validationform ajaxform' 
			         ) )     :"";
	$form_end=  "primera"!=$action? $this->Form->submit("Guardar", array ("class"=>'btn_color pull-right',"div"=>array("class"=>'form-actions'))). $this->Form->end()."</div>":"";
?>

<?=$form_begin?>
	<fieldset>
			<h4>Áreas de Experiencia Laboral</h4>
	   <?= $this->Form->input('areas_experiencia', array(
	        'label'=>false,
	        'div'=>  array('class'=>'controls'),
	        'data-magicsuggest-options'=> $option_magics,
	        'class'=>' input-medium-formulario magicsuggest'));  
        ?>
	</fieldset>
<?=$form_end?>
