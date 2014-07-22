<?php
  echo $this->element('empresas/title');
?>

<div class="row">
  <div class="col-xs-8">
    <div class="row">
      <div class="col-xs-6 resume">
        <i class="icon-building"></i><?php echo __('Datos de la Empresa'); ?>
        <ul class="">
          <li>
            <strong>Empresa</strong>
            <span><?php echo $authUser['Empresa']['cia_razonsoc']; ?></span>
          </li>
          <li>
            <strong>R.F.C.</strong>
            <span><?php echo $authUser['Empresa']['cia_rfc']; ?></span>
          </li>
          <li>
            <strong>Giro</strong>
            <span><?php echo $authUser['Empresa']['giro_nombre']; ?></span>
          </li>
          <li>
            <strong>Domicilio</strong>
            <span><?php echo $direccion; ?></span>
          </li>
          <?php
            $tel = $authUser['Contacto']['con_tel'];
            $ext = empty($authUser['Contacto']['con_ext']) ? '--' : $authUser['Contacto']['con_ext'];
            if (!empty($tel)) {
          ?>
            <li>
              <strong>Tel. de Contacto</strong>
              <span>
                <?php
                  echo __('%s Ext. %s', $tel, $ext);
                ?>
              </span>
            </li>
          <?php
            }
          ?>
        </ul>
      </div>
      <div class="col-xs-6 resume">
        <i class="icon-align-justify"></i><?php echo __('Datos de la Cuenta'); ?>
        <ul class="span-right">
          <li>
            <strong><?php echo __('Producto'); ?></strong>
            <span>
              <?php
                if ($authUser['Perfil']['membresia_cls'] === 'mbs') {
                  echo __('Membresía %s', $authUser['Perfil']['membresia']);
                } else {
                  echo $authUser['Perfil']['membresia'];
                }
              ?>
            </span>
          </li>
          <li>
            <strong><?php echo __('Socio'); ?></strong>
            <span><?php echo $authUser['Empresa']['cia_cve']; ?></span>
          </li>
          <li>
            <strong><?php echo __('Socio desde'); ?></strong>
            <span>
              <?php
                $since = $authUser['created'];
                echo $this->Time->d($since);
              ?>
            </span>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <div class="col-xs-4">
    <div class="btn-actions">
      <?php
        echo $this->Html->spanLink(__('Mis Facturas'), array(
          'controller' => 'mis_productos',
          'action' => 'facturas'
        ), array(
          'class' => 'btn btn-orange btn-block btn-multiline',
          'icon' => 'file icon-2x',
        ));
      ?>
    </div>
  </div>
</div>
<?php
  $credits = $this->Session->read('Auth.User.Creditos');
  //debug($credits);
?>
<div class="row">
  <div class="col-xs-12">
    <h5 class="subtitle">
      <i class="icon-tasks"></i><?php echo __('Resumen de la Cuenta'); ?>
    </h5>
    <table class="table table-bordered text-center">
      <thead>
        <tr>
          <th style="width:400px;"></th>
          <th><?php echo __('Utilizados'); ?></th>
          <th><?php echo __('Disponibles'); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php
          foreach ($credits as $key => $value) :
            $ocupados = $value['ocupados'];
            $infinitos = (bool)$value['creditos_infinitos'];
            $disponibles = $infinitos ? __('Créditos Ilimitados') : $value['disponibles'];
            if ((bool)$value['visible']) {
        ?>
          <tr>
            <td><?php echo $value['nombre']; ?></td>
            <td class=""><?php echo $ocupados; ?></td>
            <td class="">
              <?php
                echo $this->Html->tag('span', $disponibles, array(
                  'data' => array(
                    'credit-handler' => $value['identificador'],
                    'credits' => $disponibles
                  )
                ));
              ?>
            </td>
          </tr>
        <?php
            }
          endforeach
        ?>
      </tbody>
    </table>
  </div>
</div>
<?php echo $this->element('empresas/servicios/slides'); ?>