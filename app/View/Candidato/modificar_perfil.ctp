
<div class="span9">
	<?php echo $this->element('menu_candidato'); ?>	
	<?php echo $this->form->create('Candidato',array('id' => 'form_perfil_act',
	'url' => array('controller' => 'candidatos', 'action' => 'modificar_perfil'),'class'=>'sliding clearfix'));?>
	<?php echo $this->Session->flash(); ?>
	<fieldset>
	  <legend>Perfil de Candidato </legend>  
     <table id="info"  class="inform_t" align="center" border="0" cellpadding="1" cellspacing="4" width="95%">
	<tbody>
	  <tr>
   		  <td colspan="4"><span align="left"> <b>Actualización Datos Personales </b> </span><hr class="Linea"></td>
		  
	  </tr>
	  
	   <tr>
   		  <td> <label for="persona_nom">Nombre(s)*  </label>  </td>
		 <td>  
			<?php 
				echo $this->form->input ('Candidato.gpo_cve', array(
															'id'=>'gpo_cve',
															'type'=>'hidden',															
															'label'=>false														
														));
			
			
				echo $this->form->input ('Candidato.persona_cve', array(
															'id'=>'persona_cve',
															'type'=>'hidden',
															'label'=>false														
														));
				echo $this->form->input ('Candidato.persona_nom', array(
															'id'=>'persona_nom',
															'type'=>'text',
															'label'=>false,	
															'class'=>'input-medium',
															 'placeholder' => 'Nombre',
															'onblur'=>'javascript:mayus(this);' )); 
				?>		

		 </td>
		 
		 <td> <label for="persona_pat">Primer Apellido *  </label>  </td>
		 <td>  	<?php 	echo $this->form->input ('Candidato.persona_pat', array(
															'id'=>'persona_pat',
															'type'=>'text',
															'label'=>false,	
															'class'=>'input-medium',
															 'placeholder' => 'Primer Apellido *  ',
															'onblur'=>'javascript:mayus(this);' ));  ?>		

		 </td>
	  </tr>
	  
	  <tr>
   		  <td> <label for="persona_mat">Segundo Apellido *  </label>  </td>
		 <td>  	<?php 	echo $this->form->input ('Candidato.persona_mat', array(
															'id'=>'persona_mat',
															'type'=>'text',
															'label'=>false,	
															'class'=>'input-medium',
															 'placeholder' => 'Segundo Apellido',
															'onblur'=>'javascript:mayus(this);' ));  ?>		

		 </td>
		  <td> <label for="">Genero  </label>  </td>
		 <td> <?php 
				
					echo $this->form->input('Candidato.persona_sex', array(
						'div' => array ('id'=>'div_radio_genero'),
						'legend' => false,
						'options' => array('M'=>'M', 'F'=>'F'),
						'type' => 'radio'
					));
				?>

		 </td>
		 
		
	  </tr>
	  
	  
	    <tr>
   		 
		 <td> <label for="edocivil_cve">Estado Civil </label>  </td>
		 <td>  	<?php 		echo $this->form->input('Candidato.edocivil_cve',array(
																		 'class'=> 'input-medium',
																		 'id'=>'edocivil_cve',
																		 'options'=> $edo_civil ,
																		 'label'=>false,
																		 'div' => false)) ;   ?>		

		 </td>
		 <td> <label for="persona_nac">Fecha de Nacimiento  </label>  </td>
		 <td>  
		 <?php 	
				echo $this->form->input ('Candidato.persona_nac', array( 
					 'id'=>'persona_nac',
					 'class'=>'input-small',
					 'placeholder' => 'Fecha de Nacimiento',
					 'type'=>'text','label'=>false, 'value'=> $this->data['Candidato']['fecha_nacimiento'],'onchange'=>'calcularEdad(this)'  ));  ?>	

		 </td>
		 
	  </tr>
 

        <tr>
   		  
		 
			  <td> <label for="est_cve">Estado </label>  </td>
		 <td>  
		 <?php 	
			echo $this->form->input('Estado.est_cve',array( 
															'id'=>'est_cve',
															'class'=>'input-medium',
															'options'=> $estados ,
															'label'=>false,
															'div' => false,
															'onchange'=>'javascript:getCiudad(this,"#ciudad_cve")')) ;  ?>	

		 </td>
		 	<td> <label for="est_cve">Estado </label>  </td>
		 <td>  
		 <?php 	
			echo $this->form->input('Candidato.ciudad_cve',array( 
															'id'=>'ciudad_cve',
															'class'=>'input-medium',
															'options'=> $ciudad_cve ,
															'label'=>false,
															'div' => false   )) ;  ?>	

		 </td>
		
	  </tr>
	   <tr>
   		   <td> <label for="persona_curp">CURP </label>  </td>
		 <td>  	<?php 	echo $this->form->input ('Candidato.persona_curp', array(
															'id'=>'persona_curp',
															'class'=>'input-medium',
															'type'=>'text',
															'label'=>false,	
															 'placeholder' => 'CURP',
															'onblur'=>'javascript:mayus(this);' ));  ?>		

		 </td>
		 
		 <td> <label for="persona_imss">IMSS </label>  </td>
		 <td>  	<?php 	echo $this->form->input ('Candidato.persona_imss', array(
															'id'=>'persona_imss',
															'class'=>'input-medium',
															'type'=>'text',
															'label'=>false,	
															 'placeholder' => 'IMSS' ));  ?>		

		 </td>
	  </tr>
	 
 
  	
</tbody></table>

      <div class="row-fluid">
	  	<div class="span9">
      
      <?php 
    	echo $this->Form->submit('Aceptar', array( 'class' => 'btn btn-success btn-large pull-right', 'div' => false));
		?>
      </div>
		</div>
      </fieldset>
	 
		<?php echo $this->Form->end(); ?>
</div>

<div class="span3"> 
<?php echo $this->element('Candidatos/publicidad_'); ?>
</div>
<?php $this->Html->script(array (
									'jquery.validate',
									'jquery-ui-1.9.2.custom',
									'configurar',
									'candidatos/actualizar_perfil'

								), array('inline' => false)); ?>
		