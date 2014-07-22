<div id="evaluacion-preview" class="preview slidemodal" data-slide-from="right">
  <a href="#" class="close" data-close="slidemodal">&times;</a>
  <div class="slidemodal-dialog only-slidemodal-body">
    <div class="slidemodal-body">
      <div class="container">
        <h1 class="title"><?php echo __('Vista previa'); ?></h1>
        <?php
          $new = !isset($this->request->data['Evaluacion']);
          echo $this->element('empresas/evaluaciones/actions', array(
            'actions' => array(
              'submit'
            ),
            'evaluacion' =>  $new ? false : $this->request->data['Evaluacion']
          ));
        ?>
        <div class="row">
          <div class="col-xs-7 col-md-offset-1 preview-content">
            <div class="header">
              <h4>
                <strong data-name="evaluacion-title">
                  <?php echo __('El título de la evaluación'); ?>
                </strong>
              </h4>
            </div>
            <div class="row">
              <div class="col-xs-8">
                <div class="input text ">
                  <label><?php echo __('Nombre'); ?></label>
                  <span class="form-control input-sm input-block-level"></span>
                </div>
              </div>
              <div class="col-xs-4">
                <div class="input text ">
                  <label><?php echo __('Fecha'); ?></label>
                  <span class="form-control input-sm input-block-level"></span>
                </div>
              </div>
            </div>
            <ol class="preguntas-container decimal"></ol>
          </div>
          <div class="col-xs-3">
            <h5 class="subtitle">
              <i class="icon-align-justify"></i><?php echo __('Breve Descripción'); ?>
            </h5>
            <ul class="list-unstyled">
              <li>
                <div data-name="evaluacion-desc"><?php echo __('Aquí va la descripción'); ?></div>
              </li>
              <li>
                <?php echo __('Creador: %s', $this->Session->read('Auth.User.fullName')); ?>
              </li>
              <li>
                <?php
                  $date = $new ? null : $this->request->data['Evaluacion']['created'];
                  echo __('Fecha: %s', $this->Time->d($date));
                ?>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>