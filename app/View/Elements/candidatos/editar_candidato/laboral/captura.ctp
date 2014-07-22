
<div  id="form_exp_laboral" style="display:none" class="formulario" >
	<form id="exp_laboral" >
		<input type="hidden" id="index_row" value="-1"  class='no_clear' />  				
		<input type="hidden" name="data[Options][target]" id="target" value="lista_exp_laboral"  class='no_clear' />  				
		<input type="hidden" name="config_form" id="config_form" onchange="configurar_form_laboral(this);"  class='no_clear' />  		
		<div class="row-fluid"> <div class="span12"> <label class="title">Experiencia Laboral </label> </div> </div>	
		<div class="row-fluid">	
	
			<div class="span1"> </div>
	
			<div class='span3 '>
				<?php 				
				echo $this->form->input('Laboral.ExpLabPer.explab_cve',array( 
															'id'=>'explab_cve',
															'type'=> 'hidden')) ;  
				echo $this->form->input('Laboral.ExpLabPer.persona_cve',array( 
															'id'=>'persona_cve',
															'type'=> 'hidden')) ;  
		
			
				echo $this->form->input('Laboral.ExpLabPer.explab_empresa',array( 
															'id'=>'explab_empresa',															
															'type'=> 'text',
															'onblur'=>'mayus(this);',
															'class'=>'input-medium ',															
															'label'=>array ("class"=>"label_","text"=>"Nombre Empresa*:"),	
															'div' =>false)) ;  											
				?>
			</div>
			<?php
			echo $this->form->input('Laboral.ExpLabPer.explab_jefe',array( 
															'id'=>'explab_jefe',
															'type'=> 'text',
															'class'=>'input-medium ',					
															'onblur'=>'mayus(this);',
															'label'=>array ("class"=>"label_","text"=>"Nombre de Jefe Inmediato*:"),	
															'div' => array ("class"=>"span3 " ))) ;

															
			echo $this->form->input('Laboral.ExpLabPer.explab_dir',array( 
															'id'=>'explab_dir',
															'type'=> 'text',
															'onblur'=>'mayus(this);',
															'class'=>'input-medium ',
															 'label'=>array ("class"=>"label_","text"=>"Dirección*:"),	
															'div' => array ("class"=>"span3 " ))) ; 
			
					
		
															

															?>	

															
		</div>
		<div class="row-fluid">	
			<div class="span1"> </div>
			<?php 
			
			
					echo $this->form->input('Laboral.ExpLabPer.explab_tel',array( 
															'id'=>'explab_tel',
															'type'=> 'text',
															'class'=>'input-medium ',
															 'label'=>array ("class"=>"label_","text"=>"Teléfono*:"),	
															'div' => array ("class"=>"span3 " ))) ; 
															
			
				echo $this->form->input('Laboral.ExpLabPer.explab_fecini',array( 
															'id'=>'explab_fecini',
															'type'=> 'text',
															'class'=>'input-medium input_date startdate',														
															'label'=>array ("class"=>"label_","text"=>"	Fecha de Inicio*:"),			
															'div' => array ("class"=>"span3 ")										
													)) ;  
				echo $this->form->input('Laboral.ExpLabPer.explab_fecter',array( 
															'id'=>'explab_fecter',
															'type'=> 'text',
															'class'=>'input-medium input_date',														
															'label'=>array ("class"=>"label_","text"=>"	Fecha de Termino*:"),			
															'div' => array ("class"=>"span3 ")										
													)) ;  
				
			?>
			
		</div>
		<div class="row-fluid"> 
				<div class="span1"> </div>
				<div class="span3">
					<div class="row-fluid"> 
						<div class="span12" >
							<label class="label_" >Último Sueldo </label>
						</div>
					</div>
					<div class="row-fluid"> 
						<?php echo  $this->form->input("Laboral.ExpLabPer.explab_sueldo_", array ("id"=>'explab_sueldo_',"type"=>'hidden', 'class'=>'radio_change')); ?>
						<div class="span12 radio_">
						
								<input type="checkbox" name="data[Laboral][ExpLabPer][explab_sueldo_]" value="0" id="explab_becario_" class="ult_sueldo">
								
							<label for="explab_sueldo_b" class="label_">Becario </label>
							
							<input type="checkbox" name="data[Laboral][ExpLabPer][explab_sueldo_]" value="1" id="explab_practicante_" class="ult_sueldo">
							
							<label for="explab_sueldo_b" class="label_">Practicante </label>
						
						</div>
					</div>
					<div class="row-fluid"> 
						<div class="span12 div_explab_sueldo " > 
							<div class="row-fluid"> 
								<div class="span12" >
									<label> </label>
								</div>
							</div>
							
							
							<div class="row-fluid"> 
								<div class="span12" > 
									<?php 
								echo $this->form->input('Laboral.ExpLabPer.explab_sueldo',array( 
															'id'=>'explab_sueldo',
															'type'=> 'text',
															'class'=>'input-small',														
															'label'=>array ("class"=>"label_",'style'=>'display: inline;',"text"=>"$"),			
															'div' => false										
													)) ;  
													
													
								echo $this->form->input('Laboral.ExpLabPer.pais_cve',array( 
															'id'=>'pais_cve',
															'type'=> 'select',
															'class'=>'input-small ',
															'options'=> array ("1"=>"MXN","50"=>"USD"  ) ,		
															'label'=>false,			
															'div' => false									
													)) ;  
							?>
								</div>
							</div>
							
							
						</div>
						
					</div>
				</div>
				
				<div class="span3">  
				
					
					<div class="row-fluid"> 
						<div class="span12 ">	
								<label class="label_" >Perteneció a algún Sindicato </label>
							
							<?php 		
								echo  $this->form->input("Laboral.ExpLabPer.explab_sindi_h", array ("id"=>'explab_sindi_',"type"=>'hidden', 'class'=>'radio_change'));
								echo $this->form->input('Laboral.ExpLabPer.explab_sindi_',array( 
															'id'=>'explab_sindi_',
															'type'=> 'radio',
															'legend' => false,
															'div' =>array ("class"=>"span12 radio_"),
															'class'=>'input-medium sindicato',
															'options'=> array ("S"=>"Sí","N"=>"No"))) ;  		
							?>
						
						</div>
					</div>
					
					<div class="row-fluid"> 
						<div class="row-fluid"> 
							<div class="span12 ">	
							</div>
						</div>
						<div class="row-fluid"> 
							<div class="span12 div_sindicato" style="display:none">					
								<?php 		
									echo $this->form->input('Laboral.ExpLabPer.sindi_cve',array( 
															'id'=>'sindi_cve',
															'type'=> 'select',
															'options'=>$sindi_cve_arr,
															'class'=>'input-medium',														
															'label'=>array ("class"=>"label_","text"=>"Sindicato:"),			
															'div' => array ("class"=>"span3 ")										
													)) ; 	
								?>
							</div>
						
						</div>
					</div>
					
				
				</div>
				
				<?php 
					echo $this->form->input('Laboral.ExpLabPer.girocia_cve',array( 
															'id'=>'girocia_cve',
															'type'=> 'select',
															'options'=>$girocia_cve_arr,
															'class'=>'input-large',														
															'label'=>array ("class"=>"label_","text"=>"	Giro de Compañía*:"),			
															'div' => array ("class"=>"span4 ")										
													)) ; 
				?>
				
				
				<div class="span1"> </div>
				
				
				
		
		</div>
		<div class="row-fluid"> <div class="span12"> </div> </div>
		<div class="row-fluid"> 
				<div class="span1"> </div>
				<div class="span10">
					<div class="row-fluid"> 
						<div class="span3"> 
							<label class="label_"> Prestaciones </label>
						</div>
						
						<div class="span9"> 
							<div class="row-fluid radio_">  
								<div class="span4"> 
									<?php 
										echo $this->form->checkbox('Laboral.ExpLabPer.explab_pvd', 
																array('value'=>'1','id'=>'explab_pvd','class'=>'change_check_box' ,'hiddenField' => false));
									?>
									<label for="explab_pvd" class="label_">Vales de Despensa </label>
								
								</div>
								<div class="span4"> 
									<?php 
										echo $this->form->checkbox('Laboral.ExpLabPer.explab_p', 
																array('value'=>'1','id'=>'explab_p' ,'class'=>'change_check_box','hiddenField' => false));
									?>
									<label for="explab_p" class="label_">Vales de Gasolina </label>
								
								</div>
								<div class="span4"> 
									<?php 
										echo $this->form->checkbox('Laboral.ExpLabPer.explab_ptr', 
																array('value'=>'1','id'=>'explab_ptr','class'=>'change_check_box' ,'hiddenField' => false));
									?>
									<label for="explab_ptr" class="label_">Ticket de Restaurant </label>
								
								</div>
								
							
							</div>
							
							<div class="row-fluid radio_">  
								<div class="span4"> 
									<?php 
										echo $this->form->checkbox('Laboral.ExpLabPer.explab_pfa', 
																array('value'=>'1','id'=>'explab_pfa','class'=>'change_check_box' ,'hiddenField' => false));
									?>
									<label for="explab_pvd" class="label_">Fodo de Ahorro </label>
								
								</div>
								<div class="span4"> 
									<?php 
										echo $this->form->checkbox('Laboral.ExpLabPer.explab_pgmm', 
																array('value'=>'1','id'=>'explab_pgmm','class'=>'change_check_box' ,'hiddenField' => false));
									?>
									<label for="explab_gmm" class="label_">Gastos Médicos Mayores</label>
								
								</div>
								<div class="span4"> 
									<?php 
											echo $this->form->input('Laboral.ExpLabPer.explab_otros',array( 
															'id'=>'explab_otros',
															'type'=> 'text',
															'class'=>'input-medium',														
															'label'=>array ("class"=>"label_","text"=>"Otros:"),			
															'div' => false										
													)) ;  
									?>
									
								
								</div>
								
							
							</div>
							
							
							
							
						</div>
					</div>
					
				</div>
				<div class="span1"></div>
			
		</div>
		
		<div class="row-fluid">  
			<div class="span1"> </div>
			<div class="span10"> 
				<div class="row-fluid"> 
					<div class="span6 "> 
							<?php 
											echo $this->form->input('Laboral.ExpLabPer.explab_puestos',array( 
															'id'=>'explab_puestos',
															'type'=> 'textarea',
															'class'=>'',														
															'label'=>array ("class"=>"label_","text"=>"Puestos Desempeñados:"),			
															'div' => false										
													)) ;  
									?>
					
					
					</div>
					<div class="span6 "> 
							<?php 
											echo $this->form->input('Laboral.ExpLabPer.explab_mds',array( 
															'id'=>'explab_mds',
															'type'=> 'textarea',
															'class'=>'',														
															'label'=>array ("class"=>"label_","text"=>"Motivos de Separación:"),			
															'div' => false										
													)) ;  
									?>
					</div>
				</div>
			
			</div>
			
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