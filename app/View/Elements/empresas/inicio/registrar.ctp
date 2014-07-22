<div id="registro-empresas" class="modal hide fade formulario" data-component="modalform" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h2 class="modal-title forma_genral_tit">Registro de Empresas</h2>
  </div>
  <div class="modal-body">
    <div class="alert-container clearfix">
      <div class="alert alert-info" data-alert="alert">
        <i class=" icon-info-sign icon-2x"></i>
          Llene los campos con la información solicitada, los campo marcados con (*) son obligatorios.
      </div>
    </div>
    <?php
      echo $this->Form->create('Empresa', array(
        'class' => 'well container-fluid',
        'data-component' => 'validationform ajaxform',
        'data-onvalidationerror' => '[{"action":"click","target":".refresh-captcha-image"}]',
        'data-onsucces-action' => '[{"action":"hide"}]',
        'id' => 'empresa-registrar',
        'url' => array('controller' => 'empresas', 'action' => 'registrar'),
        //'novalidate' => true
      ));
    ?>
      <fieldset>
        <div class="row-fluid">
          <div class="span4">
            <?php echo $this->Form->input('Empresa.cia_nombre', array(
              'class' => 'input-block-level',
              // 'icon' => 'briefcase',
              'label' => 'Nombre de la Empresa*:',
              'required' => true
              ));
            ?>
          </div>
          <div class="span4">
            <?php echo $this->Form->input('Empresa.cia_rfc', array(
              'class' => 'input-block-level',
              'label' => 'R.F.C.*:',
              'required' => true
              ));
            ?>
          </div>
          <div class="span4">
            <?php
              $giros = ClassRegistry::init('Catalogo')->lista('giros');
              echo $this->Form->input('Empresa.giro_cve', array(
                'class' => 'input-block-level',
                'label' => 'Giro de la Empresa*:',
                'id' => 'giros',
                'options' => Hash::combine($giros, '{n}.id', '{n}.name')
              ));
              // echo $this->Form->input('Empresa.giro_cve', array(
              //   'label' => false,
              //   'type' => 'hidden',
              //   'id' => 'EmpresaGiroCve'
              // ));
            ?>
          </div>
        </div>
        <div class="row-fluid">
          <div class="span4">
            <?php
              echo $this->Form->input('UsuarioEmpresa.cu_sesion', array(
                'class' => 'input-block-level cu_sesion',
                // 'icon' => 'envelope',
                'label' => 'Correo Electrónico*:',
                'required' => true,
                'type' => 'email'
              ));
            ?>
          </div>
          <div class="span4">
            <?php
              echo $this->Form->input('UsuarioEmpresa.cu_sesion_confirm', array(
                'class' => 'input-block-level no-edit',
                // 'icon' => 'envelope',
                'label' => 'Correo Electrónico*:',
                'required' => true,
                'type' => 'email'
              ));
            ?>
          </div>
        </div>
        <div class="row-fluid">
          <div class="span4">
            <?php
              echo $this->Form->input('Empresa.cp', array(
                'class' => 'input-block-level',
                // 'data-component' => 'sourcito',
                'data-source-name' => 'codigo_postal',
                // 'icon' => 'map-marker',
                'pattern' => '[0-9]*',
                'label' => 'Código Postal*:',
                'required' => true,
              ));
            ?>
          </div>
          <div class="span4">
            <?php
              echo $this->Form->input('Empresa.cia_tel', array(
                'class' => 'input-block-level numeric',
                // 'icon' => 'phone',
                'label' => 'Teléfono de la Empresa*:',
                'required' => true
              ));
            ?>
          </div>
        </div>
        <div class="row-fluid">
          <div class="span4">
            <?php
              echo $this->Form->input('Empresa.estado', array(
                'class' => 'input-block-level',
                'data-json-name' => 'estado',
                // 'icon' => 'map-marker',
                'label' => 'Estado*:',
                'disabled' => true
              ));
            ?>
          </div>
          <div class="span4">
            <?php
              echo $this->Form->input('Empresa.ciudad', array(
                'class' => 'input-block-level',
                'data-json-name' => 'municipio',
                // 'icon' => 'map-marker',
                'label' => 'Ciudad*:',
                'disabled' => true
              ));
            ?>
          </div>
          <div class="span4">
            <?php
              echo $this->Form->input('Empresa.colonia', array(
                'class' => 'input-block-level',
                'data-json-name' => 'colonias',
                'empty' => '↑ Primero escriba el Código Postal',
                // 'icon' => 'map-marker',
                'label' => 'Colonia*:',
                'required' => true,
                'type' => 'select'
              ));
            ?>
          </div>
        </div>
        <div class="row-fluid">
          <div class="span4">
            <?php echo $this->Form->input('UsuarioEmpresaContacto.con_nombre', array(
              'class' => 'input-block-level',
              // 'icon' => 'user',
              'label' => 'Nombre(s)*:',
              'required' => true
            )); ?>
          </div>
          <div class="span4">
            <?php echo $this->Form->input('UsuarioEmpresaContacto.con_paterno', array(
              'class' => 'input-block-level',
              'label' => 'Apellido Paterno*:',
              'required' => true
            )); ?>
          </div>
          <div class="span4">
            <?php echo $this->Form->input('UsuarioEmpresaContacto.con_materno', array(
              'class' => 'input-block-level',
              'label' => 'Apellido Materno:',
              'required' => false
            )); ?>
          </div>
        </div>
        <?php if (!$isAdmin) { ?>
          <div class="row-fluid">
            <div class="span4 left" style="padding-left:40px;">
              <div class="input checkbox ">
                <input type="checkbox" name="data[Empresa][terminos]" required="required" value="1" id="EmpresaTerminos">
                <a target="_blank" href="/informacion/terminos_condiciones">Acepto términos y condiciones</a>
              </div>
              <div class="input checkbox">
                <a href="/informacion/aviso_privacidad" target="_blank">Aviso de Privacidad</a>
              </div>
              <!--<?php
                /*echo $this->Form->input('terminos', array(
                  'label' => 'Acepto términos y condiciones.',
                  'label' => false,
                  'required' => true,
                  'hiddenField' => false,
                  'type' => 'checkbox'
                ));*/
              ?>-->
            </div>
            <div class="span4">
              <?php
                echo $this->element("candidatos/tool/captcha_image", array(
                  'status' => false
                ));
              ?>
            </div>
          </div>
        <?php } ?>
        <div class="form-actions">
          <button type="submit" class="btn_color btn-large">Enviar</button>
        </div>
      </fieldset>
    <?php echo $this->Form->end(); ?>
    <a  class="" data-dismiss="modal" aria-hidden="true" href="" >Cerrar formulario</a>
  </div>
  <div class="modal-footer">

  </div>
</div>