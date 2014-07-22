<div class="row">
  <div class="span5 pull-right">
    <?php
      echo $this->Html->image('assets/error-logo-gray.png', array(
        'width' => 365,
        'height' => 426
      ));
    ?>
  </div>
  <div class="span5">
    <h1>
      <i class="icon-unlink icon-2x"></i>Lo sentimos
    </h1>
    <div class="well">
      <p class="back_blanco2">
        <strong>La página no está disponible o se ha roto el enlace</strong>
        <br>
        <br>
        Sugerimos:
        <br>
        <br>
        1. Verificar que la dirección esté escrita correctamente<br>
        2. Intentar acceder a la página nuevamente<br>
        <br>
        Te invitamos a seguir navegando en&nbsp;<?php echo $this->Html->here(); ?>
      </p>
    </div>
  </div>
</div>