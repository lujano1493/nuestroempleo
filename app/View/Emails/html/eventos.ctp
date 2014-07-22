<tr>
	<td colspan="2" style=" background-color:#2f72cb;height:3px;"></td>
</tr>

<tr>
    <td style="width:50%; vertical-align:top;">
		<?=$this->Html->image("email/eventos.jpg",
		array(
			"fullBase"=>true, 
			"width" => "381px",
			"height" =>"194px"
			))?>
    </td>
	<td style="width:50%; font-weight:bold;font-size:24px;color:#2f72cb;text-align:center;">
		¡Nuestro empleo te guía<br>en la búsqueda!
	</td>
</tr>
<tr>
	<td colspan="2" style=" background-color:#2f72cb;height:3px;"></td>
</tr>
<tr>
    <td colspan="2">
    	<p style="text-align:center;padding-left:10px;font-weight:bold">
    		Estimado: <?=$data['Usuario']['CandidatoUsuario']['nombre']?> 
    	</p>    	
		<p align="center">Conoce los próximos Eventos realizados por importantes Empresas.</p>
		<p align="center" style="color:#2f72cb;font-weight:bold;font-size:16px;">  
			Entérate de la fechas, asiste y participa.
								
		</p>

		<div style="width:100%">
			<?php foreach ( $data['Eventos'] as $value ) :?>
				<div style="width:100%;display:inline-block;margin-bottom:15px;background-color:#ddd;">
					<p  align="center" style="background-color:#2f72cb;padding:3px;color:#FFF;font-weight:bold;font-size:16px;">
						<?=$value['Evento']['fecha_ini_']?>
					</p>
					<p style="font-weight:bold"   align="center">
						<?=$this->Html->link($value['Evento']['evento_nombre'],array(
							"controller" => "eventosCan",
							"action" => "index",
							"?" => array("idEvento" => $value['Evento']['evento_cve']) ,
							"full_base" => true						
						),array(
							"style" => "color:#2f72cb"
						))?>
					</p>
					<p  style="text-align:center" >						
						<?=$value['Evento']['evento_dir']?>
					</p>
				</div>
			<?php  endforeach;?>
			
		</div>
		
	</td>
</tr>