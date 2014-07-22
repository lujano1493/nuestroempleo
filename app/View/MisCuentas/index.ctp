<?php
  echo $this->element('empresas/title');
?>

<div class="alert alert-info">
  <?php echo __('En esta sección podrá administrar a los usuarios que utilizan la aplicación, administrar sus productos adquiridos y consultar reportes en tiempo real.'); ?>
</div>

<div class="row">
  <div class="col-xs-8 resume">
    <i class="icon-building"></i>Datos de la Empresa
    <ul class="span-right">
      <li>
        <strong><?php echo __('Empresa'); ?></strong>
        <span><?php echo $this->Session->read('Auth.User.Empresa.cia_razonsoc'); ?></span>
      </li>
      <li>
        <strong><?php echo __('Usuario'); ?></strong>
        <span><?php echo $this->Session->read('Auth.User.fullName'); ?></span>
      </li>
      <li>
        <strong><?php echo __('Perfil'); ?></strong>
        <span><?php echo $this->Session->read('Auth.User.Perfil.per_descrip'); ?></span>
      </li>
      <li>
        <strong><?php echo __('Producto'); ?></strong>
        <span><a href="/mis_productos/historico">Ver detalles</a></span>
      </li>
      <li>
        <strong><?php echo __('Socio'); ?></strong>
        <span><?php echo $this->Session->read('Auth.User.Empresa.cia_cve'); ?></span>
      </li>
      <li>
        <strong><?php echo __('Socio desde'); ?></strong>
        <span>
          <?php
            $since = $this->Session->read('Auth.User.created');
            echo $this->Time->d($since);
          ?>
        </span>
      </li>
    </ul>
  </div>
  <!-- <div class="col-xs-4"></div> -->
  <div class="col-xs-4">
    <div class="btn-actions">
      <?php
        echo $this->Html->spanLink(__('¿Quieres ser una una Empresa Premium?'), array(
          'controller' => 'mis_cuentas',
          'action' => 'premium'
        ), array(
          'class' => 'btn btn-purple btn-multiline btn-block',
          'icon' => 'star icon-2x'
        ));
        echo $this->Html->spanLink(__('Contacta a un Ejecutivo'), '#contacto-ejecutivo', array(
          'data-toggle' => 'modal',
          'class' => 'btn btn-lg btn-blue btn-multiline btn-block',
          'icon' => 'question icon-2x'
        ));
      ?>
    </div>
  </div>
</div>
<div class="row-fluid">
  <h5 class="subtitle">
    <i class="icon-tasks"></i><?php echo __('Resumen Rápido'); ?>
  </h5>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th style="width:450px;"></th>
        <!-- <th><?php echo __('Incluídos'); ?></th> -->
        <th><?php echo __('Utilizados'); ?></th>
        <th><?php echo __('Disponibles'); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php
        $creditos = $this->Session->read('Auth.User.Creditos');
        foreach ($creditos as $key => $value) {
          $infinitos = (bool)$value['creditos_infinitos'];
          $disponibles = $infinitos ? __('Créditos Ilimitados') : $value['disponibles'];
      ?>
        <tr>
          <td><?php echo $value['nombre']; ?></td>
          <!-- <td class="bg-blue"><?php echo $value['ocupados'] + $value['disponibles']; ?></td> -->
          <td class="bg-red"><?php echo $value['ocupados']; ?></td>
          <td class="bg-green"><?php echo $disponibles; ?></td>
        </tr>
      <?php
        }
      ?>
    </tbody>
  </table>
</div>
<div class="usuarios-recientes">
  <h5 class="subtitle">
    <i class="icon-sitemap"></i><?php echo __('Últimas cuentas creadas'); ?>
  </h5>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th style="width:450px;"><?php echo __('Nombre'); ?></th>
        <!-- <th>Inclu&iacute;dos</th> -->
        <th><?php echo __('Correo Electrónico'); ?></th>
        <th><?php echo __('Perfil'); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php
        foreach ($cuentas as $k => $v):
          $u = $v['UsuarioEmpresa'];
          $c = $v['Contacto'];
          $p = $v['Perfil'];
      ?>
        <tr>
          <td><?php echo $c['nombre']; ?></td>
          <td>
            <?php
              echo $this->Html->link($u['cu_sesion'], array(
                'controller' => 'mis_cuentas',
                'action' => 'perfil',
                'id' => $u['cu_cve'],
                'slug' => Inflector::slug($u['cu_sesion'], '-')
              ), array(
              ));
            ?>
          </td>
          <td><?php echo $p['per_nom']; ?></td>
        </tr>
      <?php endforeach ?>
    </tbody>
  </table>
</div>

<?php echo $this->element('empresas/contacto_ejecutivo'); ?>