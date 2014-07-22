<?php
  $m = $mensaje['Mensaje'];
  $label = '';
  if (array_key_exists('Emisor', $mensaje)) {
    $e =  $mensaje['Emisor'] ;
    $label = $e['nombre'];
  } else {
    if (!empty($mensaje['ReceptorEmpresa'])) {
      foreach ($mensaje['ReceptorEmpresa'] as $key => $value) {
        $label .= '<p>' . $value['Cuenta']['nombre'] . '</p>';
      }
    }

    if ( !empty($mensaje['ReceptorCandidato'])  ){
      foreach ($mensaje['ReceptorCandidato'] as $key => $value) {
        $label .= '<p>' . $value['Cuenta']['email'] . '</p>';
      }
    }
  }

  echo $this->element('empresas/title');
?>

<table class="table table-bordered table-striped table-hover">
  <thead class="table-fondo">
    <tr>
      <th colspan="9">Asunto: <?php echo $m['msj_asunto']; ?></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td class="strong">Remitente:</td>
      <td colspan="7"><?php echo $label; ?></td>
      <td>
        <?php
          echo $this->Html->link($typeMsg == 'recibidos'?  'Responder' : 'Reenviar', array(
            'controller' => 'mis_mensajes',
            'action' => $typeMsg == 'recibidos' ? 'responder' : 'reenviar',
            'id' => $typeMsg == 'recibidos'? $mensaje['MensajeData']['receptormsj_cve'] : $m['msj_cve']
          ), array(
            'icon' => 'share-alt',
            'class' => 'btn btn-primary'
          ));
        ?>
      </td>
    </tr>
    <tr>
      <td colspan="9" class="text-left" style="height:200px;">
        <div class="msg-container">
          <?php echo $m['msj_texto']; ?>
        </div>
      </td>
    </tr>
  </tbody>
</table>