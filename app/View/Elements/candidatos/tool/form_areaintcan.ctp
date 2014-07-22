<?php  
	$value_ini=array();
	if(!empty($this->data['AreaIntCan'] )){
		foreach ($this->data['AreaIntCan']  as $valor) {		

			$value_ini[]= array("area_cve"=>$valor['AreaInt']['area_cve'],"area_nom"=>$valor['AreaInt']['area_nom'] );
		}

	}

	$option_magics= json_encode( array("displayField"=>"area_nom",
					"valueField"=>"area_cve",
					"emptyText"=> 'Ingresa areas de interés',				
					"data"=> $list['area_int'],
					"required" => true,
					"messageValidation"=>"Elige al menos un érea de interés",
					"value_ini"=> $value_ini,
					"selectionPosition"=>'bottom',
					"width" =>("primera"==$action)?320 :260 ,
					"selectionStacked"=> true,
					"maxSelection"=> 3,
					"element_extra"=>array(array("id"=>"area_cve","type"=>"hidden","name"=>"data[AreaIntCan]"))
		));

	$form_begin= "primera"!=$action? "<div class='formulario areainteres' > ".$this->Form->create("AreaIntCan",  array( 'url'=>  array('controller'=>'Candidato','action' => 'guardar_lista/AreaIntCan'),
			        "class"=>'form-horizontal well',
			        'data-component' => 'validationform ajaxform' 
			         ) )     :"";
	$form_end=  "primera"!=$action?  $this->Form->submit("Guardar", array ("class"=>'btn_color pull-right',"div"=>array("class"=>'form-actions'))). $this->Form->end()."</div>":"";
?>

<?=$form_begin?>

<div class="alert-container clearfix">
  <div class="alert alert-info fade in popup" data-alert="alert">
    <i class=" icon-info-sign icon-2x"></i>
     Ingresa otro sector en el que te gustaría incursionar.</div>
</div>

	<fieldset>
		<h4  data-placement="top" >Áreas de Interés</h4>
	   <?= $this->Form->input('areas_interes', array(
	        'label'=>false,
	        'id' => "formAreasInt01",
	        'div'=>  array('class'=>'controls'),
	        'data-magicsuggest-options'=> $option_magics,
	        'class'=>' input-medium-formulario magicsuggest'));  
        ?>
	</fieldset>
<?=$form_end?>
