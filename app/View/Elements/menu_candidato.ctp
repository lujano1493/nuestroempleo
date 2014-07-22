<ul class="nav nav-pills">
	<li class="active"> 
	
			<?php echo $this->Html->link('INICIO', array('controller'=>'candidatos','action'=>'index')); ?> 
		
	</li>
	<li class="dropdown">
		<a class="dropdown-toggle" data-toggle="dropdown" href="#">
			Candidato
			<b class="caret"></b>
		</a>
		<ul class="dropdown-menu">
			<li> 
				<?php echo $this->Html->link('Editar', array('controller'=>'candidatos','action'=>'editar_candidato')); ?> 
			</li>
		
			<li> 
				<?php echo $this->Html->link('Modificar Perfil', array('controller'=>'candidatos','action'=>'modificar_perfil')); ?> 
			</li>
			<li> 
				<?php echo $this->Html->link('Información de Domicilio', array('controller'=>'candidatos','action'=>'domicilio_actual')); ?>  
			</li>
			<li> 
				<a href="#">Información Escolar</a>                        
			</li>
			<li> 
				<a href="#">Experiencia Laboral</a>                        
			</li>
		</ul>
	</li>  
	
	<li> 
		<a href="#" >CURRÍCULUM   </a>
			
	</li>
	<li> 
		<a href="#" >BÚSQUEDA   </a>
			
	</li>
		<li> 
		<a href="#" >MENSAJES   </a>
			
	</li>
	
</ul>

<?php $this->Html->script(array ('bootstrap/dropdown'), array('inline' => false)); ?>
