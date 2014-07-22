<?php
  echo $this->element('empresas/title');
?>
<div class="alert alert-info">
  Seleccione la evaluación a asignar.
</div>
<table class="table table-bordered" data-table-role="main" id="table-ofertas" data-component="dynamic-table"
  data-source-url="/mis_evaluaciones/publicas.json">
  <thead>
    <tr class='table-header'>
      <th colspan="5">
        <div class="pull-left btn-actions">
          <?php
            echo $this->Html->link('Crear nueva Evaluación', array(
              'controller' => 'mis_evaluaciones',
              'action' => 'nueva'
            ), array(
              'class' => 'btn btn-sm btn-purple',
              'icon' => 'asterisk'
            ));

            echo $this->Html->link('Mis Evaluaciones', array(
              'controller' => 'mis_evaluaciones',
              'action' => 'index'
            ), array(
              'class' => 'btn btn-sm btn-blue',
              'icon' => 'pencil'
            ));
          ?>
        </div>
        <div id="filters" class="pull-right"></div>
      </th>
    </tr>
    <tr>
      <th data-table-prop=":radio" data-table-order="none"></th>
      <th data-table-prop="tipo.texto">Tipo</th>
      <th data-table-prop="#tmpl-nombre">Evaluaci&oacute;n</th>
      <th data-table-prop="created">Fecha de Creaci&oacute;n</th>
      <th data-table-prop="usuario.nombre">Usuario</th>
    </tr>
  </thead>
  <tbody>
  </tbody>
</table>

<div class="alert alert-info">
  A continuación, seleccione al Candidato o Candidatos a los que desea asignar la Evaluación. Recuerde
  adquirir antes los CV ́s de su interés.
</div>
<?php
  $dataSelected = '';
  if (!empty($itemId)) {
    $dataSelected = 'data-selected-items=\'' . implode(',', array((int)$itemId)) . '\'';
  }
?>
<table class="table table-bordered" data-table-role="users" data-component="dynamic-table"
  data-source-url="/mis_candidatos/adquiridos.json" <?php echo $dataSelected; ?>>
  <thead>
    <tr  class="table-header">
      <th colspan="6">
        <div class="pull-right" id="filters"></div>
      </th>
    </tr>
    <tr>
      <th data-table-prop=":input" data-table-order="none"><input type="checkbox" class="master"></th>
      <th data-table-prop="#tmpl-foto"></th>
      <th data-table-prop="datos.nombre" width='320'>Nombre</th>
      <th data-table-prop="perfil">Perfil</th>
      <th data-table-prop="datos.ubicacion">Ubicaci&oacute;n</th>
    </tr>
  </thead>
  <tbody>

  </tbody>
</table>
<div class="btn-actions">
  <div class="alert alert-warning">
    <strong>Seleccione el tiempo máximo de espera de respuesta por parte del (los) Candidato(s):
    <?php
      echo $this->Form->input('plazo', array(
        'label' => false,
        'div' => false,
        'options' => array('1' => 1, '2' => 2, '5' => 5, '7' => 7, '10' => 10)
      ));
    ?>
    Días
    </strong>
  </div>

  <?php
    echo $this->Html->link('Asignar', $this->here, array(
      'data-action-role' => 'submit',
      'class' => 'btn btn-lg btn-success nofication-emit',
    ));
  ?>
</div>

<div id="success" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">&Eacute;xito</h4>
      </div>
      <div class="modal-body">
        <p><?php echo __('La evaluación se ha enviado con éxito.') ?></p>
      </div>
      <div class="modal-footer">
        <a href="/mis_evaluaciones" class="btn btn-sm btn-primary">Aceptar</a>
      </div>
    </div>
  </div>
</div>

<?php
  echo $this->Template->insert(array(
    'nombre__gestion',
    'foto'
  ));

  $this->AssetCompress->script('evaluacion.js', array(
    'inline' => false
  ));
?>