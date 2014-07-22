<?php
  echo $this->element('empresas/title');
?>

<p class="well well-small info">
  Las <strong>ofertas activas</strong> se encuentran actualmente publicadas y pueden recibir postulaciones.
  Las ofertas permanecen en este estado hasta <strong>30 d&iacute;as</strong>. Una vez vencido este plazo,
  pasan autom&aacute;ticamente a <strong>ofertas inactivas</strong>.
</p>

<table class="table table-striped table-bordered" data-table-role="main" id="table-ofertas" data-component="dynamic-table">
  <thead>
    <tr class='table-header'>
      <th colspan="9">
        <div class="pull-left">
          <?php
            echo $this->Html->link('Guardar', array(
              'controller' => 'mis_ofertas',
              'action' => 'nueva'
            ), array(
              'class' => 'btn btn-sm btn-blue',
              'icon' => 'folder-close',
              'after' => true
            ));
          ?>
          <?php
            echo $this->Html->link('Crear una oferta', array(
              'controller' => 'mis_ofertas',
              'action' => 'nueva'
            ), array(
              'class' => 'btn btn-sm btn-purple',
              'icon' => 'edit',
              'after' => true
            ));
          ?>
        </div>
        <div id="filters" class="pull-right"></div>
      </th>
    </tr>
    <tr>
      <th data-table-prop=":input" data-table-order="none"><input type="checkbox" class="master"></th>
      <th data-table-prop="usuario.email">Usuario</th>
      <th data-table-prop="codigo">C&oacute;digo</th>
      <th data-table-prop="#tmpl-nombre">Nombre</th>
      <th data-table-prop="fecha_creacion.str">Fecha de Creaci&oacute;n</th>
      <th data-table-prop="vigencia">Vigencia</th>
      <th data-table-prop="">Postulaciones</th>
      <th data-table-prop="status.html">Status</th>
    </tr>
  </thead>
  <tbody>

  </tbody>
</table>

<div data-alert-before-send='unshare'>
  <p>
    La opción <strong>Dejar de Compartir</strong> elimina su oferta de la carpeta Ofertas Compartidas y ningún
    usuario de su Compañía tendrá acceso a ésta.
  </p>
  <br>
  <strong>¿Está seguro realizar esta acción?</strong>
</div>

<?php
  echo $this->Template->insert(array(
    'nombre',
    'acciones__compartidas'
  ));
?>