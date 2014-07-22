	
	<?php 
		$v=$this->action=='enviados' ? 'enviado' :'recibido';  
		$leido= $this->action!='enviados' ? "{{? !it.leido   }}unread {{?}}":"";
	 ?>
  <span data-order="{{=it.<?=$v?>.order}}" class="<?=$leido?>" > {{=it.<?=$v?>.str}} </span>