<?php
  echo $this->Form->create('Mensaje', array(
    'data-component' => ' validationform ajaxform',
    'class' => 'form-inline nofication-emit',
    'id' => 'form-send-msg'
  ));
?>
<table class="table table-bordered table-striped table-hover">
  <thead class="table-fondo">
    <tr>
      <th colspan="9">Redactar mensaje</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td class="strong">Para:</td>
      <td colspan="7">        

        <?php
          if(!$new) {
            echo $this->Form->input('Mensaje.to_user', array(
              'value' => $to['id'],
              'type' => 'hidden'
            ));
            echo $this->Form->input('Mensaje.user_type', array(
              'value' => $to['tipo'],
              'type' => 'hidden'
            ));
            echo '<span>' . $to['nombre'] . '</span>';

          } else{
            echo $this->Form->input('Mensaje.c_receptores', array(
              'class' => 'input-block-level',
              'data-component' => 'suggestito',
              'data-source-url' => '/mis_candidatos/adquiridos.json',
              'data-template' => 'candidato',
              'label' => 'Candidatos',
              'placeholder' => 'Ingresa el email de algún candidato adquirido.',
              'required' => true
            ));
          }          


          if(!empty($parametros)){
                $superior=$parametros['superior'];
                $tipo=$parametros['tipo'];
                echo $this->Form->input("Mensaje.msj_cve",array(
                    "name"=> "data[Mensaje][superior]" ,
                    "value" => $superior,
                    "type"=> "hidden"
                   ));

                  echo $this->Form->input("Mensaje.tipomsj_cve",array(
                    "name"=> "data[Mensaje][tipo]" ,
                    "value" => $tipo,
                    "type"=> "hidden"
                  ));

          }
          
        ?>
      </td>
      <td class="strong">
        <div class="btn-actions">
          <?php
            echo $this->Html->link('Cancelar', $_referer, array(
              'class' => 'btn btn-sm btn-warning',
              'icon' => 'arrow-left',
              'data-close' => true,
            ));
          ?>
          <button class="btn btn-sm btn-success" type="submit" data-submit="1">
            <i class="icon-share-alt"></i>¡Enviar!
          </button>
        </div>
      </td>
    </tr>
    <tr>
      <td class="strong">Asunto:</td>
      <td colspan="7">
        <?php
          echo $this->Form->input('Mensaje.msj_asunto', array(
            'label' => false,
            'placeholder' => 'Asunto',
            'class' => 'form-control input-sm input-block-level',
            'data-rule-required' =>'true',
            'data-msg-required' =>'Ingresa Asunto de Mensaje',
            'default' => $asunto
          ));
        ?>
      </td>
      <td>
        <?php
          echo $this->Form->input('Mensaje.msj_importante', array(
            'div' => 'inline',
            'hiddenField' => false,
            'label' => 'Importante',
            'type' => 'checkbox'
          ));
        ?>

          <?php    if( !empty($parametros) && !empty($parametros['comentario'])  ) : 
            $comentario=$parametros['comentario'];      
         ?>
            <?php 
              if (!empty($authUser) && isset($authUser['cu_cve']) ){                    
                  echo $this->Form->input("Mensaje.publico", array(
                        'before' => ' <label> Mensaje Público: </label>',
                        "value" => $comentario['msjxoferta_public'],
                        "options" => array("S"=>"Sí","N" => "No"  ),
                        'div' => array(
                            'style' =>"margin-left: 100px;"
                          ),
                        "type" => "radio",
                        "legend"=>false,
                        'hiddenField' => false
                    ));
              }
              else{
                  echo $this->Form->input("Mensaje.publico", array(
                        "value" => $comentario['msjxoferta_public'],
                        "type" => "hidden"
                    ));

              }

            ?>

        <?php endif;?>
      </td>        
    </tr>
    <tr>
      <td colspan="9" class="center" style="height:200px auto;">
        <?php
          echo $this->Form->input('Mensaje.msj_texto', array(
            'class' => 'form-control input-sm input-block-level',
            'data-component' => 'wysihtml5-editor',
            'label' => false,
            //'placeholder' => 'Escribe tu mensaje.',
            'style' => 'height: 250px;',
            'type' => 'textarea',
            'default'=>$msg
          ));
        ?>
      </td>
    </tr>
  </tbody>
</table>
<?php
  echo $this->Form->end();
?>

<?php
  if (empty($scriptsLoaded)) {
    $this->AssetCompress->css('editor.css', array(
      'inline' => false,
      'id' => 'editor-css-url'
    ));

    $this->AssetCompress->script('editor.js', array(
      'inline' => false
    ));
  }
?>