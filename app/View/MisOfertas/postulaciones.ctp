<?php
  echo $this->element('empresas/title');
?>

<?php //echo $this->element('empresas/candidatos/filtros'); ?>
<?php if ($_nolayout): ?>
  <div class="btn-actions">
    <?php echo $this->Html->back(); ?>
  </div>
<?php endif ?>
<div class="row">
  <div class="col-xs-12">
    <table class="table table-bordered" data-table-role="main" data-component="dynamic-table" data-source-url="<?php echo $this->here . '.json'; ?>">
      <thead>
        <tr  class="table-header">
          <th colspan="7">
            <div class="pull-left btn-actions">
              <div class="folders-btn inline">
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
              <?php
                if ($this->params['action'] !== 'favoritos') {
                  echo $this->Html->link('Marcar como Favorito', array(
                    'controller' => 'mis_candidatos',
                    'action' => 'favorito'
                  ), array(
                    'class' => 'btn btn-sm btn-yellow',
                    'data-component' => 'ajaxlink',
                    'data-ajaxlink-multi' => true,
                    'data-success-callback' => 'favoriteRow',
                    'icon' => 'star',
                    'after' => true
                  ));
                }
              ?>

            </div>
            <div class="pull-right" id="filters"></div>
          </th>
        </tr>
        <tr>
          <th data-table-prop=":input" data-table-order='none'><input type="checkbox" class="master"></th>
          <th data-table-prop="#tmpl-foto" data-table-order='none' width='100'></th>
          <th data-table-prop="#tmpl-perfil" width='220'>Perfil</th>
          <th data-table-prop="#tmpl-sueldo">Sueldo</th>
          <th data-table-prop="#tmpl-experiencia">Experiencia</th>
          <th data-table-prop="#tmpl-estudios">Estudios</th>
          <th data-table-prop="#tmpl-carpetas">Guardado</th>
          <th data-table-prop="#tmpl-fecha" width="120" data-order="desc">Fecha de postulación</th>
          
        </tr>
      </thead>
      <tbody></tbody>
    </table>
  </div>
</div>

<?php
  echo $this->Template->insert(array(
    'foto',
    'perfil__postulacion',
    'sueldo',
    'experiencia',
    'estudios',
    'acciones__index' => 'acciones-postulados',
    'fecha__postulacion' => 'fecha',
    'carpetas'
  ), null, array(
    'viewPath' => 'MisCandidatos'
  ));
?>