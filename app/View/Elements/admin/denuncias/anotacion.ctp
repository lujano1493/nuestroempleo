

<div id="anotaciones">
  <?php
    echo $this->Form->create('NotaDenuncia', array(
      'class' => 'no-lock',
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

          echo $this->Form->input('NotaDenuncia.anotacion_tipo', array(
            'type' => 'hidden',
            "name" => "data[Nota][tipo]",
            'value' => $tipo
          ));

          echo $this->Form->input('NotaDenuncia.anotacion_id', array(
            'type' => 'hidden',
            "name" => "data[Nota][id]",
            'value' => $anotacionId
          ));

          echo $this->Form->input('NotaDenuncia.anotacion_detalles', array(
            'class' => 'form-control input-sm input-block-level',
            'name' =>  "data[Nota][detalles]",
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
  <?php
  		$tipo=array(1=>"candidato",0=>"oferta");
  	 if(!empty($anotaciones)) { ?>
    <ul id="lista-anotaciones" class="list-unstyled">
      <?php foreach ($anotaciones as $k => $v) { 
      		$v=$v['NotaDenuncia'];
      		$s=$tipo[$v['anotacion_tipo']];
      	?>
        <li class="nota well well-sm">
           <div class="block">
             <i class="icon-edit"></i>
            <div class="text-actions inline pull-right">
                <a  href="#"  class="edit" >Editar</a>
                 <a href="/admin/denuncias/<?="$s-$v[anotacion_cve]"?>/borrar_nota/" class="text-danger" data-component='ajaxlink'>Borrar</a>
            </div>
           </div>
          <div class="content">
            <?php echo $v['anotacion_detalles'];?>
          </div>
          <p class="text-right">
            <small>
              <?php echo $this->Time->dt($v['created']); ?>
            </small>
          </p>
            <input type="hidden" data-id="<?=$v['anotacion_cve']?>"  data-texto="<?=$v['anotacion_detalles']?>" data-tipo="<?=$s?>"  
            data-denunciaId="<?=$v['anotacion_id']?>"  class="data"  >    
        </li>
      <?php } ?>
    </ul>
  <?php } else { ?>
    <p class="empty">No hay anotaciones. </p>
  <?php } ?>
</div>


<?php
  echo $this->Template->insert(array(                  
    'nota'  => 'notas' // tmpl-notas
  ), null, array(
    'folder' => 'admin'
  ));
?>


<?php
  echo $this->Template->insert(array(                  
    'form-notas'  
  ), compact("anotacionId"), array(
    'folder' => 'admin'
  ));