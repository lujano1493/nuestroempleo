<div class="crumb-container border-bottom">
  <ul class="breadcrumb">
    <li>
      <?php
        $inicioTitle = $role === 'admin' ? 'Inicio' : 'Mi Espacio';
        echo $this->Html->link($inicioTitle, array(
          'controller' => 'mi_espacio',
          'action' => 'index'
        )); 
      ?>
      <span class="divider">/</span>
    </li>
    <?php if ($this->params['controller'] != 'mi_espacio' && $this->params['action'] != 'index'): ?>
      <li>
        <?php
          echo $this->Html->link($this->name, array(
            'controller' => $this->params['controller'],
            'action' => 'index'
          ));
        ?>
        <span class="divider">/</span>
      </li>
    <?php endif ?>
    <li class="active">
      <?php echo $title_for_layout; ?>
    </li>
  </ul>
  <div class="info clearfix">
    <?php $name = $this->Session->read('Auth.User.fullName'); ?>
    <p data-user-name="<?php echo $name ?>">Hola <?php
        echo $this->Html->link($name, array(
          'controller' => 'mi_espacio',
          'action' => 'mi_cuenta'
        )); 
      ?>
    </p>
    <?php 
      if (!empty($element)) {
        echo $this->element($element); 
      }
    ?>
  </div>
</div>