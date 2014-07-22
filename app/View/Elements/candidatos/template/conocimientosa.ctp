<div  class="formulario conocimientosa <?=$save?> " title="Conocimientos Adicionales" data-form="ConoaCan"  > 
	<form  class="float-left" style="margin-left:10px">
		<input type="hidden" id="conocimientos_a"  />

			<?php 	

				echo $this->form->input ('ConoaCan.'.$i.'.candidato_cve',
					array(
						'value'=>$candidato_cve ,
						'class'=>"candidato_cve",
						'type'=>'hidden')); 

				echo  $this->form->input ('ConoaCan.'.$i.'.conoc_cve',
					array(								
						'class'=>" input-medium conoc_cve",	
						'type' => "hidden",
						));


				echo $this->form->input ('ConoaCan.'.$i.'.conoc_descrip',
					array(						
						'class'=>"input-xlarge conoc_descrip",
						'label'=>array ('class'=>'' ,'text'=>'Descripción*:' ),
						'div'=> array ('class'=>'float-left')
						)); 					
						?>		
	
					<div class="float-right tool">  
						<a href="#" class="eliminar_registro" title="Eliminar Referencia">x</a>
					</div>
	</form >
</div > 