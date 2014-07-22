<?php 
    $icon_user = $this->Html->tag('i', '', array('class' => 'icon-user')); 
?>
<div class="clearfix colorize" id="main-bar">
  <div class="container bar gradient bordered">
    <div class="row-fluid clearfix">
      <?php echo $this->element('logo', array('section' => 'admin')); ?>
      <ul class="menu horizontal pull-right">
      	<li><?php echo $this->Html->link('Candidatos', '/'); ?></li> | 
        <li><?php echo $this->Html->link('Empresas', '/empresas'); ?></li> | 
        <li><?php echo $this->Html->link('¿Necesitas ayuda?', '/ayuda'); ?></li> | 
        <li><?php echo $this->Html->link('Contacto', '/contacto'); ?></li>
        <?php if ($isAuthUser) { ?>
          | <li><?php echo $this->Html->link('Cerrar Sesión', '/cerrar_sesion'); ?></li>
        <?php } ?>
      </ul>
    </div>
  </div>
</div>