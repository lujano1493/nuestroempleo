<?php
  echo $this->element('empresas/title');
  $evaluacion = $this->request->data['Evaluacion'];
?>
<?php
  echo $this->Form->create('Evaluacion', array(
    'class' => 'form-inline no-bordered no-q-time no-t-time',
    'data' => array(
      'copycat-autoload' => true,
      'opts' => '{"ignore":":hidden"}',
    ),
    'id' => 'evaluacion',
  ));
?>
  <fieldsset>
    <legend class="subtitle">
      <i class="icon-time"></i><?php echo __('Tiempo para Responder la Evaluación'); ?>
    </legend>
    <div class="row">
      <div class="col-xs-6 col-md-offset-3 text-center" data-eval-option="time">
        <?php
          $evTime = $evaluacion['evaluacion_time'];

          echo $this->Form->input('Evaluacion.tipo_tiempo', array(
            'legend' => false,
            'before' => '<div class="input radio">',
            'after' => '</div>',
            'separator' => '</div><div class="input radio">',
            'hiddenField' => false,
            'options' => array(
              'n' => 'No', 'e' => 'Por Examen', 'p' => 'Por Pregunta'
            ),
            'div' => false,
            'type' => 'radio',
            'default' => is_null($evTime) ? 'n' : ($evTime >= 1 ? 'e' : 'p')
          ));
        ?>
      </div>
    </div>
  </fieldsset>
  <fieldset>
    <legend class="subtitle">
      <i class="icon-edit-sign"></i><?php echo __('Datos Generales'); ?>
    </legend>
    <div class="row">
      <!-- <div class="col-xs-3" data-eval-option="type" id='evaluacion-tipo'>
        <?php
          echo $this->Form->input('Evaluacion.tipoeva_cve', array(
            'div' => false,
            'legend' => false,
            'before' => '<label>Tipo de Evaluación</label><div class="input radio">',
            'after' => '</div>',
            'separator' => '</div><div class="input radio">',
            'hiddenField' => false,
            'options' => array(
              'd' => 'Desempeño', 'c' => 'Conocimientos'
            ),
            'type' => 'radio',
            'default' => 'd'
          ));
        ?>
      </div> -->
      <div class="col-xs-12">
        <?php
          echo $this->Form->input('Evaluacion.evaluacion_nom', array(
            'class' => 'form-control input-sm input-block-level',
            'label' => __('Nombre del Examen'),
            'data-target-name' => 'evaluacion-title:keyup',
          ));
          echo $this->Form->input('Evaluacion.evaluacion_time', array(
            'class' => 'form-control input-sm inline xs',
            'data' => array(
              'rule-required' => true,
              'msg-required' => __('Ingresa el tiempo del examen.'),
            ),
            'div' => 'test-time text-center',
            'label' => __('Tiempo del Examen'),
            'min' => 1,
            'type' => 'number',
          ));
        ?>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12">
        <?php
          echo $this->Form->input('Evaluacion.evaluacion_descrip', array(
            'class' => 'form-control input-sm input-block-level',
            'data-target-name' => 'evaluacion-desc:keyup',
            'label' => __('Descripción de la Evaluación'),
            'type' => 'textarea',
            'rows' => 3
          ));
        ?>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12">
        <?php
          echo $this->Form->input('Evaluacion.evaluacion_indicacion', array(
            'class' => 'form-control input-sm input-block-level',
            'label' => __('Instrucciones Generales'),
            'type' => 'textarea',
            'rows' => 3
          ));
        ?>
      </div>
    </div>
  </fieldsset>
  <fieldset>
    <legend class="subtitle">
      <i class="icon-question"></i><?php echo __('Preguntas y Respuestas'); ?>
    </legend>
    <div class="btn-actions">
      <?php
        echo $this->Html->link(__('Agregar Pregunta'), '#', array(
          'class' => 'btn btn-default',
          'data-action-role' => 'new-question'
        ));
      ?>
    </div>
    <div class="panel-group" id="evaluacion-preguntas" data-role='questions-section'>
      <?php
        $preguntas = $this->request->data['Preguntas'];
        foreach ($preguntas as $k => $v) {
          $id = $v['pregunta_cve'];
      ?>
      <div class="question panel panel-default collapsable" data-question=<?php echo $k ?>>
        <div class="panel-heading">
          <h4 class="panel-title">
            <a class="accordion-toggle" data-parent="#evaluacion-preguntas" href="#pregunta-$k">
              Pregunta <span data-component='sequence'><?php echo $k ?></span>.- <span data-name="question<?php echo $k ?>-title"></span>
            </a>
          </h4>
          <div class="toolbar">
            <div class="input inline text question-time">
              <?php
                echo $this->Form->input("Preguntas.$k.pregunta_tiempo", array(
                  'class' => 'form-control xs',
                  'label' => __('Tiempo'),
                  'min' => 1,
                  'placeholder' => __('Tiempo'),
                  'type' => 'number',
                ));
              ?>
            </div>
            <div class="btn-group">
              <a class="btn btn-danger" href="#delete-<?php echo $k ?>" data-action-role="delete" data-question-id=<?php echo $k ?>>
                <i class="icon icon-trash"></i>
              </a>
            </div>
          </div>
        </div>
        <div id="pregunta-<?php echo $k ?>" class="panel-body" data-action-role="answer">
          <div class="accordion-inner">
            <div class="row">
              <div class="col-xs-12">
                <div class="input text ">
                  <!-- <label for="pregunta<?php echo $k ?>">Pregunta</label> -->
                  <?php
                    echo $this->Form->hidden("Preguntas.$k.pregunta_cve", array(
                      'data' => array(
                        'question-id' => $k
                      )
                    ));

                    echo $this->Form->input("Preguntas.$k.pregunta_nom", array(
                      'class' => 'question-text form-control input-sm input-block-level',
                      'data' => array(
                        'target-name' => "question${k}-title:keyup",
                        'data-rule-required' => true,
                        'data-msg-required'=> __('Ingresa la pregunta.')
                      ),
                      'id' => "pregunta${k}",
                      'label' => false,
                      'maxlength' => 500,
                      'type' => 'text'
                    ));
                  ?>
                </div>
              </div>
            </div>
            <ul class="answers clearfix" data-question-id="<?php echo $k ?>" data-answers-count=1>
              <?php foreach ($v['Respuestas'] as $_k => $_v) { ?>
                <li class="answer">
                  <?php
                    echo $this->Form->hidden("Preguntas.${k}.Respuestas.${_k}.opcpre_cve", array(
                      'data' => array(
                        'answer-id' => $_k
                      )
                    ));
                  ?>
                  <div class="input">
                    <?php
                      echo $this->Form->input("Preguntas.${k}.Respuestas.${_k}.opcpre_nom", array(
                        'class' => 'answer form-control input-block-level input-sm',
                        'data' => array(
                          'target-name' => "question${k}-answer${_k}-title:keyup",
                          'data-rule-required' => true,
                          'data-msg-required'=> __('Este campo no debe estar vacío.')
                        ),
                        'id' => "preg-${k}-resp-${_k}",
                        'label' => false,
                        'placeholder' => 'Escribe la respuesta',
                        'require' => true,
                        'type' => 'text',
                      ));
                    ?>
                  </div>
                  <div class="correct-answer">
                    <div class="input checkbox inline">
                      <?php
                        echo $this->Form->input("Preguntas.${k}.Respuestas.${_k}.opcpre_cor", array(
                          'div' => false,
                          'hiddenField' => false,
                          'id' => "preg-${k}-resp-${_k}-correct",
                          'label' => __('¿Respuesta correcta?'),
                          'type' => 'checkbox'
                        ));
                        // echo $this->Form->label('¿Respuesta correcta?', array(
                        //   'for' => "preg-${k}-resp-${_k}-correct"
                        // ));
                      ?>
                    </div>
                    <?php
                      echo $this->Html->link('','#', array(
                        'class' => 'delete-answer',
                        'data' => array(
                          'answer-id' => $_k
                        ),
                        'icon' => 'remove-circle'
                      ));
                    ?>
                  </div>
                </li>
              <?php } ?>
              <li>
                <a href="#" class="add-answer">
                  <?php echo __('+ Agregar Respuesta'); ?>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <?php
        }
      ?>
    </div>
  </fieldset>
  <div class="btn-actions">
    <div class="btn-group">
      <?php
        echo $this->Form->submit(__('Guardar Evaluación'), array(
          'class' => 'btn btn-success',
          'data' => array(
            'submit' => true,
            'submit-value' => 'publicada',
          ),
          'div' => false
        ));
      ?>
      <button class="btn btn-success dropdown-toggle" data-toggle="dropdown">
        <span class="caret"></span>
      </button>
      <ul class="dropdown-menu">
        <li>
          <?php
            echo $this->Html->link(__('Guardar como Borrador'), '#', array(
              'data' => array(
                'submit' => true,
                'submit-value' => 'borrador',
              ),
              'icon' => 'eraser'
            ));
          ?>
        </li>
      </ul>
    </div>
    <?php
      echo $this->Html->link(__('Vista Previa'), '', array(
        'data' => array(
          'target' => '#evaluacion-preview',
          'toggle' => 'slidemodal',
        ),
        'class' => 'btn btn-aqua'
      ));
      echo $this->Html->link(__('Cancelar'), $_referer, array(
        'class' => 'btn btn-danger'
      ));
    ?>
  </div>
  <?php
    echo $this->element('empresas/vista_previa/evaluacion', array(
      'evaluacion' => $this->request->data['Evaluacion']
    ));
  ?>
<?php
  echo $this->Form->end();
  echo $this->Template->insert(array(
    'pregunta',
    'pregunta-preview',
    'respuesta',
    'respuesta-preview',
  ));

  $this->AssetCompress->script('evaluacion.js', array(
    'inline' => false
  ));
?>