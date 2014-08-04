<?php
  echo $this->Form->create('Evento', array(
    'class' => 'slidemodal',
    'data' => array(
      'copycat-autoload' => true,
      'slide-from' => 'right',
      'slides' => true
    ),
    'id' => 'nuevo-evento',
    'url' => array(
      'controller' => 'mis_eventos',
      'action' => 'registrar'
    ),
  ));
?>
  <div class="slidemodal-dialog">
    <div class="slidemodal-header">
      <button type="button" class="close" data-dismiss="modal" data-close="slidemodal" aria-hidden="true">×</button>
      <h4 id="modal-title"><?php echo __('Nuevo Evento'); ?></h4>
    </div>
    <div class="slidemodal-body">
      <div class="sliding" data-navi-class="false">
        <!-- Wrapper for slides -->
        <!-- <div class="carousel-inner"> -->
          <div class="slide">
            <fieldset class="container">
              <legend><?php echo __('Ubicación'); ?></legend>
              <div class="alerts-container">
                <div class="alert alert-info">
                  <?php echo __('Capture el Código Postal del lugar donde se realizará el evento o selecciónelo en el mapa.'); ?>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-5">
                  <?php
                    echo $this->Form->hidden('id', array(
                      'data-calendar-role' => 'id',
                    ));
                    echo $this->Form->input('lat', array(
                      'data-calendar-role' => 'lat',
                      'type' => 'hidden'
                    ));
                    echo $this->Form->input('lng', array(
                      'data-calendar-role' => 'lng',
                      'type' => 'hidden'
                    ));
                    echo $this->Form->input('cp', array(
                      'class' => 'form-control input-sm input-block-level',
                      'label' => __('Código Postal'),
                      'data-calendar-role' => 'cp',
                      'after' => '<a href="#" class="locate-map" data-calendar-role="locate">Ubicar en mapa</a>'
                    ));
                    echo $this->Form->input('dir', array(
                      'class' => 'form-control input-sm input-block-level',
                      'data' => array(
                        'calendar-role' => 'dir',
                        'target-name' => 'evento-dir'
                      ),
                      'label' => __('Dirección'),
                    ));
                    echo $this->Form->input('calle', array(
                      'class' => 'form-control input-sm input-block-level',
                      'data' => array(
                        'calendar-role' => 'calle',
                        'target-name' => 'evento-calle'
                      ),
                      'label' => __('Calle y Número')
                    ));
                  ?>
                </div>
                <div class="col-xs-7">
                  <div id="map-container">
                    <div id="map-canvas" style="width:100%; height:300px;"></div>
                  </div>
                </div>
              </div>
            </fieldset>
            <fieldset class="container">
              <legend><?php echo __('Datos Generales'); ?></legend>
              <div class="row">
                <div class="col-xs-12">
                  <?php
                    echo $this->Form->input('title', array(
                      'class' => 'form-control input-sm input-block-level',
                      'data' => array(
                        'calendar-role' => 'title',
                        'msg-required' => __('Título del evento es requerido.'),
                        'rule-required' => true,
                        'target-name' => 'evento-name'
                      ),
                      'label' => __('Titulo'),
                      'required' => true,
                    ));
                    echo $this->Form->input('type', array(
                      'class' => 'form-control input-sm input-block-level',
                      'label' => __('Tipo de Evento'),
                      'data' => array(
                        'calendar-role' => 'type',
                        'target-name' => 'evento-type',
                        'source-name' => 'tipos',
                        'source-autoload' => true,
                        'source-self' => true,
                      ),
                      'options' => array(
                        'evento' => 'true'
                      )
                    ));
                    echo $this->Form->input('desc', array(
                      'class' => 'form-control input-sm input-block-level',
                      'label' => __('Descripción'),
                      'type' => 'textarea',
                      'required' => true,
                      'data' => array(
                        'calendar-role' => 'desc',
                        'msg-required' => __('Descripción del evento es requerida.'),
                        'rule-required' => true,
                        'target-name' => 'evento-desc',
                      )
                    ));
                  ?>
                  <div class="row">
                    <div class="col-xs-4">
                      <?php
                        echo $this->Form->input('start', array(
                          'class' => 'form-control input-sm input-block-level',
                          'data' => array(
                            'calendar-role' => 'start',
                            'msg-required' => __('Fecha de inicio del evento es requerida.'),
                            'rule-required' => true,
                            'target-name' => 'evento-start',
                          ),
                          'label' => __('Comienza'),
                          'id' => 'event-start',
                          'required' => true,
                        ));
                      ?>
                    </div>
                    <div class="col-xs-4">
                      <?php 
                        echo $this->Form->input('network', array(
                          'div' => array('class'=> 'block','style' =>"margin-top:25px" ),
                          'hiddenField' => false,
                           'data' => array(
                            'calendar-role' => 'network'
                          ),
                          'label' => array('text' =>__('Permitir que este Evento sea compartida en las Redes Sociales (Facebook y Twitter )'),'style'=>'display:inline'),
                          'type' => 'checkbox'
                        ));

                      ?>
                    </div>
                    <div class="col-xs-4">
                      <?php
                        echo $this->Form->input('end', array(
                          'class' => 'form-control input-sm input-block-level',
                          'data' => array(
                            'calendar-role' => 'end',
                            'msg-required' => __('Fecha de fin del evento es requerida.'),
                            'rule-required' => true,
                            'target-name' => 'evento-end',
                          ),
                          'label' => __('Finaliza'),
                          'id' => 'event-end',
                          'required' => true,
                        ));
                      ?>
                    </div>
                  </div>
                </div>
              </div>
            </fieldset>
          </div>
          <div class="slide">
            <?php echo $this->element('empresas/vista_previa/evento'); ?>
          </div>
        <!-- </div> -->
      </div>

    </div>
    <div class="slidemodal-footer footer">
      <div class="btn-actions">
        <?php
          echo $this->Form->submit(__('Aceptar'), array(
            'class' => 'btn btn-success',
            'data-calendar-role' => 'submit',
            'div' => false
          ));
          echo $this->Form->button(__('Vista Previa'), array(
            'class' => 'btn btn-aqua',
            'data-slide' => 1,
            'div' => false,
            'type' => 'button'
          ));
          echo $this->Form->button(__('Cancelar'), array(
            'aria-hidden' => 'true',
            'class' => 'btn btn-default',
            'data' => array(
              'dismiss' => 'modal',
              'close' => 'slidemodal'
            ),
            'type' => 'button'
          ));
        ?>
      </div>
    </div>
  </div>
<?php
  echo $this->Form->end();
?>

<?php
  $this->Html->script(array(
    'http://maps.googleapis.com/maps/api/js?key=' . Configure::read('google_api_key') . '&region=MX&sensor=false'
  ), array(
    'inline' => false
  ));

  $this->AssetCompress->script('calendario.js', array(
    'inline' => false
  ));
?>