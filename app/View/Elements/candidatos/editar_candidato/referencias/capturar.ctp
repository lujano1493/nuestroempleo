
<div  id="form_referencias" style="display:none" class="formulario">
	<form id="referencias"  >
		<input type="hidden" id="index_row" value="-1"  class='no_clear' />  				
		<input type="hidden" name="data[Options][target]" id="target" value="lista_referencias"  class='no_clear' />  				
		<input type="hidden" name="config_form" id="config_form" onchange="configurar_form_referencias(this);"  class='no_clear' />  		
		<div class="row-fluid"> <div class="span12"> </div> </div>	
		<div class="row-fluid">	
	
			<div class="span3"> </div>
	
			<div class='span4 '>
				<?php 				
	
				echo $this->form->input('Referencia.clave',array( 
															'id'=>'clave',
															'type'=> 'hidden')) ;  
		
			
				echo $this->form->input('Referencia.nombre',array( 
															'id'=>'nombre',															
															'type'=> 'text',
															'class'=>'input-large ',		
															'onblur'=>'mayus(this)',
															'label'=>array ("class"=>"label_","text"=>"Nombre de la Referencia*:"),	
															'div' =>false)) ;  											
				?>
			</div>
		

															
		</div>
		<div class="row-fluid">	
			<div class="span2"> </div>
			
			<?php
			echo $this->form->input('Referencia.correo',array( 
															'id'=>'correo',
															'type'=> 'text',
															'class'=>'input-medium ',																				
															'label'=>array ("class"=>"label_","text"=>"Correo Electrónico*:"),	
															'div' => array ("class"=>"span4 " ))) ;

			
			
					echo $this->form->input('Referencia.telefono',array( 
															'id'=>'telefono',
															'type'=> 'text',
															'class'=>'input-medium ',
															 'label'=>array ("class"=>"label_","text"=>"Teléfono:"),	
															'div' => array ("class"=>"span4 " ))) ; 
															
			
				
			?>
			
		</div>
		<div class="row-fluid"> 
				<div class="span2"> </div>
				
					<?php
						echo $this->form->input('Referencia.tipo',array( 
															'id'=>'tipo',
															'type'=> 'select',
															'options'=>$tipo_rel_arr,
															'class'=>'input-medium ',																				
															'label'=>array ("class"=>"label_","text"=>"Tipo de Relación*:"),	
															'div' => array ("class"=>"span4 " ))) ;

			
			
						echo $this->form->input('Referencia.anio',array( 
															'id'=>'anio',
															'type'=> 'select',
															'options'=>array (""=>"Selecciona ..." ,"1"=>"1 a 5 años","2"=>"5 a 10 años","3"=>"más de 10 años"),
															'class'=>'input-medium ',
															 'label'=>array ("class"=>"label_","text"=>"Años de Conocerlo:"),	
															'div' => array ("class"=>"span4 " ))) ; 
				
					?>	
				
		
		</div>
		
		<div class="row-floid">
			<div class="span12"> </div>
		</div>
	
		<div class="row-floid">
			<div class="span1"> </div>
			<div class="span6"> <label class="label_">Envía una encuesta a tu contacto para validar tus referencias </label>  </div>
			<div class="span4"> <button class="btn enviar_correo" > Enviar </button>  </div>
			<div class="span1"> </div>
		</div>
		
		<div class="row-floid">
			<div class="span12"> </div>
		</div>
		
	</form>
	
	
	
	<div class="row-fluid">		
		<div class="span2"> </div>		
		<div class="span3" id="informacion">		
		</div>
		<div class="span3">
			
				<button class="btn guardar"  >Guardar</button> 
				<button class="btn cancelar"  >Cancelar</button> 
			</div>
			<div class="span3" id="load"> </div>
			<div  class="span1"> </div>
		
			
	</div>
</div>