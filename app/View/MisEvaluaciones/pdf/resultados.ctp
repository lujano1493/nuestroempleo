<?php
  $ev = $evaluacion['Evaluacion'];
  $pregs = $ev['Preguntas'];
  $candidato = $evaluacion['Candidato'];
  $candidatoInfo = $evaluacion['CandidatoContacto'];
  $totalPreguntas = 0;
  $totalRespuestasCorrectas = 0;
?>
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Factura</title>
    <style>
      body { font-family: sans-serif; font-size: 10pt; }
      h1 { font-size:25px; font-weight: lighter; padding-bottom: 5px; }
      ul.list-unstyled { list-style: none; margin: 0; padding: 0; }
      .absolute-top-left { position: absolute; top: 0; left: 0; }
      .absolute-top-right { position: absolute; top: 0; right: 0; }
      .alpha { list-style: upper-latin; }
      .border-bottom { border-bottom: #cecece solid 1px; }
      .text-center { text-align: center; }
      .text-right { text-align: right; }
      .margin-top { margin-top: 15px; }
      .margin-bottom { margin-bottom: 15px; }
      #footer {
        background-color: #fff;
        border-bottom: 1px solid #f0f0f0;
        bottom: 0px;
        /* height: 30px; */
        left: 0px;
        padding: 10px;
        position: fixed;
        right: 0px;
      }
    </style>
  </head>
  <body>
    <div id="header">
      <p class="absolute-top-left">
        <?php $url_img = WWW_ROOT . 'img/logo.png'; ?>
        <img src="<?= $url_img; ?>" width="150" />
      </p>
      <p class="absolute-top-right">
        <?php echo $this->Time->d(); ?>
      </p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <h1 class="text-center border-bottom">
        <?php echo htmlentities(__('Resultados de Evaluación')); ?>
      </h1>
    </div>
    <div id="body">
      <div>
        <ul class="list-unstyled margin-bottom">
          <li><?php echo htmlentities(__('Candidato: %s', $candidato['nombre_'])); ?></li>
          <li><?php echo htmlentities(__('Perfil: %s', $candidato['candidato_perfil'])); ?></li>
          <li><?php echo htmlentities(__('Correo Electrónico: %s', $candidatoInfo['cc_email'])); ?></li>
        </ul>
      </div>
      <ol>
        <?php
          foreach ($pregs as $_p => $p):
            $totalPreguntas += 1;
        ?>
          <li class="margin-bottom">
            <strong><?php echo htmlentities($p['pregunta_nom']); ?></strong>
            <ol class="alpha">
              <?php foreach ($p['RespuestasPorUsuario'] as $_r => $r): ?>
                <li class="">
                  <?php
                    $correct = false;
                    $resp = htmlentities($r['opcpre_nom']);
                    if ((int)$r['opcpre_cor'] > 0) {
                      $resp = $this->Html->tag('em', $resp, array(
                      ));
                    }

                    if ((int)$r['usu_resp'] > 0) {
                      $correct = (int)$r['opcpre_cor'] > 0;

                      $resp = $this->Html->tag('strong', $resp, array(

                      )) . str_pad('', 15) . $this->Html->tag('span', $correct ? '&#x2714;' : '&#x2716;', array(
                        'style' => 'font-family: "DejaVu Sans", sans-serif;'
                      ));

                      $correct && $totalRespuestasCorrectas += 1;
                    }

                    echo $resp;
                  ?>
                </li>
              <?php endforeach; ?>
            </ol>
          </li>
        <?php endforeach; ?>
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
    <div id="footer" class="text-right">
      <?php
        echo htmlentities(__('Este documento se generó el %s.', $this->Time->dt()));
      ?>
    </div>
  </body>
</html>