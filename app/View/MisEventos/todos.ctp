<?php
  echo $this->element('empresas/title');
?>

<div class="alert alert-info">
  A continuaci&oacute;n se muestran todos los Eventos que se han creado en su compa&ntilde;ia. Recuerde que para realizar acciones sobre los Eventos,
  usted deber&aacute; ser el creador del mismo.
</div>

<table class="table table-bordered" data-table-role="main" id="table-eventos" data-component="dynamic-table">
  <thead>
    <tr class='table-header'>
      <th colspan="9">
        <div class="pull-left btn-actions">

        </div>
        <div id="filters" class="pull-right"></div>
      </th>
    </tr>
    <tr>
      <th data-table-prop=":input" data-table-order="none"><input type="checkbox" class="master"></th>
      <th data-table-prop="#tmpl-nombre">Nombre</th>
      <th data-table-prop="tipo">Tipo de Evento</th>
      <th data-table-prop="#tmpl-inicio">Fecha de Inicio</th>
      <th data-table-prop="#tmpl-termino">Fecha de Término</th>
    </tr>
  </thead>
  <tbody>
  </tbody>
</table>

<?php
  echo $this->Template->insert(array(
    'nombre',
    'acciones',
    'inicio',
    'termino'
  ));
?>
