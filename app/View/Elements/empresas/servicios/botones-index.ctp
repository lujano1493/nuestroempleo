<div class="servicios">
  <h5 class="subtitle">
    <i class="icon-tags"></i><?php echo __('Nuestros Productos'); ?>
  </h5>
  <div class="row">
    <div class="col-xs-2 serv publicar">
      <i class="icon-edit icon-4x"></i>
      <p><?php echo __('Publicación de vacantes'); ?></p>
      <?php
        echo $this->Html->link(__('Ver más'), '#nuestros-servicios', array(
          'class' => 'btn btn-xs btn-blue',
          'data-toggle' => 'slidemodal',
          'data-slide' => 0,
        ));
      ?>
    </div>
    <div class="col-xs-2 serv cvs">
      <i class="icon-search icon-4x"></i>
      <p><?php echo __('Búsqueda y liberación de CVs'); ?></p>
      <?php
        echo $this->Html->link(__('Ver más'), '#nuestros-servicios', array(
          'class' => 'btn btn-xs btn-blue',
          'data-toggle' => 'slidemodal',
          'data-slide' => 1,
        ));
      ?>
    </div>
    <div class="col-xs-2 serv silver">
      <i class="icon-certificate icon-4x"></i>
      <p><?php echo __('Membresía Silver'); ?></p>
      <?php
        echo $this->Html->link(__('Ver más'), '#nuestros-servicios', array(
          'class' => 'btn btn-xs btn-blue',
          'data-toggle' => 'slidemodal',
          'data-slide' => 2,
        ));
      ?>
    </div>
    <div class="col-xs-2 serv golden">
      <i class="icon-magic icon-4x"></i>
      <p><?php echo __('Membresía Golden'); ?></p>
      <?php
        echo $this->Html->link(__('Ver más'), '#nuestros-servicios', array(
          'class' => 'btn btn-xs btn-blue',
          'data-toggle' => 'slidemodal',
          'data-slide' => 3,
        ));
      ?>
    </div>
    <div class="col-xs-2 serv diamond">
      <i class="icon-trophy icon-4x"></i>
      <p><?php echo __('Membresía Diamond'); ?></p>
      <?php
        echo $this->Html->link(__('Ver más'), '#nuestros-servicios', array(
          'class' => 'btn btn-xs btn-blue',
          'data-toggle' => 'slidemodal',
          'data-slide' => 4,
        ));
      ?>
    </div>
    <div class="col-xs-2 serv anuncios">
      <i class="icon-star icon-4x"></i>
      <p><?php echo __('Promoción'); ?></p>
      <?php
        echo $this->Html->link(__('Ver más'), array(
          'controller' => 'mis_productos',
          'action' => 'promociones'
        ), array(
          'class' => 'btn btn-xs btn-blue',
          //'data-toggle' => 'slidemodal',
          // 'data-slide' => 5,
        ));
      ?>
    </div>
  </div>
</div>