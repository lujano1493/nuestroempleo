
<div class="row-fluid">	



	<?php if (!$isAuthUser){  ?>
		<div class="span8"> 
			<div class="navbar">
			  <div class="navbar-inner">
				<ul class="nav">
				  <li ><a href="#" class="show_registro_can"> <i class="icon-user"> </i> Crear Cuenta  </a></li>
				   <li ><a href="#"> <i class="icon-book"> </i> Educación </a></li>
				  <li ><a href="#"> <i class="icon-calendar"> </i> Evento  </a></li>
				</ul>
			  </div>
			</div>
		</div>
		<div class="span4">  
			<div class="navbar">
			  <div class="navbar-inner">
				<ul class="nav">
				  <li ><a href="#"> <i class="icon-print"> </i> Publica una oferta de empleo </a></li>			 
				</ul>
			  </div>
			</div>
		</div>
	<?php }
		else {
	
	?>
		<div class="span12"> 
			<div class="navbar">
			  <div class="navbar-inner">
				<ul class="nav">
					<?php foreach ($arr_menu_bar as $menu_op): ?>
				
						<li class="<?=$menu_op['active']?>" ><a href="<?=$menu_op['href']?>" > <i class="<?=$menu_op['icon']?>"> </i> <?=$menu_op['text']?></a></li>
					<?php endforeach; ?>
				</ul>
			  </div>
			</div>
	
		</div>	
	<?php }?>
	
</div>