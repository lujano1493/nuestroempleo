
<?php
echo $this->element('admin/title');

	
  $opciones_internos = array(
    'internos_productos' => 'Ventas Totales de Producto ',
    'internos_productos_cuenta' => 'Ventas totales por Ejecutivos ',
    'internos_productos_ventas_usuario' => 'Ventas por Ejecutivo '
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
    'data-controller' => '/admin/reportes/',
    'data-radios-group' => "#tipo-reportes" 

  ));
?>
  <h5 class="subtitle">
    <i class="icon-list"></i>
    <?php echo __('Reportes de Productos'); ?>
  </h5>
  <div class="row">
    <div class="col-xs-4">
      <div id="tipo-reportes" data-option="internos_productos_ventas_usuario" data-element-name=".option-select" >
        <!-- <h6><?php echo __('Internos'); ?></h6> -->
        <?php
          echo $this->Form->radios('type', $opciones_internos, array(
            // 'class' => 'input radio',
            'div' => array(
              'style' => 'margin-bottom:8px;'
            )
          ));
        ?>
      </div>
      
    </div>  
    <div class="col-xs-4">
        <h6>Tipo de Empresa</h6>
        <div class="tipo">
          <?php 
              echo  $this->Form->radios("tipoEmpresa",array(
                  "Convenio", 
                  "Comercial" ,
                   "Todo"
                ), array(
                ) );
            ?>
        </div>
          <div class="option-select" style="display:none">
            <?php
                  echo $this->Form->input('usuario', array(
                    'class' => 'form-control input-sm input-block-level',
                    'label' => __('Seleccione a Ejecutivo:'),
                    'required' => true,
                    'options' => $usuarios
              ));
              ?>
              
          </div>         
    </div>

    <div class="col-xs-4">
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