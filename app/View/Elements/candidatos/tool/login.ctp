<div id="login_candidato" class="modal hide fade form_" tabindex="-1" role="dialog" >
  <div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
    <h3 class="text-right title">Iniciar Sesión</h3>
  </div>
  <div class="modal-body formulario">
  
	<div> &nbsp;</div>
    <form id="form_login_candidato" action="<?php echo $this->webroot;?>" >
		<input type="hidden" id="config_validation_login_candidato"  name="" />
		<div class="text-center ">			
		<?php 
					echo $this->Form->input('CandidatoUsuario.cc_email', array(
						'label' => "&nbsp;",
						'id' => 'cc_email',
						'div'=> array ('id'=>'div_correo','class'=>"parent_ input-prepend" ),
						'between'=>  "<span class='add-on' > <i class='icon-envelope'> </i> </span>",
						'placeholder' => 'Correo Electrónico'
					)); ?>
		</div>
		<div class="text-center">		
					<?php				
					echo $this->Form->input('CandidatoUsuario.cc_password', array(
						'label' => "&nbsp;",
						'id'=>'cc_password',
						'div'=> array ('id'=>'div_pass','class'=>"parent_ input-prepend" ),
						'between'=>  "<span class='add-on' > <i class='icon-lock'> </i> </span>",
						'type' => 'password',				
						'placeholder' => 'Contraseña'
					));
				?>
		</div>
				<div> &nbsp;</div>
				
				<div class="row-fluid control"> 
					<div class="span4 offset3 text-right" > 
						<button class="btn btn-success btn-large login_candidato"> Iniciar Sesión </button>							
					</div>
						<div class="span5  text-left">
							<div class="loading"> 
								<img src='<?php echo $this->webroot;?>img/Candidato/load.gif'  />  
							</div> 
							<div class="status">  </div> 							
						</div>
						
							
				</div>
				
				
	</form>
				
	</div>
		<div> &nbsp;</div>
	  <div class="link_ clearfix">
			<div style="float:left;margin-left:20px"> <a href="#" class="recuperar_contrasena">Olvide mi contraseña   </a> </div>
			<div style="float:right;margin-right:20px"> <a href="#" class="registro_nuevo">No Estoy Registrado  </a> </div>
	  
	  </div>
	  <div> &nbsp;</div>

 <!-- <div class="modal-footer">
	
	
  </div> -->
</div>

