<?php  
	$value_ini=array();
	if(!empty($this->data['IdiomaCan'] )){
		$val_arr=array();
		foreach ($this->data['IdiomaCan']  as $valor) {		

			$value_ini[]= array("idioma_cve"=>$valor['Idioma']['idioma_cve'],"idioma_nom"=>$valor['Idioma']['idioma_nom'],"ic_nivel"=>$valor['ic_nivel']);
		}

	}

	$option_magics= json_encode( array("displayField"=>"idioma_nom",
					"valueField"=>"idioma_cve",
					"emptyText"=> 'Ingresa un idioma',
					"required" =>  "primera" != $action ? true:false  ,
					"messageValidation" =>"Ingresa al menos un idioma",
					"width" => ("primera"==$action ) ? 320 :218   ,
					"data"=> $list['idiomas'],
					"value_ini"=> $value_ini,
					"maxSelection"=> 6,
					"selectionPosition"=>'bottom',
					"selectionStacked"=> true,
					"element_extra"=>array(array("id"=>"idioma_cve","type"=>"hidden","name"=>"data[IdiomaCan]"),
								   array("id"=>"ic_nivel","type"=>"select","name"=>"data[IdiomaCan]","options"=>$list['ic_nivel']   ))
		));

	$form_begin= "primera"!=$action?  "<div class='formulario idiomas' > ".$this->Form->create("IdiomaCan",  array( 'url'=>  array('controller'=>'Candidato','action' => 'guardar_lista/IdiomaCan'),
			        "class"=>'form-horizontal well',
			        'data-component' => 'validationform ajaxform' 
			         ) )     :"";
	$form_end=  "primera"!=$action? $this->Form->submit("Guardar", array ("class"=>'btn_color pull-right',"div"=>array("class"=>'form-actions'))). $this->Form->end() ."</div>":"";
?>

<?=$form_begin?>

	
<div class="alert-container clearfix">
  <div class="alert alert-info fade in popup" data-alert="alert">
    <i class=" icon-info-sign icon-2x"></i>
      Selecciona idioma y el dominio que tienes de éste.</div>
</div>

	<fieldset>
			<h4>Idiomas</h4>
	   <?= $this->Form->input('idiomas', array(
	        'label'=>false,
	        'div'=>  array('class'=>'controls'),
	        'data-magicsuggest-options'=> $option_magics,
	        'class'=>' input-medium-formulario magicsuggest'));  
        ?>
	</fieldset>
<?=$form_end?>
