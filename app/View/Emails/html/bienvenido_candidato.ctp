  	<br />
	<p align="center"><b> Hola <?=$data['nombre']?>, Gracias por registrarte en Nuestro Empleo.</b></p>
	<p>Para confirmar tu cuenta necesitamos que valides tu direcci&oacute;n de correo. Recuerda conservar tu contrase&ntilde;a para que tengas acceso en cualquier momento.</p>
	<p align="center">Usuario: <?=$data['correo']?><br />
	Contrase&ntilde;a: <?=$data['contrasena']?></p>
	<p>Por favor da clic en el siguiente enlace para terminar tu registro.</p>
	<p align="center">
		<a href="<?php echo $this->Html->url(array(
		    'controller' => 'Candidato',
		    'action' => 'activar',
		    $data['keycode']
		  ), true); ?>"><img src="cid:image3" width="234" height="61" style="margin-left:auto;margin-right:auto" /></a><br />
     <label  style="font-size:12px; font-weight:bold;"><b>
  El equipo de Nuestro Empleo agradece tu <br />preferencia</b></label>
  </p>
  <br />