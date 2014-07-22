<div  class="formulario cursos <?=$save?>" title="Educación" data-form="CursoCan"  > 
	<form >
		<input type="hidden" id="escolar"  />
		<div class="row-fluid">
			<div class="offset11 span1"> 
				<div class=" tool">  
					<a href="#" class="eliminar_registro" title="Eliminar Referencia">x</a>
				</div>
			</div>
		</div> 
		<div class="row-fluid">					
			<div class="span3 ">			
				<?php 	

				echo $this->form->input ('CursoCan.'.$i.'.candidato_cve',
					array(
						'value'=>$candidato_cve ,
						'class'=>"candidato_cve",
						'type'=>'hidden'));  


				echo $this->form->input ('CursoCan.'.$i.'.curso_cve',
					array(
						'class'=>"curso_cve",
						'type'=>'hidden'));  

				echo  $this->form->input ('CursoCan.'.$i.'.cursotipo_cve',
					array(								
						'class'=>" input-medium cursotipo_cve",
						'options' => $cursotipo_cve_arr,				
						'div' => false,
						'label' => 'Tipo de curso*:'
						));


						?>		
						

			</div>
			<div class="span4 ">			
				<?php 
				echo  $this->form->input ('CursoCan.'.$i.'.curso_institucion',
					array(								
						'class'=>" input-large curso_institucion",			
						'div' => false,
						'label' => 'Institución*:'
						));

						?>

			</div>
			<div class="span4 ">			
				<?php 
				echo  $this->form->input ('CursoCan.'.$i.'.curso_nom',
					array(								
						'class'=>" input-large curso_nom",			
						'div' => false,
						'label' => 'Nombre*:'
						));

						?>

			</div>

		</div>

		<div class="row-fluid">					
			<div class="span4 "> 
				<label> Fecha Inicial*: </label>
				<div  id="actualizarCursoCan<?=$i?>Curso_fecini" name="data[actualizar][CursoCan][<?=$i?>][curso_fecini]"  class="curso_fecini date-picker date-picker-month-year date-start"> 
					<?=$this->form->input("CursoCan.$i.curso_fecini",
									array("class"=>' hide','type'=>'hidden')) ?>
				</div>
			</div>
			<div class="span4 "> 
				<label> Fecha Final: </label>
				<div  id="actualizarCursoCan<?=$i?>Curso_fecfin"  name="data[actualizar][CursoCan][<?=$i?>][curso_fecfin]" class="curso_fecfin date-picker date-picker-month-year date-end"> 
					<?=$this->form->input("CursoCan.$i.curso_fecfin",
									array("class"=>' hide','type'=>'hidden')) ?>

				</div>
			</div>
		</div>
		


	</form >
</div > 