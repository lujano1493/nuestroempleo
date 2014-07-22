<?php

  $salarios = ClassRegistry::init('ExpLabSue')->lista();
  $pais_cve = 1;
  $estados = ClassRegistry::init('Estado')->getlistaEstado($pais_cve);

  $model_catalogo = ClassRegistry::init('Catalogo');
  $escolaridad = $model_catalogo->get_list('NIVEL_ESCOLAR', array(
    'Catalogo.opcion_valor > 0'
  ));
  // $dispo_empleo = $model_catalogo->get_list('DISPONIBILIDAD_EMPLEO');

  $categorias = ClassRegistry::init('Categoria')->lista();
  $dato = !empty($param) && array_key_exists('dato', $param) ? $param['dato'] : '';

  $dias = array();
  for ($i = 15; $i <= 65; $i += 5) {
    $aux = $i + 5;
    $dias[] = __("%s a %s Años", $i === 15 ? $i + 1 : $i, $aux);
  }
  $searchClass = !empty($busqueda) ? $busqueda : '';
?>
<?=
  $this->Form->create('Busqueda',array(
    'url' => array(
      'controller' => 'candidatos',
      'action' => 'index'
    ),
    'id' => 'search-input',
    'type' => 'get',
    'class'=> $searchClass,
    'data-component' => 'searchavanced'
  ));
?>
  <div class="clearfix">
    <fieldset class="panel-search row">
      <div class="col-xs-5">
        <p><?php echo __('Para una búsqueda rápida de candidatos ingrese las palabras clave en el buscador.'); ?></p>
      </div>
      <div class="col-xs-7">
        <div class="input-group" >
          <?=
            $this->Form->input('Busqueda.dato', array(
              'class' => 'form-control search-query',
              'label' => false,
              'div' => false,
              'data-param-name' => 'dato',
              'placeholder' => __('Ingresa tus palabras clave'),
              'value'=> $dato,
              'type' => 'text'
            ));
          ?>
          <span class="input-group-btn">
            <?=
              $this->Form->submit(__('Buscar'),array(
                'class' => 'btn btn-blue search-all',
                'div' => false
              ));
            ?>
          </span>
        </div>
        <p class="text-right">
          <a href="#" class="btn-slide earch-btn-main"><?php echo __('Búsqueda Avanzada'); ?></a>
        </p>
      </div>
    </fieldset>
  </div>
  <!-- div despegable -->
  <div class="clearfix" style="padding:0 15px;">
    <fieldset class="panel-advanced form-search row">
      <div class="col-xs-12">
        <p class="help-block strong text-right">
          <a href="#"  class="btn-slide active">
            <i class="icon-minus-sign"></i><?php echo __('Regresar a Búsqueda Rápida'); ?>
          </a>
        </p>
        <div class="row">
          <?php
            $inputs = array(
              array(
                'name' => 'Busqueda.b_sueldo',
                'label' => 'Salario:',
                'class' => 'form-control input-sm control-group param-name',
                'data-param-name' => 'sueldo',
                'empty' => __('Seleccione...'),
                'options' => $salarios
              ),
              array(
                'name' => 'Busqueda.b_estado',
                'label' => 'Estado:',
                'data' => array(
                  'component' => 'sourcito',
                  'source-autoload' => true,
                  'target-name' => 'busqueda-oferta-estado',
                  'source-name' => 'ciudades',
                ),
                'empty' => __('Seleccione...'),
                'class' => 'form-control input-sm control-group',
                'options' => $estados
              ),
              array(
                'name' => 'Busqueda.b_ciudad',
                'label' => 'Ciudad:',
                'data' => array(
                  'param-name' => 'ciudad',
                  'json-name' => 'ciudades',
                ),
                'class' => 'form-control input-sm control-group param-name',
                'empty' => __('Seleccione...'),
                'options' => array()
              ),
              array(
                'name' => 'Busqueda.b_escolaridad',
                'label'=> 'Escolaridad:',
                'class' => 'form-control input-sm control-group param-name',
                'data-param-name' => 'dato',
                'empty' => __('Seleccione...'),
                'options' => $escolaridad
              ),
              array(
                'name' => 'Busqueda.b_categoria',
                'label'=> 'Categoria:',
                'class' => 'form-control input-sm control-group param-name',
                'data-param-name' => 'categoria',
                'empty' => __('Seleccione...'),
                'options' => $categorias
              ),
              array(
                'name' => 'Busqueda.b_fecha_publicacion',
                'class' => 'form-control input-sm control-group param-name',
                'data-param-name' => 'edad',
                'label' => 'Edad:',
                'empty' => __('Seleccione...'),
                'options' => $dias
              )
            );
          ?>
          <?php
            foreach ($inputs as $index => $input) :
              $opciones = array(
                'label' => array(
                  'class' => '',
                  'text' => $input['label']
                )
              );
              ?>
                <div class="col-xs-6">
                  <?php echo $this->Form->input($input['name'], array_merge($input, $opciones)); ?>
                </div>
              <?php
              if ($index % 2 === 1) echo '</div><div class="row">';
            endforeach;
          ?>
        </div>
        <div class="btn-actions">
          <?=
            $this->Form->submit('Buscar', array(
              'class' => 'search-avanced btn btn-blue',
            ));
          ?>
        </div>
      </div>
    </fieldset>
  </div>
<?= $this->Form->end(); ?>
