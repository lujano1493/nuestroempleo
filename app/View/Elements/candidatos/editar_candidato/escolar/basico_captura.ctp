<div  id="form_escolar_b" style="display:none" class="formulario" ><form id="escolar_b" >	<input type="hidden" id="index_row" value="-1"  class='no_clear' />  					<input type="hidden" name="data[Options][target]" id="target" value="lista_form_escolar_b"  class='no_clear' />  					<input type="hidden" name="config_form" id="config_form" onchange="configurar_form_basico(this);"  class='no_clear' />  			<div class="row-fluid"> <div class="span12"> <label class="title">Educación Basica  </label> </div> </div>		<div class="row-fluid">				<div  class="span1"> </div>			<?php 								echo $this->form->input('Escolar.Escolar.escper_cve',array( 															'id'=>'escper_cve',															'type'=> 'hidden')) ;  			echo $this->form->input('Escolar.Escolar.persona_cve',array( 															'id'=>'persona_cve',															'type'=> 'hidden')) ;  																		echo $this->form->input('Escolar.Escolar.escper_nivel',array( 															'id'=>'escper_nivel',																														'type'=> 'select',															'class'=>'input-medium escper_nivel_change',															'options'=> $escper_cve_arr_b ,															'label'=>array ("class"=>"label_","text"=>"Nivel*:"),																'div' => array ("class"=>"span3 " ))) ;  																																	echo $this->form->input('Escolar.Escolar.escper_institucion',array( 															'id'=>'escper_institucion',															'type'=> 'text',															'class'=>'input-medium ',																				'onblur'=>'mayus(this);',															 'label'=>array ("class"=>"label_","text"=>"Institución*:"),																'div' => array ("class"=>"span3 " ))) ;																		echo $this->form->input('Escolar.Escolar.escper_lugar',array( 															'id'=>'escper_lugar',															'type'=> 'text',															'onblur'=>'mayus(this);',															'class'=>'input-medium ',															 'label'=>array ("class"=>"label_","text"=>"Lugar*:"),																'div' => array ("class"=>"span3 " ))) ; 																														?>				<div  class="span2"> </div>	</div>	<div class="row-floid"> <div class="span12"> </div> </div>	<div class="row-fluid">			<div class="span1"> </div>						<?php 				echo $this->form->input('Escolar.Escolar.escper_gmc',array( 															'id'=>'escper_gmc',															'type'=> 'select',															'class'=>'input-medium ',															'options'=> $escper_gmc_arr_b ,																	'label'=>array ("class"=>"label_","text"=>"	Grado Máximo Cursado:"),																		'div' => array ("class"=>"span3 ")																							)) ;  							?>			<div class="span3 ">			<label class="label_">Titulado: </label>				<?php 						echo  $this->form->input("Escolar.Escolar.escper_titulado_h", array ("id"=>'escper_titulado',"type"=>'hidden', 'class'=>'radio_change'));				echo $this->form->input('Escolar.Escolar.escper_titulado',array( 															'id'=>'escper_titulado',															'type'=> 'radio',															'legend' => false,															'div' =>array ("class"=>"radio_"),															'class'=>'input-medium ',															'options'=> $escper_titulado_array)) ;  						?>			</div>						<div  class="span3 " >				<?php					echo $this->form->input('Escolar.Escolar.escper_especialidad',array( 															'id'=>'escper_especialidad',															'type'=> 'text',																														'class'=>'input-medium ',															'onblur'=>'mayus(this);',															 'label'=>array ("class"=>"label_","text"=>"Especialidad*:"),																'div' => array ("style"=>"display:none" ))) ; 				?>			</div>			<div  class="span2"> </div>					</div>		<input id="tipo" value="null" type="hidden"  /> </form><div class="row-fluid">			<div class="span2"> </div>			<div class="span3" id="informacion">			</div>	<div class="span3">							<button class="btn guardar"  >Guardar</button> 				<button class="btn cancelar"  >Cancelar</button> 			</div>			<div class="span3" id="load"> </div>			<div  class="span1"> </div>					</div></div>