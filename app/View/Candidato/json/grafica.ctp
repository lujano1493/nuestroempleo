
<?php 
	$tablas_restantes="";	
	$total_r=count($tablas_r);

	$color="";
?>

<?php  if ($porcentaje >=0  && $porcentaje<=50   ) :  $color="#FF0000";?>
	¡Tu Currículum no está completo! Ingresa a 'Mi Currículum' y llena los siguientes campos: 

<?php endif; ?>

<?php  if ($porcentaje  > 50  &&  $porcentaje < 99  ) :  $color="#F7FE2E";?>
	¡Aumenta las visitas a tu Currículum completando los siguientes campos!:

<?php endif; ?>
<?php  if ($porcentaje >= 99   ) :  $color="#2784c3";  ?>
	¡Perfecto! La información de tu Currículum está completa.

<?php endif; ?>


<ul class="lista-restante" >
	<?php  for($i=0; $i<$total_r;$i++ ):
			$link_json=$tablas_r[$i]['TablaGrafCan']['tabla_link'];
			$link=json_decode($link_json);		
			$url=array(
				"controller" => $link->controller,
				"action" => $link->action				
				);

			if( !empty($micrositio)){
				$link->empresa=$micrositio['name'];
				$link_json=json_encode($link);
			}
			
	?>
		<li>
			<?=$this->Html->link($tablas_r[$i]['TablaGrafCan']['tabla_descripcion'], $url,
				array(
					"data-url" => "[$link_json]",
					"data-component"=> "viewelementview"
					)
				)?>
		</li>
		<br/>
	<?php  endfor;?>
</ul>


<?php 
	
	$this->_results= compact("color","porcentaje");
?>