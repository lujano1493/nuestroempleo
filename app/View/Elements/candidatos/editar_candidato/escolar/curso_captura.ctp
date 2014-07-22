
<div  id="form_escolar_c" style="display:none"  class="formulario">
<form id="escolar_c"  >
	<input type="hidden" id="index_row" value="-1"  class='no_clear' />  				
	<input type="hidden" name="data[Options][target]" id="target" value="lista_form_escolar_c"  class='no_clear' />  	
	<input type="hidden" name="config_form" id="config_form" onchange="configurar_form_curso(this);"  class='no_clear' />  	
	<div class="row-fluid"> <div class="span12"> <label class="title">Cursos  </label> </div> </div>	
	<div class="row-fluid">	
			<div  class="span1"> </div>
			<?php 				
				echo $this->form->input('Escolar.Curso.curper_cve',array( 
															'id'=>'curper_cve',
															'type'=> 'hidden')) ;  
															
			echo $this->form->input('Escolar.Curso.persona_cve',array( 
															'id'=>'persona_cve',
															'type'=> 'hidden')) ;  
															
			echo $this->form->input('Escolar.Curso.curper_tipo',array( 
															'id'=>'curper_tipo',															
															'type'=> 'select',
															'options'=>$curper_tipo_arr,
															'onblur'=>'mayus(this);',
															'class'=>'input-medium',														
															'label'=>array ("class"=>"label_","text"=>"Tipo*:"),	
															'div' => array ("class"=>"span3 " ))) ;  															
															
			echo $this->form->input('Escolar.Curso.curper_descrip',array( 
															'id'=>'curper_descrip',
															'type'=> 'text',
															'class'=>'input-medium ',					
															'onblur'=>'mayus(this);',
															 'label'=>array ("class"=>"label_","text"=>"Descripción*:"),	
															'div' => array ("class"=>"span3 " ))) ;

															
			echo $this->form->input('Escolar.Curso.curper_obj',array( 
															'id'=>'curper_obj',
															'type'=> 'text',
															'onblur'=>'mayus(this);',
															'class'=>'input-medium ',
															 'label'=>array ("class"=>"label_","text"=>"Objectivo*:"),	
															'div' => array ("class"=>"span3 " ))) ; 
															
															?>	
			<div  class="span2"> </div>
	</div>
	<div class="row-floid"> <div class="span12"> </div> </div>
	<div class="row-fluid">	
		<div class="span1"> </div>
			
			<?php 
				echo $this->form->input('Escolar.Curso.curper_fecini',array( 
															'id'=>'curper_fecini',
															'type'=> 'text',
															'class'=>'input-small input_date startdate',															
															'label'=>array ("class"=>"label_","text"=>"Fecha Inicial:"),			
															'div' => array ("class"=>"span2 ")										
													)) ;  
				
			?>
			
			<?php 
				echo $this->form->input('Escolar.Curso.curper_fecfin',array( 
															'id'=>'curper_fecfin',
															'type'=> 'text',
															'class'=>'input-small input_date enddate',													
															'label'=>array ("class"=>"label_","text"=>"Fecha Fin:*"),			
															'div' => array ("class"=>"span2 ")										
													)) ;  
				
			?>
			
				<?php 
				echo $this->form->input('Escolar.Curso.curper_intext',array( 
															'id'=>'curper_intext',
															'type'=> 'select',
															'options'=>$curper_intext_arr,
															'class'=>'input-medium ',													
															'label'=>array ("class"=>"label_","text"=>"Interno/externo:*"),			
															'div' => array ("class"=>"span3 ")										
													)) ;  
				
				
				
			?>
			
				<?php 
				echo $this->form->input('Escolar.Curso.curper_instructor',array( 
															'id'=>'curper_instructor',
															'type'=> 'text',
															'class'=>'input-medium ',													
															'label'=>array ("class"=>"label_","text"=>"Impartido por:*"),			
															'div' => array ("class"=>"span3 ")										
													)) ;  
				
			?>
			
			
			
			
			<div  class="span1"> </div>
			
		</div>
		
		
		<div class="row-fluid">	
			<div class="span3"> </div>
			
		<?php 
				echo $this->form->input('Escolar.Curso.curper_result',array( 
															'id'=>'curper_result',
															'type'=> 'select',
															'options'=>$curper_result_arr,
															'class'=>'input-medium ',													
															'label'=>array ("class"=>"label_","text"=>"Resultado:*"),			
															'div' => array ("class"=>"span3 ")										
													)) ;  
				
				
				
			?>
			<div  class="span3"> </div>
			
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