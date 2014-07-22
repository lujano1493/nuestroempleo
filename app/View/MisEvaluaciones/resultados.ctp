<?php
  echo $this->element('empresas/title');
?>

<?php
  //echo $this->element('empresas/title');
  $ev = $evaluacion['Evaluacion'];
  $pregs = $ev['Preguntas'];
  $totalPreguntas = 0;
  $totalRespuestasCorrectas = 0;
?>

<div id="preview" class="evaluacion-preview">
  <h1 class="title"><?php echo __('Resultados de Examen'); ?></h1>
  <?php
    echo $this->element('empresas/evaluaciones/actions', array(
      'actions' => array(
        'download', 'back'
      ),
      'evaluacion' => $ev,
      'candidato' => $evaluacion['Candidato']
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
            $totalPreguntas += 1;
        ?>
          <li>
            <h5 data-name="question{{= it.__q}}-title"><?php echo $value['pregunta_nom']; ?></h5>
            <ol class="respuestas-container alpha">
              <?php foreach ($value['RespuestasPorUsuario'] as $k => $v): ?>
                <li class="">
                  <?php
                    echo $v['opcpre_nom'];
                    if ((int)$v['opcpre_cor'] > 0) {
                      echo $this->Html->tag('span', __('Respuesta correcta'), array(
                        'class' => 'label label-info'
                      ));
                    }

                    if ((int)$v['usu_resp'] > 0) {
                      $correcta = (int)$v['opcpre_cor'] > 0;

                      echo $this->Html->tag('span', __('Respuesta del Usuario'), array(
                        'class' => 'label label-' . ($correcta ? 'success' : 'danger')
                      ));
                      if ($correcta) {
                        $totalRespuestasCorrectas += 1;
                      }
                    }
                  ?>
                </li>
              <?php endforeach ?>
            </ol>
          </li>
        <?php endforeach ?>
      </ol>
      <div class="text-center">
        <strong class='icon-2x'>
          <?php
            echo __('Resultado: %s respuestas correctas de %s preguntas.',
              $totalRespuestasCorrectas, $totalPreguntas);
          ?>
        </strong>
      </div>
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
            echo $evaluacion['ReclutadorContacto']['con_nombre'] . ' ' . $evaluacion['ReclutadorContacto']['con_paterno'];
          ?>
        </li>
        <li>
          Fecha de Creación: <?php echo $this->Time->d($ev['created']); ?>
        </li>
      </ul>
    </div>
  </div>
</div>