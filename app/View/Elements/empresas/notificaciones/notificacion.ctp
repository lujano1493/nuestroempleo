<?php
  $ntfy = $data['Notificacion'];
  $from = $data['From'];
  $urlLink = $ntfy['notificacion_controlador'];
  $urlImg = '';
  if (!empty($from['id'])) {
    $urlImg = $this->Candidato->getPhotoPath($from['id']);
  }
  $title = $ntfy['notificacion_titulo'];
  $text = $ntfy['notificacion_texto'];
  $unreadClass = $ntfy['notificacion_leido'] == 0 ? 'unread' : '';
?>

<div class='ntfy clearfix <?php echo $unreadClass; ?>' data-id="<?= $ntfy['notificacion_cve'] ?>">
  <img src="<?= $urlImg ?>">
  <div class="ntfy-body">
    <?php
      if ($ntfy['tipo'] === 'mensaje') {
        echo $this->Html->link(__('%s (%s)', $from['nombre'], $from['email']), '#', array(
        'icon' => 'user',
        ));
      }
    ?>
    <strong class="title"><?= $title ?></strong>
    <small><?= $text ?></small>
  </div>
  <div class="ntfy-footer">
    <?php
      echo $this->Html->link($this->Time->dt($ntfy['created']), $urlLink, array(
        'icon' => 'time',
        'class' => 'block ntfy-link'
      ));
    ?>
  </div>
</div>