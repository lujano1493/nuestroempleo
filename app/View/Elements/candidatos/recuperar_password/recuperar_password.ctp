<div class='input_data'>
	<div class='row-fluid'>
		<div class='span6'>
			Por favor escribe tu dirección de correo electrónico 
		</div>

	</div>

	<div class='row-fluid'>
		<div class='span6'>
			<?php 
				echo $this->Form->input('CandidatoUsuario.cc_email', array(
								'label' => "&nbsp;",
								'id' => 'cc_email_recuperar',
								'div'=> array ('id'=>'div_correo','class'=>" input-prepend" ),
								'between'=>  "<span class='add-on' > <i class='icon-envelope'> </i> </span>",
								'placeholder' => 'Correo Electrónico'));
						 ?>
		</div>

	</div>
	<div class="row-fluid">
		<div class="span6"> 
			<?php 
			echo $this->element("candidatos/tool/captcha");
			?>
		</div>
	</div>
	<?php 
		echo $this->element("candidatos/tool/space_row")
	?>
		<div class="row-fluid control"> 
			<div class="span4 " > 
				<button class="btn btn-success  recuperar"> Recuperar </button>								
			</div>
			<div class="span5  text-left">
				<div class="loading"> 
					<img src='<?php echo $this->webroot;?>img/candidatos/load.gif'  />  
				</div> 
				<div class="status">  </div> 							
			</div>
									
		</div>
</div>