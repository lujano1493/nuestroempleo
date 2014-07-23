<div id="anotaciones">
  <?php
    echo $this->Form->create('Anotacion', array(
      'class' => 'no-lock',
      'url' => array(
        'controller' => 'mis_candidatos',
        'action' => 'anotacion',
        'id' => $id,
      )
    ));
  ?>
    <div class="row">
      <div class="col-xs-12">
        <?php
          echo $this->Form->input('Anotacion.anotacion_tipo', array(
            'class' => 'form-control input-sm input-block-level',
            'label' => 'Tipo',
            'options' => $_listas['notas']
          ));
        ?>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12">
        <?php
          echo $this->Form->input('Anotacion.anotacion_detalles', array(
            'class' => 'form-control input-sm input-block-level',
            'label' => 'Detalles',
            'type' => 'textarea',
            'rows' => 3
          ));
        ?>
      </div>
    </div>
    <div class="btn-actions">
      <?php
        echo $this->Html->link(__('Agregar Anotación'), '#', array(
          'class' => 'btn btn-sm btn-success',
          'data-submit' => true,
        ));
      ?>
    </div>
  <?php
    echo $this->Form->end();
  ?>
  <?php if(!empty($candidato['Anotaciones'])) { ?>
    <ul id="lista-anotaciones" class="list-unstyled">
      <?php foreach ($candidato['Anotaciones'] as $k => $v) { ?>
        <li class="nota well well-sm">
          <div class="block">
            <i class="icon-edit"></i>
            <?php if ($v['Usuario']['id'] === $authUser['cu_cve']) { ?>
              <div class="text-actions inline pull-right">
                <a href="#" class="edit">Editar</a>
                <?php
                  echo $this->Html->link('Borrar', array(
                    'controller' => 'mis_candidatos',
                    'action' => 'borrar_nota',
                    'id' => $v['candidato_cve'],
                    'slug' => Inflector::slug($candidato['CandidatoEmpresa']['candidato_perfil'], '-'),
                    'itemId' => $v['id'],
                    'itemSlug' => 'nota',
                  ), array(
                    'class' => 'text-danger',
                    'data-component' => 'ajaxlink'
                  ));
                ?>
              </div>
            <?php } ?>
          </div>
          <strong><?php echo $v['Usuario']['nombre'];?></strong>
          <div class="content">
            <?php echo $v['detalles'];?>
          </div>
          <p class="text-right">
            <small>
              <?php echo $this->Time->dt($v['created']); ?>
            </small>
          </p>
          <?php
            echo $this->Form->input('data', array(
              'class' => 'data',
              'id' => false,
              'data' => array(
                'id' => $v['id'],
                'texto' => $v['detalles'],
                'item-id' => $v['candidato_cve']
              ),
              'type' => 'hidden'
            ));
          ?>
        </li>
      <?php } ?>
    </ul>
  <?php } else { ?>
    <p class="empty">No hay anotaciones. Se el primero en agregar una.</p>
  <?php } ?>
</div>
<?php
  echo $this->Template->insert(array(
    'edit-notas'
  ), array());
?>