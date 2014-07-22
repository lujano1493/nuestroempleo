<tr style="background-color:<?=$background?>">
    <td style="text-align: justify !important;vertical-align: top;padding: 10px;margin: 0px;">
		<span style="display: inline-block;">
			<?php 
					$ruta_img="documentos/candidatos/".$data['candidato_cve']."/foto.jpg";					  
					 $ruta_img= file_exists(  WWW_ROOT .$ruta_img)  ? $ruta_img:"img/candidatos/default.jpg";
					$url=Router::fullBaseUrl();
					$ruta_img= $url ."/".$ruta_img;
			?>
		<img src="<?=$ruta_img?>"  width="100px"  height='130px' >		
		</span>
		<span style="display: inline-block;">
			<strong> <?=$data['ciudad']		?> , <?=$data['edad']?> Años
			</strong>
			<br>
			<br>			
		</span>
	</td>
	<td style="text-align: justify !important;vertical-align: top;padding: 10px;margin: 0px;">
	

		<div style="background: #49317b;width: 120px;margin: inherit;color: #FFF;padding:10px 0 10px 10px;text-align: center;margin-left: auto;margin-right: auto;font-weight:bold;text-transform:uppercase">
		<?=$this->Html->link("Ver Perfil",array(
				"controller" => "candidatos",
				"action" =>"perfil",
				"id"=>$data['candidato_cve'],
				"slug" =>Inflector::slug("Perfil",'-'),
				"full_base" =>true),array("target"=>"_blank","style" =>"color:#FFF" ))

				?> 
		</div>
		<p style="background: #cbcbcb;color: #4B4B4B;padding: 10px 0 10px 10px;text-align: left !important;font-weight: bold;text-transform: uppercase;">
			Formación Profesional					
		</p>
		<p style="padding: 10px 0 10px 10px;text-align: left !important;" >
				<?php 

					$academicos=explode("::",$data['escolar']);				
					foreach ($academicos as $a) {
						$estudio=explode("_",$a);
						if(empty($estudio[0])){
							break;
						}
						$escuela=$estudio[0]; $nivel=$estudio[1]; 
						$fecha=Funciones::formato_fecha_1($estudio[2],$estudio[3]);
						echo "<strong> $escuela</strong> <br/> $nivel $fecha <br/>";
						}

			?>

		</p>
		
	</td>
</tr>
<tr style="background-color:<?=$background?>">   
	<td style="text-align: justify !important;vertical-align: top;padding: 10px;margin: 0px;" colspan="2">
		<p style="background: #cbcbcb;color: #4B4B4B;padding: 10px 0 10px 10px;text-align: left !important;font-weight: bold;text-transform: uppercase;">
			Última experiencia laboral
		</p>
		<?php if (isset($data['laboral_empresa'])) {?>
		<div style="padding: 10px 0 10px 10px" >			
			<p style="text-align: left" >
				<strong> <?=$data['laboral_puesto']?> </strong>   <?=Funciones::formato_fecha_1($data['laboral_fecini'],$data['laboral_fecfin'])?> 
			</p>
			<p  style="text-align: center">
					<?=$data['laboral_empresa']?> -  <?=$data['laboral_giro']?>
			</p>
			<p style="text-align:justify">
				<?=$data['laboral_funciones']?>
				
			</p>				
		</div>

		<?php } else{?>
				<p> Ninguna.</p>
		<?php } ?>
	</td>	
</tr>
<tr style="background-color:<?=$background?>">   
	<td style="text-align: justify !important;vertical-align: top;padding: 10px;margin: 0px;" colspan="2" >
		<p style="background: #cbcbcb;color: #4B4B4B;padding: 10px 0 10px 10px;text-align: left !important;font-weight: bold;text-transform: uppercase;">
			Áreas de Experiencia
		</p>
		<?php   
			$areas_exp= explode("::",$data['areas_exp']); 
			if(empty($areas_exp[0]) ){
		     echo "<p>Ninguna.</p>";
			}  else{
			foreach ($areas_exp as $value) {					
			?>
			<p>
				<?=$value?>
			</p>
		<?php }
		}?>

	</td>

</tr>

<tr  style="background-color:<?=$background?>">
  <td colspan="2" style="border-bottom: #8d8d8d medium dotted;border-top: #8d8d8d medium dotted;padding: 5px 0 5px 0;"></td>
</tr>