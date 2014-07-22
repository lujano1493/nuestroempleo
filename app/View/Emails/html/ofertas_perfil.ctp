<tr>
	<td colspan="2" style=" background-color:#2f72cb; height:3px;"></td>
</tr>

<tr>
    <td style="width:50%; vertical-align:top;">
		<?=$this->Html->image("email/ofertas.jpg",
		array(
			"fullBase"=>true, 
			"width" => "381px",
			"height" =>"194px"
			))?>
    </td>
	<td style="width:50%; font-weight:bold; font-size:24px; color:#2f72cb; text-align:center;">
		Ofertas acordes a tu perfil
		 <br><br>
		¡Postúlate! 
	</td>
</tr>
<tr>
	<td colspan="2" style=" background-color:#2f72cb; height:3px;"></td>
</tr>

<tr>
	<td colspan="2">
	<p style=" font-weight:bold; font-size:24px; color:#2f72cb; text-align:center;">
		<?php  
			App::import('Vendor','funciones');
			$url=Router::fullBaseUrl();
			$dia=date("d"); $mes=date("m");  $anio=date("Y");
			$str_mes=Funciones::mes_numero_palabra($mes,'largo');
			$dias_despues= date("d", strtotime(date("m/d/Y")."+14 day"));		
			$mes_despues= date("m", strtotime(date("m/d/Y")."+14 day"));	
			$str_mes_despues=Funciones::mes_numero_palabra($mes_despues,'largo');	
			$label= $str_mes !== $str_mes_despues ? " $dia de $str_mes al $dias_despues de $str_mes_despues de $anio" : "$dia  al $dias_despues de $str_mes de  $anio" ;
			?>
		Ofertas publicadas del <?=$label?>
	</p> 

	<table width="95%" border="0" style="text-align:justify;">
		<tbody>			
			<?php  foreach ($ofertas as $ofer) :
					$oferta=$ofer["OfertaB"];
			?>
			<tr>		    
		    	<td>
		    		<div>
								<?php 
									 $dir= array(
						 					"controller" => "postulacionesCan",
						 					"action" => "oferta_detalles",
						 					"id" => $oferta['oferta_cve'],
						 					"full_base" =>true
						 				);
								?>
								<?=$this->Html->link("$oferta[puesto_nom] ",$dir,
				 					array(
				 						"style" => "font-size:14px;color:#2f72cb;text-decoration:none;font-weight:bold",				 						
				 						)
				 				)?>									    			
		    		</div>
		 			<div  style="color:black;font-size:12px;font-weight:normal;"> 
		 				<?="$oferta[ciudad_nom] , $oferta[pais_nom] $oferta[oferta_sueldo] "?>						
		 			</div>
		 		</td>
		  		<td style="text-align: center;">
				  	<?php 				  		
				  		$image=	Funciones::check_image_cia($oferta['cia_cve'] );
				  		$image= $oferta['oferta_privada'] == 1 ? '/img/img_oferta_priv.jpg' : $image;
				  	?>	
				  	<div style="">
				  		<?=$this->Html->link("<img src='{$url}{$image}' width='200' height='65' style='max-width:95%;border:3px solid #B6B6B6;background-color:#FFF'> ",$dir,array(
				  			'escape' => false
				  	))?>
				  	</div>
				  						
				 
		  		</td>
		  </tr>
		<?php  endforeach ;?>		 
		</tbody>
	</table>
			<nr> <br>
     	<p style="color:#2f72cb; font-weight:bold;text-align:center">
     		El equipo de Nuestro Empleo agradece tu  preferencia
     	</p>
	</td>
</tr>