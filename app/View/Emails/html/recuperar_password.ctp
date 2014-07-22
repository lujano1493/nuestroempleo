<h1>Nuestro Empleo</h1>
<p>Hemos recibido una solicitud para cambiar su contraseña, de no ser así, por favor ignora este mensaje.</p>
<p>Enviado: <?php echo date("Y-m-d H:i:s"); ?></p>

<p>Por favor da clic en el siguiente enlace para continuar con el procedimiento:
  <?php
    $newPasswordLink = $this->Html->url('/tickets/' . $keycode, true);
    echo $this->Html->link($newPasswordLink, $newPasswordLink,array("style" =>"color:#15c"));
  ?>
</p>