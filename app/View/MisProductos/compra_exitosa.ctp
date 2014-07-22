<?php
  // echo $this->element('empresas/title', array(
  //   'busqueda' => false
  // ));
?>
<br><br>
<div class="row">
  <div class="col-xs-8 col-md-offset-2 text-center">
    <div class="well">
      <?php
        // echo $this->Html->image('logo.png', array(
        //   'width' => 250
        // ));
      ?>
      <h1><?php echo __('¡Gracias por tu compra!'); ?></h1>
      <!-- <h3><?php // echo __('Te invitamos a seguir visitando nuestro catálogo de productos'); ?></h3> -->
      <br>
      <p>
        Estamos seguros que Nuestro Empleo superará sus expectativas. En breve uno de nuestros ejecutivos se pondrá en contacto para
        realizar la activación del servicio; o si lo prefiere, entre en contacto con nosotros a través de los siguientes medios:
      </p>
      <br>
      <p>
        D.F. y Área Metropolitana: <strong>(0155) 5564.1071</strong> / <strong>(0155) 5264.2678</strong><br>
        Interior de la República: <strong>01800 849.24.87</strong><br>
        Email: <strong><?php echo $this->Html->link('ventas.ne@nuestroempleo.com.mx', 'mailto:ventas.ne@nuestroempleo.com.mx', array(
          'target' => '_blank'
        )); ?></strong>
      </p>
      <br>
      <div class="btn-actions">
        <?php
          echo $this->Html->link(__('Ir a Mi Espacio'), array(
            'controller' => 'mi_espacio',
            'action' => 'index'
          ), array(
            'class' => 'btn btn-default',
            'icon' => 'home'
          ));

          echo $this->Html->link(__('Mis Productos'), array(
            'controller' => 'mis_productos',
            'action' => 'index'
          ), array(
            'class' => 'btn btn-orange',
            'icon' => 'file'
          ));

          echo $this->Html->link(__('Ir a Cátalogo'), array(
            'controller' => 'mis_productos',
            'action' => 'catalogo'
          ), array(
            'class' => 'btn btn-purple',
            'icon' => 'shopping-cart'
          ));
        ?>
      </div>
    </div>
  </div>
</div>