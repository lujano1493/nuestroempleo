
<div class="span9">
	<?php echo $this->element('menu_candidato'); ?>	
	<?php echo $this->form->create('DirPersona',array('id' => 'form_dir_persona',
	'url' => array('controller' => 'candidatos', 'action' => 'domicilio_actual'),'class'=>'sliding clearfix'));?>
	<?php echo $this->Session->flash(); ?>

	<fieldset>
	  <legend>Inforamción Domicilio Actual</legend>  
     <table id="info"  class="inform_t" align="center" border="0" cellpadding="1" cellspacing="4" width="95%">
	<tbody>
	  <tr>
   		  <td colspan="3"><span align="left"> <b>Actualización Datos de Domicilio </b> </span><hr ></td>
		  
	  </tr>
	  
	  <tr> 
		<td> <label for="cp_cp" >*Codigo Postal </label>  </td>
	  	<td> </td>
	  	<td> <label>  *País: </label>  </td>
	  </tr>
	 
	 <tr> 
		<td> 
		<?php 	echo $this->form->input ('persona_cve', array(
															'id'=>'persona_cve',
															'type'=>'hidden',
															'label'=>false ));  ?>	
		
			<?php 	echo $this->form->input ('CodigoPostal.cp_cp', array(
															'id'=>'cp_cp',
															'type'=>'text',
															'onblur'=>'buscar_codigo("cp_cp")',
															'label'=>false,	
															 'placeholder' => 'Código Postal' ));  ?>		 </td>
	  	<td> 
			

		</td>
	  	<td> 
			<?php 	echo $this->form->input ('Pais.pais_nom', array(
															'id'=>'pais_nom',
															'type'=>'text',
															'label'=>false,	
															 'placeholder' => 'Pais' ));  ?>
				
		
		</td>
	  </tr>
	  
	  <tr> 
		<td> <label>*Estado:</label>  </td>
	  	<td> <label> *Ciudad: </label>  </td>
	  	<td> <label for="cp_asentamiento">  *Colonia: </label>  </td>
	  </tr>
	  
	   <tr> 
		<td> <?php 	echo $this->form->input ('Estado.est_nom', array(
															'id'=>'est_nom',
															'type'=>'text',
															'label'=>false,	
															 'placeholder' => 'Estado' ));  ?>		 
		</td>
	  	<td> 
			<?php 	echo $this->form->input ('Municipio.ciudad_nom', array(
															'id'=>'ciudad_nom',
															'type'=>'text',
															'label'=>false,	
															 'placeholder' => 'Ciudad' ));  ?>
				
		
		</td>
			<td> 
			<?php 	echo $this->form->input ('CodigoPostal.cp_asentamiento', array(
															'id'=>'cp_asentamiento',
															'type'=>'text',
															'label'=>false,	
															'placeholder' => 'Colonia',

															 ));  ?>
				
			<?php 	echo $this->form->input ('cp_cve', array(
															'id'=>'cp_cve',
															'type'=>'hidden',
															'label'=>false

															 ));  ?>
		
		</td>
	  </tr>
	<tr> 
		<td> <label for="dirper_callenum">*Calle:</label>  </td>
	  	<td> <label for="dirper_numext"> *Número Exterior: </label>  </td>
	  	<td> <label for="dirper_numint">  Número Interior: </label>  </td>
	</tr>
	
	<tr> 
		<td> <?php 	echo $this->form->input ('dirper_callenum', array(
															'id'=>'dirper_callenum',
															'type'=>'text',
															'label'=>false,	
															 'placeholder' => 'Calle', 
															 'onblur'=>'javascript:mayus(this);' 
															 ));  ?>		 
		</td>
	  	<td> 
			<?php 	echo $this->form->input ('dirper_numext', array(
															'id'=>'dirper_numext',
															'type'=>'text',
															'label'=>false,	
															 'placeholder' => 'Número Exterior' ));  ?>
				
		
		</td>
			<td> 
			<?php 	echo $this->form->input ('dirper_numint', array(
															'id'=>'dirper_numint',
															'type'=>'text',
															'label'=>false,	
															'placeholder' => 'Número Interior',

															 ));  ?>
				
		
		</td>
	  </tr>
 
 
 <tr> 
		<td> <label for="dirper_tel">*Teléfono:</label>  </td>
	  	<td> <label for="dirper_movil"> *Teléfono Móvil: </label>  </td>
	  	<td> </td>
	</tr>
	
	<tr> 
		<td> <?php 	echo $this->form->input ('dirper_tel', array(
															'id'=>'dirper_tel',
															'type'=>'text',
															'label'=>false,	
															 'placeholder' => 'Teléfono' ));  ?>		 
		</td>
	  	<td> 
			<?php 	echo $this->form->input ('dirper_movil', array(
															'id'=>'dirper_movil',
															'type'=>'text',
															'label'=>false,	
															 'placeholder' => 'Teléfono Móvil' ));  ?>
				
		
		</td>
			<td> 
		
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
									'candidatos/domicilio'

								), array('inline' => false)); ?>