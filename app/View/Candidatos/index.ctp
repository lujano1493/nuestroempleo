<?php
  echo $this->element('empresas/title', array(
    'busqueda' => 'avanzada'
  ));

    $data_conditions= array();

    foreach ($param_query as $key => $value) {
        $data_conditions[]=array("name"=>$key,"value" => $value );
    }


?>



   <?=$this->element("empresas/candidatos/filtros",array(
              "tipo_" => "ajax"
        ) ) ?>




<div class="row">
  <div class="col-xs-12">
    <table id="busqueda-candidato" class="table table-bordered" data-show-menu-length="[20]"  data-display-length="20"  data-server-side="true"
            data-table-role="main" data-component="dynamic-table"   data-params-ini='<?=json_encode($data_conditions)?>' data-source-url="/candidatos/candidatos">
      <thead>
        <tr class="table-header">
          <th colspan="6">
            <div class="pull-left btn-actions">
              <?php
                echo $this->Html->link('Guardar en', array(
                  'controller' => 'mis_candidatos',
                  'action' => 'guardar_en'
                ), array(
                  'class' => 'btn btn-sm btn-aqua',
                  'data-component' => 'folderito',
                  'data-source' => '/carpetas/candidatos.json',
                  'data-controller' => 'mis_candidatos',
                  'icon' => 'folder-close',
                  'after' => true
                ));
              ?>
            </div>
            <div id="filters" class="pull-right"></div>
          </th>
        </tr>
        <tr>
          <th data-table-prop=":input" data-table-order="none"><input type="checkbox" class="master"></th>
          <th data-table-prop="#tmpl-foto" data-table-order="none" width='100'></th>
          <th data-table-prop="#tmpl-perfil">Perfil</th>
          <th data-table-prop="#tmpl-sueldo">Sueldo</th>
          <th data-table-prop="#tmpl-experiencia">Experiencia Laboral</th>
          <th data-table-prop="#tmpl-estudios">Estudios</th>
        </tr>
      </thead>
      <tbody class="searchable">

      </tbody>
    </table>
  </div>
</div>

<?php
  echo $this->Template->insert(array(
    'foto',
    'perfil',
    'sueldo',
    'experiencia',
    'estudios',
    'acciones__index'
  ), null, array(
    'viewPath' => 'MisCandidatos'
  ));
?>