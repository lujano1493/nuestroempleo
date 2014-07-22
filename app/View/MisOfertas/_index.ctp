<?php
  echo $this->element('empresas/title');
?>

<!-- <div class="well well-small info">
  Las <strong>ofertas activas</strong> se encuentran actualmente publicadas y pueden recibir postulaciones.
  Las ofertas permanecen en este estado hasta <strong>30 d&iacute;as</strong>. Una vez vencido este plazo,
  pasan autom&aacute;ticamente a <strong>ofertas inactivas</strong>.
</div> -->
<?php echo $this->element('empresas/ofertas/stats'); ?>

<div class="ofertas-activas">
  <h5 class="subtitle">
    <i class="icon-file-text"></i><?php echo __('Ofertas Activas'); ?>
  </h5>
  <div class="row">
    <div class="col-xs-12">
      <table class="table table-bordered" data-table-role="main" id="table-ofertas" data-component="dynamic-table">
        <thead>
          <tr class='table-header'>
            <th colspan="9">
              <div class="pull-left btn-actions">
                <div class="folders-btn inline">
                  <?php
                    echo $this->Html->link(__('Guardar en'), array(
                      'controller' => 'mis_ofertas',
                      'action' => 'guardar_en'
                    ), array(
                      'class' => 'btn btn-sm btn-blue',
                      'data-component' => 'folderito',
                      'data-source' => '/carpetas/ofertas.json',
                      'data-controller' => 'mis_ofertas',
                      'icon' => 'folder-close',
                    ));
                  ?>
                </div>
                <?php
                  echo $this->Html->link(__('Pausar'), array(
                    'controller' => 'mis_ofertas',
                    'action' => 'pausar'
                  ), array(
                    'class' => 'btn btn-sm btn-default',
                    'data' => array(
                      'component' => 'ajaxlink',
                      'ajaxlink-multi' => true,
                      'ajaxlink-target' => 'view:menu-ofertas'
                    ),
                    'icon' => 'pause',
                  ));
                ?>
              </div>
              <div id="filters" class="pull-right"></div>
            </th>
          </tr>
          <tr>
            <th data-table-prop=":input" data-table-order="none"><input type="checkbox" class="master"></th>
            <th data-table-prop="codigo"><?php echo __('Código'); ?></th>
            <th data-table-prop="#tmpl-nombre"><?php echo __('Nombre de la Oferta'); ?></th>
            <th data-table-prop="#tmpl-fecha-creacion" data-order='desc'><?php echo __('Fecha de Creación'); ?></th>
            <th data-table-prop="vigencia"><?php echo __('Vigencia'); ?></th>
            <th data-table-prop="#tmpl-postulaciones" data-data-type="numeric"><?php echo __('Postulaciones') ?></th>
            <th data-table-prop="status.html"><?php echo __('Tipo de publicación'); ?></th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>
</div>

<div data-alert-before-send='share'>
  <p>
    La opción <strong>Compartir</strong> hará que su publicación sea vista por todos los usuarios de su Compañía,
    se copiará en la carpeta Ofertas Compartidas y todas las cuentas tendrán acceso a esta oferta.
  </p>
  <br>
  <strong>¿Está seguro realizar esta acción?</strong>
</div>

<?php
  echo $this->Template->insert(array(
    'nombre',
    'postulaciones',
    'fecha-creacion',
    'acciones__index'
  ));
?>