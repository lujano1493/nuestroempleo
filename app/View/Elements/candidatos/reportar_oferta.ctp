<?php 

  $causas=ClassRegistry::init("Catalogo")->get_list("CAUSA_CVE");

?>
<div id="denunciar01" class="hide" tabindex="-1" role="dialog" data-component="slideform">



    <div class="ajax-done hide">
      <div class="well" > 
               Se realizará la verificación de la oferta.
      </div>
    </div>
      
  <div class="formulario">
     <?=$this->Form->create('Reportar', array(
          'id' => 'reportar',
          'data-component' => 'validationform ajaxform',
          'url' => array(
            'controller' => 'PostulacionesCan',
            'action' => 'denunciar',
            'id' => $id
          )
        ))?>

<div class="alert-container clearfix">
  <div class="alert alert-info fade in popup" data-alert="alert">
    Si notaste alguna anomalía en esta postulación llena los siguientes campos para que sea investigada: 
  </div>
</div>

    <div class="row-fluid">
      <fieldset class="well">

     


        <?php 
          echo $this->Form->input('Reportar.causa', array(
            'class' => 'input-block-level',
            'label' => 'Motivo de Reporte',
            'data-rule-required' => 'true',
            'data-msg-required' => 'Ingresa la causa de reporte',
            'empty' => true,
            'options' => $causas
          ));
        ?>
        <?php 
          echo $this->Form->input('Reportar.detalles', array(
            'class' => 'input-block-level',
            'data-rule-required' => 'true',
            'data-msg-required' => 'Ingresa detalles',
            'label' => 'Detalles',
            'type' => 'textarea'
          ));
        ?>
      </fieldset>
    </div>
       <?php 
      echo $this->Form->submit('Reportar', array(
        'class' => 'btn btn-danger',
        "id" => "aceptar01",
        'data-confirm' => true,
        //'disabled' => true,
        'div' => false
      ));
    ?>
    <a href="#" class=" btn btn_color" data-trigger-slide="#denunciar01" > 
              Cancelar
    </a>
    <?php echo $this->Form->end(); ?>

  </div>      

 

</div>