<?php
  //echo $this->element('empresas/title');
  $ev = $evaluacion['Evaluacion'];
  $pregs = $evaluacion['Preguntas'];
?>

<div id="preview" class="evaluacion-preview">
  <h1 class="title">Vista previa</h1>
  <?php
    echo $this->element('empresas/evaluaciones/actions', array(
      'evaluacion' => $ev,
      'backButton' => $_referer,
      'actions' => array(
        'edit',
        'exclude' => array('submit')
      )
    ));
  ?>
  <div class="row">
    <div class="col-xs-8 preview-content">
      <div class="header">
        <h4>
          <strong><?php echo $ev['evaluacion_nom']; ?></strong>
        </h4>
      </div>
      <ol class="preguntas-container decimal">
        <?php
          foreach ($pregs as $key => $value):
        ?>
          <li>
            <h5 data-name="question{{= it.__q}}-title"><?php echo $value['pregunta_nom']; ?></h5>
            <ol class="respuestas-container alpha">
              <?php foreach ($value['Respuestas'] as $k => $v): ?>
                <li class="">
                  <?php
                    echo $v['opcpre_nom'];
                    if ((int)$v['opcpre_cor'] > 0) {
                  ?>
                    <span class="label label-success">Respueta correcta</span>
                  <?php
                    }
                  ?>
                </li>
              <?php endforeach ?>
            </ol>
          </li>
        <?php endforeach ?>
      </ol>
    </div>
    <div class="col-xs-4">
      <h5 class="subtitle">
        <i class="icon-align-justify"></i>Breve Descripción
      </h5>
      <ul class="list-unstyled">
        <li>
          <div data-name="evaluacion-desc">
            <?php echo $ev['evaluacion_descrip']; ?>
          </div>
        </li>
        <li>
          Creador: <?php
            echo $evaluacion['CreadorContacto']['con_nombre'] . ' ' . $evaluacion['CreadorContacto']['con_paterno'];
          ?>
        </li>
        <li>
          Fecha de Creación: <?php echo $this->Time->d($ev['created']); ?>
        </li>
      </ul>
    </div>
  </div>
</div>