<div class="preview" id="evento-preview">
  <a href="#" class="close" data-slide-nav="0">&times;</a>
  <div class="container">
    <h1 class="title"><?php echo __('Vista Previa'); ?></h1>
    <div class="row">
      <div class="col-xs-7 col-md-offset-1 preview-content">
        <div class="header">
          <h5>
            <strong data-name="evaluacion-title">
              <?php
                $ciaRazonSocial = $this->Session->read('Auth.User.Empresa.cia_razonsoc');
                echo $ciaRazonSocial;
              ?>
            </strong>
          </h5>
          <strong class="block" data-name="evento-name"><?php echo __('Título del Evento'); ?></strong>
          <span class="block" data-name="evento-type"><?php echo __('Tipo de Evento'); ?></span>
        </div>
        <div class="preview-pane">
          <h5 class="preview-title">
            <?php echo __('Descripción'); ?>
          </h5>
          <div data-name="evento-desc">
            <?php echo __('Aquí se mostrará la descripción del Evento'); ?>
          </div>
        </div>
        <div class="preview-pane">
          <h5 class="preview-title">
            <?php echo __('Lugar'); ?>
          </h5>
          <span class="block" data-name="evento-calle"><?php echo __('Dirección del Evento'); ?></span>
          <span class="block" data-name="evento-dir"><?php echo __('Ciudad del Evento'); ?></span>
        </div>
        <div class="preview-pane">
          <h5 class="preview-title">
            <?php echo __('Duración'); ?>
          </h5>
          <span class="block" data-name="evento-start"><?php echo __('Fecha y Horario de Inicio'); ?></span>
          <span class="block" data-name="evento-end"><?php echo __('Fecha y Horario de Término'); ?></span>
        </div>
      </div>
      <div class="col-xs-3">
        <h5 class="subtitle">
          <i class="icon-map-marker"></i><?php echo __('Referencias de Ubicación'); ?>
        </h5>
        <div id="map-canvas-preview" style="width:100%; height:200px;"></div>
        <div class="well">
          <p>
            <?php echo __('Si deseas mayor información del evento, puedes comunicarte con:'); ?>
          </p>
          <address>
            <?php
              $name = $this->Session->read('Auth.User.fullName');
              $email = $this->Session->read('Auth.User.cu_sesion');
              echo $this->Html->link('', '#', array(
                'tags' => array(
                  array('strong', $name)
                )
              ));
            ?>
            <br>
            <?php
              echo $this->Html->link($email, '#', array());
            ?>
          </address>
        </div>
      </div>
    </div>
  </div>
</div>