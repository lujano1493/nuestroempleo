<?php
  echo $this->element('admin/title');
?>

<div class="row">
  <div class="col-xs-9">
    <div id="init-chart"></div>
  </div>
  <div class="col-xs-3">
    <div class="btn-actions">
      <?php
        echo $this->Html->link(__('Productos'), array(
          'admin' => $isAdmin,
          'controller' => 'productos',
          'action' => 'index'
        ), array(
          'class' => 'btn btn-blue btn-block',
          'icon' => 'book'
        ));
      ?>
    </div>
    <h5 class="subtitle">
      <?php echo __('Últimos Convenios Cerrados'); ?>
    </h5>
    <ul class="list-unstyled">
      <?php foreach ($last_convenios as $key => $value): ?>
        <li>
          <?php
            $e = $value['Empresa'];
            echo $this->Html->link(__('<strong>%s</strong>', $e['cia_nombre']), array(
              'admin' => $isAdmin,
              'controller' => 'convenios',
              'action' => 'condiciones',
              'id' => $e['cia_cve'],
              'slug' => Inflector::slug($e['cia_nombre'], '-')
            ), array(
              'escape' => false,
            ));
          ?>
          <small><?php echo $this->Time->d($value['Empresa']['created']); ?></small>
        </li>
      <?php endforeach ?>
    </ul>
  </div>
</div>

<div class="row">
  <div class="col-xs-12">
    <h5 class="subtitle">
      <?php echo __('Últimas Empresas registradas'); ?>
    </h5>
    <?php
      echo $this->element('admin/last_empresas');
    ?>
  </div>
</div>

<?php
  // echo $this->element('admin/last_admins', array(
  //   'admins' => $last_admins ?: array()
  // ));
?>
<!-- <div class="row">
  <div class="col-xs-12">
    <?php
      // echo $this->element('admin/last_facturas');
    ?>
  </div>
</div> -->

<?php
  echo $this->AssetCompress->script('amchart.js', array(
    'inline' => false
  ));
?>
