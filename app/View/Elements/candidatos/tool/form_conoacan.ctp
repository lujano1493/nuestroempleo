<?php  
	$value_ini=array();
	if(!empty($this->data['ConoaCan'] )){
		$val_arr=array();
		foreach ($this->data['ConoaCan']  as $valor) {		

			$value_ini[]= array("conoc_cve"=>$valor['conoc_cve'],"conoc_descrip"=>$valor['conoc_descrip']);
		}

	}

	$option_magics= json_encode( 
			array(
					"displayField"=>"conoc_descrip",
					"valueField"=>"conoc_cve",
					"emptyText"=> 'Ingresa una descripción',
					"required" =>   true  ,
					"messageValidation" =>"Ingresa una descripción",
					"width" => 500   ,		
					 "maxSuggestions"=> 0,			
					"expandOnFocus"=> false,		
					"hideTrigger"=> true,
					'expanded' => false,	
					"cls"=> 'free-entity',
					"maxEntryLength" => 26,
					"maxSuggestions" => 2,
					"allowFreeEntries"=> true,
					"value_ini"=> $value_ini,
					"maxSelection"=> 3,
					"selectionPosition"=>'bottom',
					"selectionStacked"=> true,
					"element_extra"=>array(array("id"=>"conoc_descrip","type"=>"hidden","name"=>"data[ConoaCan]"  ))
		));

	$form_begin= "<div class='formulario conocimientos' > ".$this->Form->create("ConoaCan",  array(
					'url'=>  array('controller'=>'Candidato','action' => 'guardar_lista/ConoaCan'),
			        "class"=>'form-horizontal well',
			        'data-component' => 'validationform ajaxform' 
			         ) );
	$form_end=  $this->Form->submit("Guardar", array ("class"=>'btn_color pull-right',"div"=>array("class"=>'form-actions'))). $this->Form->end() ."</div>";
?>

<?=$form_begin?>

	
<div class="alert-container clearfix">

</div>

	<fieldset>
			<h4>Conocimientos</h4>
	   <?= $this->Form->input('conocimientos', array(
	        'label'=>false,
	        'div'=>  array('class'=>'controls'),
	        'data-magicsuggest-options'=> $option_magics,
	        'class'=>' input-medium-formulario magicsuggest'));  
        ?>
	</fieldset>
<?=$form_end?>
