<div class="ofertas-sociales">
  <h5 class="subtitle">
    <i class="icon-file-text"></i><?php echo __('Eventos para Compartir en Facebook'); ?>
  </h5>

  <div class="row">
    <div class="col-xs-12">
         <div class="pull-left btn-actions">
              <?php

                if( !$userFacebok ){
                    echo $this->Html->link(__('Ingreso Facebook'), $login_fc , array(
                      'class' => 'btn btn-sm btn-blue',
                      'icon' => 'key',
                      'after' => true
                    ));
                }  
                else   {
                       echo $this->Html->link(__('Cerrar Facebook'), $logout_fc , array(
                      'class' => 'btn btn-sm btn-danger',
                      'icon' => 'close',
                      'after' => true
                    ));


                }

                  if( !$status_tw ){
                    echo $this->Html->link(__('Ingreso Twitter'), $login_tw , array(
                      'class' => 'btn btn-sm btn-blue',
                      'icon' => 'key',
                    ));
                }  
                else   {
                       echo $this->Html->link(__('Cerrar Twitter'), $logout_tw , array(
                      'class' => 'btn btn-sm btn-danger',
                      'icon' => 'close',
                    ));


                }

              ?>
                </div>
      
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <table class="table table-bordered" data-table-role="main" id="table-ofertas" data-component="dynamic-table" width="100%">
        <thead>
           <tr  class="table-header">
              <th colspan="7">
             
              <div class="pull-right" id="filters"></div>
            </th>
          </tr>                    
          <tr>
          <!--   <th data-table-prop=":input" data-table-order="none" width="5%"><input type="checkbox" class="master"></th> -->
           <!--  <th data-table-prop="codigo"><?php echo __('Codigo'); ?></th> -->
            <th data-table-prop="#tmpl-nombre" width="15%"><?php echo __('Nombre'); ?></th>                  
            <th data-table-prop="empresa"   width="10%"><?php echo __('Compañia'); ?></th>      
            <th data-table-prop="#tmpl-fecha"  width="15%" ><?php echo __('Fecha y Hora'); ?></th>
            <th data-table-prop="#tmpl-link"  width="10%"><?php echo __('Link'); ?></th>       
            <th data-table-prop="#tmpl-compartir-sociales" width="15%"><?php echo __('Compartir'); ?></th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>
</div>


<?php
  echo $this->Template->insert(array(      
    'fecha__evento' => 'fecha',
    'nombre__evento'=>  'nombre',
    'detalles__evento' => 'detalles-evento',
    'compartir__sociales' => 'compartir-sociales',
    'link'
  ), null, array(
    'folder' => 'admin'
  ));
?>