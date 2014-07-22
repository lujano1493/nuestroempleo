<?php

		$view_ntfy=array(
					 	"mensaje"=> array(
					 						"nombre" => "mensaje",
					 						"titulo" => "Mensajes",
					 						"icono" => "envelope",
					 						"element"    => array(
					 										"path" =>"candidatos/notificacion/mensaje"

					 							)


					 		),
					 	"evento" => array(
					 						"nombre" => "evento",
					 						"titulo" => "Eventos",
					 						"icono" => "calendar",
					 						"element"    => array(
					 										"path" =>"candidatos/notificacion/evento"

					 							)

					 		),
					 	"notificacion"=>array(
					 						"nombre" => "notificacion",
					 						"titulo" => "Notificaciones",
					 						"icono" => "bell",
					 						"element"    => array(
					 										"path" =>"candidatos/notificacion/notificacion"

					 						)

					 		)
			);
		$select=$view_ntfy[$tipo];


?>

<div class="btn-group  ntfy-<?=$select['nombre']?>" data-component="menuntfy" data-ntfy-type="<?=$select['nombre']?>">
  <button title="<?=$select['titulo']?>"  data-component="tooltip" data-placement="bottom"  class="btn_color btn-small strong dropdown-toggle" data-toggle="dropdown">
	  	<i class="icon-<?=$select['icono']?>"></i>
	  	<span class="ntfy-total"><?=$leidos?>
	  	</span>
  </button>
  <ul class="dropdown-menu dropdown-menu_notificaciones" >
		<?foreach ($data as $info) :?>
			<?if (isset($select['element'])) :?>
				<?=$this->element($select['element']['path'],array('data' =>$info))?>
			<?endif;?>
		<?endforeach;?>


	<?php if ($total >10 )  :?>
		<li  > <a  href="/notificaciones/index?tipo=<?=$tipo?>" >  <i class="icon-plus"></i>  Ver Más </a> </li>
 	<?php endif ;?>
  </ul>
</div>









