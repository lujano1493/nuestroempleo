
<div class="span9" >	
	<div class="row-fluid">
		<?php echo $this->Html->css(array (
								'Candidatos/forms_slide/forms_slides',
								'Candidatos/validacion_errores/error_',
								'font/font-awesome.min'
								)); ?>

	</div>
	<?php echo $this->element('menu_candidato'); ?>
	<?php echo $this->Session->flash(); ?>
		<div id="forms" >
			<div class="slides_container ">
			<div class="slide">
					<div  class="title"> 
						Información Perfil 
					</div>
					<?php echo $this->element('Candidatos/editar_candidato/perfil'); ?>	
				</div>
				<div class="slide">
					<div  class="title"> 
							Información Domicilio 
					</div>
						<?php echo $this->element('Candidatos/editar_candidato/domicilio'); ?>	
				</div> 
								
				<div class="slide">
					<div  class="title"> 
						Referencias
					</div>
					<?php echo $this->element('Candidatos/editar_candidato/referencias'); ?>	
				</div>
				
				<div class="slide">
					<div  class="title"> 
						Información Academica 
					</div>
					<?php echo $this->element('Candidatos/editar_candidato/escolar'); ?>	
				</div> 
				<div class="slide">
					<div  class="title"> 
						Experiencia Laboral 
					</div>
					<?php echo $this->element('Candidatos/editar_candidato/laboral'); ?>	
				</div>
			
				<div class="slide">
					<div  class="title"> 
						Pasatiempo
					</div>
					<?php echo $this->element('Candidatos/editar_candidato/pasatiempo'); ?>	
				</div>
							
				
				
			</div>		
		</div>
</div>



<div class="span3">
	<?php echo $this->element('Candidatos/publicidad_'); ?>
</div>


<?php $this->Html->script(array(
								'jquery.validate',
								'Candidatos/config',
								'Candidatos/configurar',
								'Candidatos/configurar_eventos',
								'Candidatos/editar_candidato/actualizar_perfil',
								'Candidatos/editar_candidato/domicilio',		
								'Candidatos/editar_candidato/escolar',	
								'Candidatos/editar_candidato/escolar_2',			
								'Candidatos/editar_candidato/laboral',				
								'Candidatos/editar_candidato/pasatiempo',	
								'Candidatos/editar_candidato/referencias',								
								'slides.min.jquery',
								'jquery.ba-resize'
								), array('inline' => false)); ?>

