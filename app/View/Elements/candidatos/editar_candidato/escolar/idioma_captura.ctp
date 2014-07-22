
<div  id="form_escolar_i" style="display:none" class="formulario">
<form id="escolar_i"  >
	<input type="hidden" id="index_row" value="-1"  class='no_clear' />  				
	<input type="hidden" name="data[Options][target]" id="target" value="lista_form_escolar_i"  class='no_clear' />  
	<input type="hidden" name="config_form" id="config_form" onchange="configurar_form_idioma(this);"  class='no_clear' />  		
	<div class="row-fluid"> <div class="span12"> <label class="title">Idiomas  </label> </div> </div>	
	<div class="row-fluid">	
			<div  class="span1"> </div>
			<?php 				
				echo $this->form->input('Escolar.IdiomaPer.persona_cve',array( 
															'id'=>'persona_cve',
															'type'=> 'hidden')) ;  
															
			echo $this->form->input('Escolar.IdiomaPer.idiper_cve',array( 
															'id'=>'idiper_cve',
															'type'=> 'hidden')) ;  
															
			echo $this->form->input('Escolar.IdiomaPer.idioma_cve',array( 
															'id'=>'idioma_cve',															
															'type'=> 'select',
															'options'=>$idioma_cve_arr,														
															'class'=>'input-medium',														
															'label'=>array ("class"=>"label_","text"=>"Idioma*:"),	
															'div' => array ("class"=>"span3 " ))) ;  															
															
			echo $this->form->input('Escolar.IdiomaPer.idiper_lee',array( 
															'id'=>'idiper_lee',
															'type'=> 'text',
															'class'=>'input-small ',					
															'onblur'=>'mayus(this);',
															 'label'=>array ("class"=>"label_","text"=>"Lectura(%)*:"),	
															'div' => array ("class"=>"span2 " ))) ;

															
			echo $this->form->input('Escolar.IdiomaPer.idiper_esc',array( 
															'id'=>'idiper_esc',
															'type'=> 'text',
															'class'=>'input-small ',					
															'onblur'=>'mayus(this);',
															 'label'=>array ("class"=>"label_","text"=>"Escritura(%)*:"),	
															'div' => array ("class"=>"span2 " ))) ;
															
															

			echo $this->form->input('Escolar.IdiomaPer.idiper_con',array( 
															'id'=>'idiper_con',
															'type'=> 'text',
															'class'=>'input-small ',					
															'onblur'=>'mayus(this);',
															 'label'=>array ("class"=>"label_","text"=>"Comprención(%)*:"),	
															'div' => array ("class"=>"span2 " ))) ;
			
			
															?>	
			<div  class="span2"> </div>
	</div>

		
		
		
		<input id="tipo" value="null" type="hidden"  /> 
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