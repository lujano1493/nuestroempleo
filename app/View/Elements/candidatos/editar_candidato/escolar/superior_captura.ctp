
<div  id="form_escolar_s" style="display:none" class="formulario">
<form id="escolar_s"  >
	<input type="hidden" id="index_row" value="-1"  class='no_clear'  />  				
	<input type="hidden" name="data[Options][target]" id="target" value="lista_form_escolar_s"   class='no_clear' />  	
	<input type="hidden" name="config_form" id="config_form" onchange="configurar_form_superior(this);"  class='no_clear' />  		
	<div class="row-fluid"> <div class="span12"> <label class='title'>Estudios Superiores  </label> </div> </div>
	<div class="row-fluid">	
			<div  class="span1"> </div>
			<?php 				
				echo $this->form->input('Escolar.Escolar_S.escper_cve',array( 
															'id'=>'escper_cve',															
															'type'=> 'hidden')) ;  
			echo $this->form->input('Escolar.Escolar_S.persona_cve',array( 
															'id'=>'persona_cve',
															'type'=> 'hidden')) ;  
															
			echo $this->form->input('Escolar.Escolar_S.escper_nivel',array( 
															'id'=>'escper_nivel',															
															'type'=> 'hidden',
															'class'=>'no_clear',
															'value'=>'6'
															)) ;  
			
			echo $this->form->input('Escolar.Escolar_S.change_select',array( 
															'id'=>'change_select',															
															'type'=> 'hidden',
															'class'=>'change_select_all',
															'value'=>'6'
															)) ;  
															
			echo $this->form->input('Escolar.EscCarArea.carea_cve',array( 
															'id'=>'carea_cve',															
															'type'=> 'select',
															'style'=> 'font-size:10px',
															'class'=>'input-medium select_change_ajax',
															'select_change'=>'cgen_cve',
															'options'=> $carea_cve_arr ,
															'label'=>array ("class"=>"label_","text"=>"Area General*:"),	
															'div' => array ("class"=>"span3 " ))) ;  
		echo $this->form->input('Escolar.EscCarGene.cgen_cve',array( 
															'id'=>'cgen_cve',															
															'type'=> 'select',
															'style'=> 'font-size:10px',
															'select_change'=>'cespe_cve',
															'class'=>'input-medium select_change_ajax',
															'options'=> $cgen_cve_arr ,
															'label'=>array ("class"=>"label_","text"=>"Carrera Genérica*:"),	
															'div' => array ("class"=>"span3 " ))) ; 
															
		echo $this->form->input('Escolar.Escolar_S.cespe_cve',array( 
															'id'=>'cespe_cve',															
															'type'=> 'select',
															'style'=> 'font-size:10px',
															'class'=>'input-medium',
															'options'=> $cespe_cve_arr ,
															'label'=>array ("class"=>"label_","text"=>"Carrera Específica*:"),	
															'div' => array ("class"=>"span3 " ))) ;  
															
															?>	
			<div  class="span2"> </div>
	</div>
	<div class="row-floid"> <div class="span12"> </div> </div>
	<div class="row-fluid">	
		<div class="span1"> </div>
			
			<?php 
				echo $this->form->input('Escolar.Escolar_S.escper_gmc',array( 
															'id'=>'escper_gmc',
															'type'=> 'select',
															'class'=>'input-medium ',
															'options'=> $escper_gmc_arr_s ,		
															'label'=>array ("class"=>"label_","text"=>"	Grado Máximo Cursado:"),			
															'div' => array ("class"=>"span3 ")										
													)) ;  
				echo $this->form->input('Escolar.Escolar_S.escper_institucion',array( 
															'id'=>'escper_institucion',
															'type'=> 'text',
															'class'=>'input-medium ',					
															'onblur'=>'mayus(this);',
															 'label'=>array ("class"=>"label_","text"=>"Institución*:"),	
															'div' => array ("class"=>"span3 " ))) ;
					
																
				echo $this->form->input('Escolar.Escolar_S.escper_lugar',array( 
															'id'=>'escper_lugar',
															'type'=> 'text',
															'onblur'=>'mayus(this);',
															'class'=>'input-medium ',
															 'label'=>array ("class"=>"label_","text"=>"Lugar*:"),	
															'div' => array ("class"=>"span3 " ))) ; 

				
			?>
			
	
			<div  class="span2"> </div>
			
		</div>
		<div class="row-fluid"> 
			<div class="span4"> </div>
			<div class="span3 ">
			<label class="label_">Titulado: </label>
				<?php 		
				echo  $this->form->input("Escolar.Escolar_S.escper_titulado_h", array ("id"=>'escper_titulado',"type"=>'hidden', 'class'=>'radio_change '));
				echo $this->form->input('Escolar.Escolar_S.escper_titulado',array( 
															'id'=>'escper_titulado',
															'type'=> 'radio',
															'legend' => false,
															'div' =>array ("class"=>"radio_"),
															'class'=>'input-medium ',
															'options'=> $escper_titulado_array)) ;  		
				?>
			</div>
			<div class="span5"> </div>
		
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



