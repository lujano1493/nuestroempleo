
<div id="escolar_" class="view_" >
		<div class="row-fluid"> 
			<div class="span2"> </div>
			<div class="span8">
						
				<div class="row-fluid"> 
					<div class="span6 label_">
						Educación Básica
					</div>
					<div class="span6 formulario">
						<input id="target" type="hidden" value="form_escolar_b"  /> 
						<button id="agregar_basico" class="btn agregar"  > Agregar  </button>
					</div>
				</div>
				<div class="row-fluid"> 
					<div class="span6 label_">
						Estudios Superiores
					</div>
					<div class="span6 formulario">
						<input id="target" type="hidden" value="form_escolar_s"  /> 
						<button id="agregar_sup" class="btn agregar"  > Agregar  </button>
					</div>
				</div>	
				<div class="row-fluid"> 
					<div class="span6 label_">
						Estudios de Posgrado
					</div>
					<div class="span6 formulario">
						<input id="target" type="hidden" value="form_escolar_p"  /> 
						<button id="agregar_pos" class="btn agregar"  > Agregar  </button>
					</div>
				</div>
						
				<div class="row-fluid"> 
					<div class="span6 label_">
						Cursos
					</div>
					<div class="span6 formulario">
						<input id="target" type="hidden" value="form_escolar_c"  /> 
						<button id="agregar_curs" class="btn agregar"  > Agregar  </button>
					</div>
				</div>
				
				<div class="row-fluid"> 
					<div class="span6 label_">
						Idiomas
					</div>
					<div class="span6 formulario">
						<input id="target" type="hidden" value="form_escolar_i"  /> 
						<button id="agregar_idi" class="btn agregar"  > Agregar  </button>
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
				<?php echo $this->element('Candidatos/editar_candidato/escolar/basico_captura'); ?>	
				<?php echo $this->element('Candidatos/editar_candidato/escolar/superior_captura'); ?>	
				<?php echo $this->element('Candidatos/editar_candidato/escolar/posgrado_captura'); ?>	
				<?php echo $this->element('Candidatos/editar_candidato/escolar/curso_captura'); ?>	
				<?php echo $this->element('Candidatos/editar_candidato/escolar/idioma_captura'); ?>	
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