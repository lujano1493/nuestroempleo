
<div id="referencia_" class="view_" >
		<div class="row-fluid"> 
			<div class="span2"> </div>
			<div class="span8">
						
				<div class="row-fluid"> 
					<div class="span6 label_">
					
					</div>
					<div class="span6 formulario">
						<input id="target" type="hidden" value="form_referencias"  /> 
						<input id="event_add" type="hidden" onchange=""   /> 
						<button id="agregar_referencia" class="btn agregar"  > Agregar  </button>
					</div>
				</div>
			
				
				
				
			</div>
			<div class="span2"> 
			
			</div>
		
		</div>
		
		<div class="row-fluid " id="captura" > 			
				<div id="capturas"> 
					
				
				</div>
				<div id="model">
				<?php echo $this->element('Candidatos/editar_candidato/referencias/capturar'); ?>	

				</div>
		</div>
		
		
		<div class="row-fluid" >
			<div class="agregado" id="agregados">  </div>
	
		</div>
		<div class="row-fluid " id="ajax">

		</div>

		<div class="row-fluid">
			<div class="span12"> </div>
		</div>
	
</div>