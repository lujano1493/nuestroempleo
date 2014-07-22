<?php
  echo $this->element('empresas/title');
  $ofertaReportes = array(
    'ofertas_publicadas' => 'Ofertas Publicadas',
    'ofertas_categorias' => 'Ofertas por Área',
    'ofertas_usuarios' => 'Ofertas por Usuario',
    'ofertas_coordinacion' => 'Ofertas por coordinación',
    'ofertas_tipo' => 'Ofertas por tipo',
    'ofertas_zona' => 'Ofertas por Zona'
  );

  $postulacionesReportes = array(
    'postulaciones' => 'Total de Postulaciones',
    'postulaciones_genero' => 'Postulaciones por Sexo',
    'postulaciones_edad' => 'Postulaciones por Edad',
    'postulaciones_escolaridad' => 'Postulaciones por escolaridad'
  );

  $otrosReportes = array(
    'ofertas_postulaciones' => 'Ofertas vs Candidatos Postulados',
    'creditos_ocupados' => 'Créditos Ocupados por Usuario',
  );
?>

<div class="alert alert-info">
  Por favor, selecciones el reporte que desea consultar, una vez realizado,
  ingrese el año y el mes o los meses que desea consultar.
</div>

<?php
  echo $this->Form->create(false, array(
    'class' => 'no-lock',
    'id' => 'chartsitoForm',
  ));
?>
  <h5 class="subtitle">
    <i class="icon-list"></i>
    <?php echo __('Resumen Rápido'); ?>
  </h5>
  <div class="row">
    <div class="col-xs-3">
      <h6><?php echo __('Ofertas'); ?></h6>
      <?php
        echo $this->Form->radios('type', $ofertaReportes, array(
          // 'class' => 'input radio',
          'div' => array(
            'style' => 'margin-bottom:8px;'
          )
        ));
      ?>
    </div>
    <div class="col-xs-3">
      <h6><?php echo __('Postulaciones'); ?></h6>
      <?php
        echo $this->Form->radios('type', $postulacionesReportes, array(
          //'class' => 'input radio',
          'div' => array(
            'style' => 'margin-bottom:8px;'
          )
        ));
      ?>
    </div>
    <div class="col-xs-3">
      <h6><?php echo __('Otros'); ?></h6>
      <?php
        echo $this->Form->radios('type', $otrosReportes, array(
          // 'class' => 'input radio',
          'div' => array(
            'style' => 'margin-bottom:8px;'
          )
        ));
      ?>
    </div>
    <div class="col-xs-3">
      <h6>Periodo</h6>
      <div class="">
        <?php
          echo $this->Form->input('initMonth', array(
            'class' => 'form-control input-sm input-block-level',
            'label' => __('Fecha inicial'),
            'required' => true,
            'data' => array(
              'rule-required' => true,
              'msg-required' => 'Elige la fecha de inicio.'
            )
          ));
          echo $this->Form->input('initDate', array(
            'type' => 'hidden'
          ));
          echo $this->Form->input('finalMonth', array(
            'class' => 'form-control input-sm input-block-level',
            'label' => __('Fecha Final'),
            'required' => true,
            'data' => array(
              'rule-required' => true,
              'msg-required' => 'Elige la fecha de fin.'
            )
          ));
          echo $this->Form->input('finalDate', array(
            'type' => 'hidden'
          ));
        ?>
      </div>
    </div>
  </div>
  <div class="btn-actions">
    <?php
      echo $this->Html->link(__('Aceptar'), '#', array(
        'class' => 'btn btn-success',
        'data' => array(
          'submit' => true
        )
      ));
    ?>
  </div>
<?php
  echo $this->Form->end();
?>
<br><br>
<div id="chartsito"></div>

<?php
  $this->AssetCompress->script('amchart.js', array(
    'inline' => false
  ));
?>