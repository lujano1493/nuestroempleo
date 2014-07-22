<?php
  echo $this->element('empresas/title');
?>

<?php
  $credits = $this->Session->read('Auth.User.Creditos');
  //debug($credits);
?>
<div class="row">
  <div class="col-xs-12">
    <h5 class="subtitle">
      <i class="icon-tasks"></i><?php echo __('Resumen Rápido'); ?>
    </h5>
    <table class="table table-bordered text-center">
      <thead>
        <tr>
          <th style="width:400px;"></th>
          <!-- <th><?php echo __('Incluidos'); ?></th> -->
          <th><?php echo __('Utilizados'); ?></th>
          <th><?php echo __('Disponibles'); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php
          foreach ($credits as $key => $value) :
            if ((int)$value['visible'] === 0) {
              continue;
            }
            $ocupados = $value['ocupados'];
            $infinitos = (bool)$value['creditos_infinitos'];
            $disponibles = $infinitos ? __('Créditos Ilimitados') : $value['disponibles'];
        ?>
          <tr>
            <td><?php echo $value['nombre']; ?></td>
            <!-- <td class="bg-blue"><?php echo $ocupados + $disponibles; ?></td> -->
            <td class="bg-red"><?php echo $ocupados; ?></td>
            <td class="bg-green">
              <?php
                echo $this->Html->tag('span', $disponibles, array(
                  'data' => array(
                    'credit-handler' => $value['identificador'],
                    'credits' => $infinitos ? 'infinity' : $disponibles
                  )
                ));
              ?>
            </td>
          </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  </div>
</div>
<div class="row">
  <div class="col-xs-12">
    <div class="alert alert-info text-center">
      <?php echo __('Asigne o recupere los créditos que considere convenientes.'); ?>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-xs-12">
    <?php
      echo $this->Form->create('Creditos', array(
        'class' => 'no-lock',
        'id' => 'CreditosForm'
      ));
    ?>
    <table id="credits-handler" class="table table-bordered text-center">
      <thead>
        <tr class="table-header">
          <th colspan="7">
            <div class="btn-actions text-right">
              <?php
                echo $this->Html->link(__('Actualizar'), array(), array(
                  'class' => 'btn btn-sm btn-purple',
                  'data' => array(
                    'submit' => true,
                    'submit-value' => 'credits'
                  ),
                  'icon' => 'refresh'
                ));
              ?>
            </div>
          </th>
        </tr>
        <tr>
          <th style="width:300px;"></th>
          <th style="width:200px;"><?php echo __('Producto'); ?></th>
          <!-- <th><?php echo __('Incluidos'); ?></th> -->
          <th><?php echo __('Utilizados'); ?></th>
          <th><?php echo __('Disponibles'); ?></th>
          <th class="sm"><?php echo __('Asignar'); ?></th>
          <th class="sm"><?php echo __('Recuperar'); ?></th>
        </tr>
      </thead>
      <?php $theadClass = 'hidden'; ?>
      <tbody>
        <?php
          $count = count($cuentas);
          foreach ($cuentas as $k => $v) :
            $creditosByUser = $v['Creditos'];
            $userID = $v['UsuarioEmpresa']['cu_cve'];
        ?>
          <?php
            $rows = count($creditosByUser);
            $isFirst = true;
            foreach ($creditosByUser as $key => $val) :
              if ((int)$val['visible'] === 0) {
                continue;
              }
              $ocupados = $val['ocupados'];
              $disponibles = $val['disponibles'];
              $identificador = $val['identificador'];
          ?>
            <tr class="credit-row-handler">
              <?php if ($isFirst) : ?>
                <td rowspan="<?php echo $rows; ?>">
                  <?php
                    echo $this->Form->input("Usuarios.$k.id", array(
                      'type' => 'hidden',
                      'value' => $userID
                    ));
                  ?>
                  <ul class="list-unstyled">
                    <li>
                      <?php echo $v['Contacto']['nombre']; ?>
                    </li>
                    <li>
                      <?php echo $v['UsuarioEmpresa']['cu_sesion']; ?>
                    </li>
                    <li>
                      <?php echo $v['Perfil']['per_descrip']; ?>
                    </li>
                  </ul>
                </td>
              <?php
                  $isFirst = false;
                endif;
              ?>
              <td><?php echo $val['nombre']; ?></td>
              <!-- <td>
                <span class="label label-blue"><?php echo $ocupados + $disponibles; ?></span>
              </td> -->
              <td>
                <span class="label label-red"><?php echo $ocupados; ?></span>
              </td>
              <td>
                <?php
                  $inputName = implode('.', array(
                    'Usuarios', $k, 'Creditos', 'asignados', $identificador
                  ));

                  $inputNameRecover = implode('.', array(
                    'Usuarios', $k, 'Creditos', 'recuperados', $identificador
                  ));

                  echo $this->Form->label($inputName, $disponibles, array(
                    'class' => 'label label-green',
                    'data' => array(
                      'credits' => $disponibles,
                      'item-id' => $k . '-' . $identificador
                    )
                  ));

                ?>
              </td>
              <td class="sm">
                <?php
                  echo $this->Form->input($inputName, array(
                    'class' => 'form-control input-sm',
                    'data' => array(
                      'credit-assign' => $identificador,
                      'item-id' => $k . '-' . $identificador
                    ),
                    'label' => false,
                    'type' => 'number',
                    'min' => 0,
                    'max' => $infinitos ? 1000 : null,
                    'value' => 0
                  ));
                ?>
              </td>
              <td class="sm">
                <?php
                  echo $this->Form->input($inputNameRecover, array(
                    'class' => 'form-control input-sm',
                    'data' => array(
                      'credit-recover' => $identificador,
                      'item-id' => $k . '-' . $identificador
                    ),
                    'label' => false,
                    'type' => 'number',
                    'min' => 0,
                    // 'max' => $disponibles,
                    'value' => 0
                  ));
                ?>
              </td>
            </tr>
          <?php
            endforeach;
            if ($k < ($count - 1)) :
          ?>
            <tr class="separator">
              <td colspan="7"></td>
            </tr>
          <?php
            endif;
          endforeach;
        ?>
      </tbody>
    </table>
    <?php
      // echo $this->Form->submit("Enviar");
    ?>
    <?php echo $this->Form->end(); ?>
  </div>
</div>

<?php
  $this->AssetCompress->addScript(array(
    'app/creditos.js'
  ),
    'credits.js'
  );
?>
