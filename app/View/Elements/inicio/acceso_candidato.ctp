<?php 

    $candidato= $this->params['controller'] !== 'empresas' ?  true:false;
?>

<div class="accordion-group_inicio">
  <div class="accordion-heading_inicio">
    <?php 

    $data_menu= $candidato ? 'data-toggle="collapse" data-parent="#accordion2" href="#collapseOne"':'href="/"';
    ?>
    <a class="btn <?=$candidato ? 'btn_color':'' ?> btn-medium pull-left collapsed"  <?=$data_menu?>  >
      <i class="icon-key"></i> Acceso a candidatos</a>
    </div>

    <?php  if ($candidato) {?>
    <div id="collapseOne" class="accordion-body collapse_inicio collapse" style="height: 0px;">
      <div class="accordion-inner_inicio">
          <?php
          echo $this->Form->create('CandidatoUsuario',  array( 'url'=> array('controller' => 'candidato','action' => 'iniciar_sesion'),
            "class"=>'form-search whell',
            'id'=>'login_form_candidato',
            'data-component' => 'validationform',
            'inputDefaults' => array(
              'label' => false,
              'div' => false
              ) ) );
              ?>



        <?php
          echo $this->Form->input('CandidatoUsuario.cc_email', array(
            'label'=>false,
            'div'=> array("class" => "parent_" ,"style" =>"margin-top:35px"),
            'class'=>'input-block-level',
            'placeholder' => 'Correo Electrónico'));

          echo $this->Form->input('CandidatoUsuario.cc_password', array(
            'label'=>false,
            'div'=> array("class" => "parent_","style" =>"margin-top:35px"),
            'class'=>'input-block-level',
            'type' => 'password',
            'placeholder' => 'Contraseña'));
        ?>
        
        <?php

          echo $this->Form->submit( 'Entrar',array(
            'label'=>false,
            'div'=> array("class" => "center","style"=>"margin-top:10px"),
            'class'=>'btn'));

            ?>
            <div class="row">

              <?php
                    $opt_registra= empty($micrositio) ?   array(
                          "class" => "registrate-candidato" ,
                          "data-component" => "triggerelement",
                          "data-target" => ".option-registrate-candidato"
                        ):  array(
                        "id"=>"registrate-can",
                        "data-toggle"=>"modal",
                        "data-target"=>"#modal-nuevo-form-candidato01",
                        "data-backdrop"=>"static",
                        "data-keyboard"=>"false"
                        );
                    $opt_contrasena=empty($micrositio) ? array(
                          "class" => "recupera-cont-candidato" ,
                          "data-component" => "triggerelement",
                          "data-target" => ".option-recuperar-contrasena-candidato"
                      ):array(
                      "id"=>"recupera-contra",
                      "data-toggle"=>"modal",
                      "data-target"=>"#recuperar_pass",
                      "data-backdrop"=>"static",
                      "data-keyboard"=>"false"
                    );

              ?>
              <?php
                // echo $this->Html->link('Regístrate',"#",$opt_registra);
                // echo ' / ';
                echo "<div class='center' style='margin-bottom:10px;margin-top:10px'>".
                $this->Html->link('¿Olvidaste tu contraseña?',"#", $opt_contrasena) ."</div>";
              ?>
              <div class="center" style="margin-bottom:10px">
                <a data-toggle="collapse" data-parent="#accordion2" href="#collapseOne" class="btn-danger btn">Cerrar</a>
              </div>     

              <?php  if (empty($micrositio)) {?>
                  <div class="center" >
                    <?=$this->Html->tag("button","<i class='fa fa-facebook'></i> | Conectar con Facebook",
                  array(
                        "login_text" =>"Iniciar Sesión",
                        'style' =>"font-size:11px",
                        "class" =>"btn btn-facebook login-fb" ,
                        "data-redirect"=>"/verificaCuenta?autentificar=facebook"
                    )
                     )
                  ?>                   
              </div>  
              <?php }?>    
              
            </div>
            <?= $this->Form->end()?>

      </div>
    </div>
    <?php }?>
  </div>