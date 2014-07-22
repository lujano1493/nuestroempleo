 <?php
    echo $this->Form->create('NotaDenuncia', array(
      'class' => 'nota no-lock',
      'url' => array(
        'prefix' => "admin",
        'controller' => 'denuncias',
        'action' => 'anotacion'
      )
    ));
  ?>

    <div class="row">
      <div class="col-xs-12">
        <?php

           echo $this->Form->input('NotaDenuncia.anotacion_cve', array(
            'type' => 'hidden',
            "name" => "data[Nota][clave]",
            'value' => "{{=it.id}}"
          ));

          echo $this->Form->input('NotaDenuncia.anotacion_tipo', array(
            'type' => 'hidden',
            "name" => "data[Nota][tipo]",
            'value' => "{{=it.tipo}}"
          ));

          echo $this->Form->input('NotaDenuncia.anotacion_id', array(
            'type' => 'hidden',
            "name" => "data[Nota][id]",
            'value' => "{{=it.denunciaid}}"
          ));

          echo $this->Form->input('NotaDenuncia.anotacion_detalles', array(
            'class' => 'form-control input-sm input-block-level',
            'name' =>  "data[Nota][detalles]",
            'label' => 'Detalles',
            'type' => 'textarea',
            "value" => "{{=it.texto}}",
            'rows' => 3
          ));
        ?>
      </div>
    </div>
    <div class="btn-actions">
      <?php
        echo $this->Html->link(__('Editar'), '#', array(
          'class' => 'btn btn-sm btn-success',
          'data-submit' => true,
        ));
        echo $this->Html->link(__('Cancelar'),"#",array(
          'class' =>"cancel-edit btn btn-sm btn-danger"
          ) );        
      ?>
    </div>
  <?php
    echo $this->Form->end();
  ?>