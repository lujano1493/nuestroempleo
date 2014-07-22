<?php
  echo $this->element('empresas/title');
?>
<div class="row" id='editorcito' data-copycat-autoload>
  <div class="col-xs-12">
    <?php
      echo $this->Form->create('Oferta', array(
        'class' => 'form-inline',
        'url' => array(
          'controller' => 'mis_ofertas',
          'action' => 'nueva'
        )
      ));
    ?>
      <?php echo $this->Session->flash(); ?>
      <fieldset>
        <legend class="subtitle">
          <i class="icon-edit-sign"></i><?php echo __('Título de la Oferta'); ?>
        </legend>
        <div class="row">
          <div class="col-xs-9">
            <?php echo $this->Form->input('Oferta.puesto_nom', array(
              'class' => 'form-control input-sm input-block-level',
              'data-target-name' => 'oferta-title:keyup',
              'label' => __('Nombre del Puesto'),
              'placeholder' => __('Ej: Diseñador Web'),
              ));
            ?>
          </div>
          <div class="col-xs-3">
            <?php echo $this->Form->input('Oferta.oferta_cvealter', array(
              'class' => 'form-control input-sm input-block-level',
              'label' => __('Clave interna'),
              'placeholder' => __('Ej: VA-0001'),
              ));
            ?>
          </div>
        </div>
      </fieldset>
      <fieldset>
        <legend class="subtitle">
          <i class="icon-asterisk"></i><?php echo __('Requisitos'); ?>
        </legend>
        <div class="row">
          <div class="col-xs-6">
            <?php
              echo $this->Form->input('Oferta.estado', array(
                'class' => 'form-control input-sm input-block-level',
                'data-source-name' => 'ciudades',
                'data-source-autoload' => true,
                'data-target-name' => 'oferta-estado',
                'empty' => false,
                'label' => __('Estado'),
                'options' => $listas['estados'],
                //'pass' => true,
              ));
              echo $this->Form->input('Oferta.oferta_exp', array(
                'class' => 'form-control input-sm input-block-level',
                'data-target-name' => 'oferta-experiencia',
                'empty' => false,
                'label' => __('Experiencia'),
                'options' => $listas['experiencia'],
                //'pass' => true,
              ));
              echo $this->Form->input('Oferta.oferta_sexo', array(
                'class' => 'form-control input-sm input-block-level',
                'data-target-name' => 'oferta-genero',
                'empty' => false,
                'label' => __('Género'),
                'options' => $listas['generos'],
                //'pass' => true,
              ));
            ?>
            <div class="row" id="min-max-age">
              <div class="col-xs-6">
                <?php
                  echo $this->Form->input('Oferta.oferta_edadmin', array(
                    'class' => 'form-control input-sm input-block-level',
                    'data-target-name' => 'oferta-edadmin',
                    'data-restrict-name' => 'edadmin',
                    'data-restrict-by' => 'edadmax:maxValue',
                    'label' => __('Edad mínima'),
                    'min' => 16,
                    'max' => 70,
                    'type' => 'number',
                    'value' => 16
                  ));
                ?>
              </div>
              <div class="col-xs-6">
                <?php
                  echo $this->Form->input('Oferta.oferta_edadmax', array(
                    'class' => 'form-control input-sm input-block-level',
                    'data-target-name' => 'oferta-edadmax',
                    'data-restrict-name' => 'edadmax',
                    'data-restrict-by' => 'edadmin:minValue',
                    'label' => __('Edad máxima'),
                    'min' => 16,
                    'max' => 70,
                    'type' => 'number',
                    'value' => 70
                  ));
                ?>
              </div>
            </div>
            <?php
              echo $this->Form->input('Oferta.oferta_viajar', array(
                'data-target-name' => 'oferta-disponibilidad-viajar',
                'div' => 'input-block-level',
                'hiddenField' => false,
                'label' => __('Disponibilidad para Viajar'),
                'type' => 'checkbox',
                //'pass' => true,
              ));
            ?>
          </div>
          <div class="col-xs-6">
            <?php
              echo $this->Form->input('Oferta.ciudad_cve', array(
                'class' => 'form-control input-sm input-block-level',
                'data-json-name' => 'ciudades',
                'data-target-name' => 'oferta-ciudad',
                'empty' => __('← Elige tu estado'),
                'label' => __('Delegación o municipio'),
                'options' => array(),
                //'pass' => true,
              ));
              echo $this->Form->input('Oferta.oferta_nivelesc', array(
                'class' => 'form-control input-sm input-block-level',
                'data-target-name' => 'oferta-escolaridad',
                'label' => __('Escolaridad'),
                'empty' => false,
                'options' => $listas['escolaridad'],
                //'pass' => true,
              ));
              echo $this->Form->input('Oferta.edocivil_cve', array(
                'class' => 'form-control input-sm input-block-level',
                'data-target-name' => 'oferta-estado-civil',
                'label' => __('Estado Civil'),
                'empty' => false,
                'options' => $listas['edo_civil'],
                //'pass' => true,
              ));
              echo $this->Form->input('Oferta.oferta_disp', array(
                'class' => 'form-control input-sm input-block-level',
                'data-target-name' => 'oferta-disponibilidad',
                'empty' => false,
                'label' => __('Disponibilidad'),
                'options' => $listas['disponibilidad'],
                //'pass' => true,
              ));
              echo $this->Form->input('Oferta.oferta_residencia', array(
                'data-target-name' => 'oferta-disponibilidad-residencia',
                'div' => 'input-block-level',
                'hiddenField' => false,
                'label' => __('Disponibilidad para cambiar de Residencia'),
                'type' => 'checkbox',
                //'pass' => true,
              ));
            ?>

          </div>
        </div>
      </fieldset>
      <fieldset>
        <legend class="subtitle">
          <i class="icon-file-text"></i><?php echo __('Descripción de la oferta') ?>
        </legend>
       <div class="alert alert-info alert-dismissable fade in popup" data-alert="alert">
          <button type="button" class="close" data-dismiss="alert">×</button>
           Capture la descripción de la oferta y detalles del perfil únicamente. Si desea ingresar información de contacto, puede hacerlo dando clic en la casilla de: 
           <strong>Mostrar datos de Contacto </strong>, ubicado en el apartado de 
           <strong>CONFIGURACIÓN</strong>.
        </div>

        <div class="row">
          <div class="col-xs-12">
            <?php
              echo $this->Form->input('Oferta.oferta_descrip', array(
                'class' => 'form-control input-sm input-block-level',
                'data-component' => 'wysihtml5-editor',
                'data-target-name' => 'oferta-desc',
                // 'placeholder' => __('Agregue las características de su oferta.'),
                'style' => 'height: 250px;',
                'type' => 'textarea',
                'label' => false
              ));
            ?>
          </div>
        </div>
      </fieldset>
      <div class="row">
        <div class="col-xs-6">
          <fieldset>
            <legend class="subtitle">
              <i class="icon-money"></i><?php echo __('Tipo de Empleo y Remuneración'); ?>
            </legend>
            <div class="row">
              <div class="col-xs-12">
                <?php
                  echo $this->Form->input('Oferta.oferta_tipoempleo', array(
                    'class' => 'form-control input-sm input-block-level',
                    'data-target-name' => 'oferta-tipo-empleo',
                    'label' => __('Tipo de Empleo'),
                    'empty' => false,
                    'options' => $listas['tipo_empleo'],
                    //'pass' => true,
                  ));
                ?>
                <?php
                  echo $this->Form->input('Oferta.sueldo_cve', array(
                    'class' => 'form-control input-sm input-block-level',
                    'data-target-name' => 'oferta-sueldo',
                    'label' => __('Sueldo'),
                    'empty' => false,
                    'options' => $listas['sueldos'],
                    //'pass' => true,
                  ));
                ?>
              </div>
            </div>

          </fieldset>
        </div>
        <div class="col-xs-6">
          <fieldset>
            <legend class="subtitle">
              <i class="icon-cog"></i><?php echo __('Configuración') ?>
            </legend>
            <div class="row">
              <!-- <div class="col-xs-6">
                <?php
                  echo $this->Form->input('Oferta.oferta_visitas', array(
                    'class' => 'form-control input-sm input-block-level',
                    'label' => __('Número de visitas'),
                    'type' => 'number',
                    'value' => 10,
                    'min' => 10
                  ));
                ?>
              </div> -->
              <div class="col-xs-12">
                Notificarme cuando <?php
                  echo $this->Form->input('Oferta.oferta_postulaciones', array(
                    'class' => 'form-control input-sm inline xs',
                    'div' => false,
                    'label' => false,
                    'type' => 'number',
                    'value' => 10,
                    'max' => 999,
                    'min' => 1
                  ));
                ?> candidatos se hayan postulado.
              </div>
            </div>
            <div class="row">
              <div class="col-xs-12">
                <?php
                  if (true) {
                    echo $this->Form->input('Oferta.cu_cve', array(
                      'class' => 'form-control input-sm input-block-level',
                      'data-target-name' => 'oferta-user-info',
                      'data-option' => true,
                      'empty' => false,
                      'label' => __('Asignar a'),
                      'options' => $listas['users'],
                    ));
                  }
                  echo $this->Form->input('Oferta.oferta_datos', array(
                    'data-target-name' => 'oferta-datos-contacto',
                    'div' => 'block',
                    'hiddenField' => false,
                    'label' => __('Mostrar datos de Contacto'),
                    'type' => 'checkbox'
                  ));
                  if (true) {
                    echo $this->Form->input('Oferta.oferta_preguntas', array(
                      'div' => 'block',
                      'hiddenField' => false,
                      'label' => __('Permitir preguntas respecto a la oferta'),
                      'type' => 'checkbox'
                    ));
                  }
                  echo $this->Form->input('Oferta.oferta_privada', array(
                    'data-target-name' => 'oferta-privada',
                    'div' => 'block',
                    'hiddenField' => false,
                    'label' => __('Marcar esta oferta como privada'),
                    'type' => 'checkbox'
                  ));
                     if (true) {
                    echo $this->Form->input('Oferta.oferta_redsocial', array(
                      'div' => 'block',
                      'hiddenField' => false,
                      'label' => __('Permitir que esta oferta sea compartida en las Redes Sociales (Facebook y Twitter )'),
                      'type' => 'checkbox'
                    ));
                  }
                ?>
              </div>
            </div>
          </fieldset>
        </div>
      </div>
      <fieldset>
        <legend class="subtitle">
          <i class="icon-medkit"></i><?php echo __('Prestaciones'); ?>
        </legend>
        <div class="row">
          <div class="col-xs-12 two-input-column" data-target-name='oferta-prestaciones::input'>
            <?php
              echo $this->Form->select('Oferta.oferta_prestaciones', $listas['prestaciones'], array(
                'multiple' => 'checkbox',
                'class' => 'input checkbox'
              ));
            ?>
          </div>
        </div>
      </fieldset>
      <fieldset>
        <legend class="subtitle">
          <i class="icon-tags"></i><?php echo __('Áreas que se relacionan'); ?>
        </legend>
        <div class="row">
          <div class="col-xs-12">
            <?php
              echo $this->Form->input('Oferta.categorias', array(
                'class' => 'form-control input-sm input-block-level',
                'data-component' => 'suggestito',
                'data-source-url' => '/info/carreras.json',
                'data-max-selection' => 3,
                'data-template' => 'categoria',
                'label' => __('Elige 3 categorías que se relacionen con la oferta.'),
                'placeholder' => 'Elige algunas categorías.',
                'required' => true
              ));
            ?>
            <?php
              echo $this->Form->input('Oferta.etiquetas', array(
                'class' => 'form-control input-sm input-block-level',
                'data-component' => 'suggestito',
                'data-source-url' => '/info/etiquetas.json',
                'data-query' => true,
                'data-free-entries' => true,
                'data-max-selection' => 5,
                'label' => __('Ingrese máximo 5 palabras clave relacionadas con la oferta.'),
                'placeholder' => 'Elige algunas etiquetas.'
              ));
            ?>
          </div>
        </div>
      </fieldset>
      <?php
        echo $this->element('empresas/ofertas/actions', array(
          'actions' => array(
            'submit', 'preview', 'cancel'
          ),
          'options' => array(
            'dropup' => true
          )
        ));
        echo $this->element('empresas/vista_previa/oferta', array(
          'isNew' => true
        ));
      ?>
    <?php echo $this->Form->end(); ?>
  </div>
</div>
<?php
  echo $this->element('empresas/banners', array(
    'single' => true
  ));
?>
<?php
  $this->AssetCompress->css('editor.css', array(
    'inline' => false,
    'id' => 'editor-css-url'
  ));

  $this->AssetCompress->script('editor.js', array(
    'inline' => false
  ));
?>

