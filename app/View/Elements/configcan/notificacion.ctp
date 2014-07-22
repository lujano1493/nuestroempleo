<div class="row-fluid">
	<div class="span5 pull-left left">
		<h5>Notificaciones</h5>


		<?php    
			// sacamos los datos
			$configcan=$this->data['ConfigCan'];

			foreach ($list['config_cve'] as $key => $value) {
				$checked= Funciones::array_search($configcan,$key,'config_cve') ;

			   echo $this->Form->input("ConfigCan.".$key.".config_cve" , array(
			   			'id' => "config_cve$key",
			  			'label' =>  "<label class='checkbox'  for='config_cve$key'  > $value  </label>" ,
			  			'value' => $key,
			  			'hiddenField'=>false,
			  			'type' => 'checkbox',
			  			'checked'=> $checked		
		     		));
			  	
			}  
		?>
	</div>

	<div class="span6 pull-right left">
	     <h5>Medios de contacto</h5>
		<?php    
			$configcan=$this->data['ConfigCan'];

			foreach ( $list['contac_cve'] as $key => $value) {
				$checked= Funciones::array_search($configcan,$key,'config_cve') ;

			   echo $this->Form->input("ConfigCan.".$key.".config_cve" , array(
			   			'id' => "contac_cve$key",
			  			'label' =>  "<label class='checkbox'  for='contac_cve$key'  > $value  </label>" ,
			  			'value' => $key,
			  			'hiddenField'=>false,
			  			'type' => 'checkbox',
			  			'checked'=> $checked		
		     		));
			  	
			}  
		?>

	</div>
</div>
