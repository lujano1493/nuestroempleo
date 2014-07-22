
<?php 

    $empresas= $this->params['controller'] === 'empresas' ?  true:false;
?>

<?php if( empty($micrositio)) { ?>
<div class="accordion-group_inicio">
  <div class="accordion-heading_inicio">
<?php 

    $data_menu= $empresas ? 'data-toggle="collapse" data-parent="#accordion2" href="#collapsetwo"':'href="/empresas"';
    ?>

  <a class="btn-medium btn  <?=$empresas?'btn_color':''?> pull-left padding_left_5"  <?=$data_menu?>>
    <i class="icon-briefcase"></i> Acceso a empresas
  </a>
  </div>
  <?php  if ($empresas) {?>
  <div id="collapsetwo" class="accordion-body collapse_inicio">
    <div class="accordion-inner_inicio">
         <?php
          echo $this->Form->create(false, array('class' => 'form-search',
            'url' => array(
              'controller' => 'empresas',
              'action' => 'iniciar_sesion'
            ),
            'data-component' => 'validationform',
            'inputDefaults' => array(
              'class' => 'input-medium',
              'div' => false,
              'label' => false
            )
          ));
          echo $this->Form->input('UsuarioEmpresa.cuenta', array(
            'label'=>false,
            'div'=> array("class" => "parent_" ,"style" =>"margin-top:35px"),
            'class'=>'input-block-level',
            'placeholder' => 'Correo Electrónico',
            'data-rule-required' =>'true',
            'data-msg-required'=>'Ingresa un correo electrónico.',
            'data-rule-email' =>'true',
            'data-msg-email' =>'Formato de correo electrónico no válido.',
            'required' =>"required"
          ));
          echo $this->Form->input('UsuarioEmpresa.password', array(
            'label'=>false,
            'div'=> array("class" => "parent_" ,"style" =>"margin-top:35px"),
            'class'=>'input-block-level',
            'type' => 'password',
            'placeholder' => 'Contraseña',
            'data-rule-required' =>'true',
            'data-msg-required' =>'Ingresa contraseña.',
            'required' =>"required"
          ));
          echo $this->Form->submit( 'Entrar',array(
            'label'=>false,
            'div'=> array("class" => "center","style"=>"margin-top:10px"),
            'class'=>'btn'
          ));
        ?>
          <div class="row">
            <?php
              // echo $this->Html->link('Regístrate', '#registro-empresas', array(
              //   'data-toggle' => 'modal'
              // ));
              // echo ' / ';
              echo "<div class='center' style='margin-bottom:10px;margin-top:10px'>" .$this->Html->link('¿Olvidaste tu contraseña?', '#', array(
                'class' => 'recuperar-contrasena',
                'data-toggle' => 'modal',
                'data-target' => '#recuperar_contrasena_empresas'
              )) ."</div>";
            ?>
          </div>
            <div class="center" style="margin-bottom:10px">
               <a data-toggle="collapse" data-parent="#accordion2" href="#collapsetwo" class="btn-danger btn">
                Cerrar
              </a>
            </div>                    
        <?php echo $this->Form->end(); ?>


    </div>
  </div>
  <?php }?>
</div>

<?php }?>