<tr>
	<td colspan="2" style=" background-color:#343d45;height:3px;"></td>
</tr>

<tr>
	<td style="width:50%;vertical-align:top;">

		<?=$this->Html->image("email/email_foto.jpg",
		array(
			"fullBase"=>true,
			"width" => "381px",
			"height" =>"194px"
			))?>

	</td>
	<td style="width:50%;font-weight:bold;font-size:24px;color:#343d45;text-align:center;">
		Una Oferta ha sido<br>
		reportada
		<p></p>
	</td>
</tr>

<tr>
	<td colspan="2" style="background-color:#343d45;height:3px;"></td>
</tr>

<tr>
	<td colspan="2">
		<p style="font-weight:bold;" style="text-align:right;padding-right:10px;">
			Enviado: <?=$info['fecha']?>
		</p>
		<p style="text-align:center">La siguiente oferta ha sido reportada por un candidato debido a:
		</p>
		<p style="font-size:14px;font-weight:bold;text-align:center"><?=$info['causa']?>
		</p>

	</td>
</tr>

<tr>
	<td colspan="2" style="background-color:#343d45;padding:10px;color:#FFF;font-weight:bold;">Detalles</td>
</tr>

<tr style="background-color:#ddd;padding:10px;">
	<td style="padding-left:10px;text-align:left;" colspan="2"><p> <?=$info['detalles']?></p></td>
</tr>
<tr>
	<td colspan="2" style="background-color:#343d45;padding:10px;color:#FFF;font-weight:bold;">Datos del Usuario</td>
</tr>

<tr style="background-color:#ddd;padding:10px;">
	<td style="padding-left:10px;text-align:left;">
		<p><span style="color:#343d45;font-weight:bold;font-size:16px;">Nombre:</span> <?=$info['candidato_nombre']?></p></td>
	<td style="padding-left:10px;text-align:left;">
		<p><span style="color:#343d45;font-weight:bold;font-size:16px;">Teléfono Móvil:</span> <?=$info['candidato_telmovil'] ?>  </p>
		<p><span style="color:#343d45;font-weight:bold;font-size:16px;">Teléfono Fijo:</span> <?=$info['candidato_tel'] ?>  </p>
	</td>
		
</tr>

<tr style="background-color:#ddd;padding:10px;">
	<td style="padding-left:10px;text-align:left;">
		<p><span style="color:#343d45;font-weight:bold;font-size:16px;">Correo electrónico:</span> <?=$info['candidato_correo']?></p></td>
	<td style="padding-left:10px;text-align:left;">
		<p><span style="color:#343d45;font-weight:bold;font-size:16px;">Localidad:</span> <?=$info['candidato_estado']?> , <?=$info['candidato_ciudad']?> </p></td>
</tr>

<tr>
	<td colspan="2">
		<p style="text-align:center">Para consultar la oferta, de clic en el siguiente enlace: </p>
		<?php 
			$id=$info['oferta_cve'];
			$slug=Inflector::slug($info['puesto_nom'], '-') ."-$id";
		?>
		<?=$this->Html->link(__('Ver Oferta'), Router::fullBaseUrl(). "/admin/denuncias/$id/oferta/$slug/"  ,
		array("style"=> "color:#343d45;display:block;text-align:center;font-weight:bold;font-size:16px;"  )  )?>
		
		<br><br>
	</td>
</tr>