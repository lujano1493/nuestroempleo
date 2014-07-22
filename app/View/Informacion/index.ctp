
<div class="presentation container">

	<?php echo $this->element('inicio/busqueda',array(
														"extra_class" => "buscador",
														"with_title" =>true,
														"param"=> array() 
													)); ?>
	<div class="container-picture-carrusel "  data-component="carrusel" data-type="bxslider" style="height:330px;"   >
		<ul class="bxslider hide" >
			<li class="imagen1">
			</li>
			<li class="imagen2">
			</li>
			<li class="imagen3">				
			</li>
		</ul>
		
	</div>

	<?php if(!empty($micrositio)) :?>
			<div class="container" style="margin-top:20px">
				<?php  
					echo $micrositio['descrip'];
				?>
			</div>		

	<?php endif;?>

	

</div>