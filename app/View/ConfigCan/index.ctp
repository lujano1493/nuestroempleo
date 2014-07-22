<?php

    $option_button=array(
        "cuenta" => array(
            "desactivar" =>array(
                "id" => "descaactivar01",
                "title" => "Tu cuenta será inactivada y ningún reclutador podrá ver tus datos, además todas tus postulaciones serán eleminadas. Tendrás 60 días para reactivarla antes de ser eliminado permanentemente del sistema",
                "label" => " Desactivar Cuenta  ",
                "icon" => "remove-sign",
                "class" => " btn-danger",
                "href" =>  $this->Html->url(array("controller" => "configCan", "action" =>"desactivar_cuenta" ) ) 
            ) ,
            "activar"=> array(
                  "id" => "activar01",
                "title" => "Activa tu cuenta para tener oportunidades de  empleo.",
                "label" => " Activar Cuenta",
                "icon" => "ok-sign",
                "class" => " btn_color",
                "href" =>  $this->Html->url(array("controller" => "configCan", "action" =>"desactivar_cuenta" ) )

            )            
        ),
        "facebook"=> array(
                "desactivar" =>array(

                    "id" => "desenlazar-fc",
                    "title" => "Desenlazar Cuenta de Facebook",
                    "label" => "Desenlazar Cuenta de Facebook",
                    "icon" => "remove-sign",
                    "class" => "btn-info  login-fb",
                    "redirect" =>   $this->Html->url(array("controller" => "configCan", "action" =>"desactivar_facebook" ) )

                ) ,
                "activar"=> array(

                    "id" => "enlaza-fc",
                    "title" => "Enlaza Cuenta de Facebook",
                    "label" => "Enlaza Cuenta de Facebook",
                    "icon" => "ok-sign",
                    "class" => "btn_color login-fb",
                    "redirect" =>   $this->Html->url(array("controller" => "configCan", "action" =>"activar_facebook" ) ),
                    "href" => "#" 


                )          


            )


        );

    


?>



<div class="forma_genral_tit"><h2>Mi Cuenta</h2></div>

<div class="alert alert-info fade in popup" data-alert="alert">
    <i class="icon-info-sign icon-3x"></i>&nbsp;&nbsp;&nbsp;
     Configura tu información personal, notificaciones, contraseña y medios de contacto.</div>
<?=$this->element("candidatos/datos_candidato") ?>


<div class="span9 formulario">
    <?=$this->Session->flash()?>
    <?=$this->Form->create('',  array( 'url'=>  array('controller'=>'ConfigCan','action' => 'guardar_configuracion'),
            "class"=>'form-horizontal  well',
            'data-component'=>"validationform  ajaxform",
            'data-onsucces'=>json_encode(array("action"=>"show"  )), 
            'id'=>'form-config01', 
            'inputDefaults' => array(
              'label' => false,
              'div' => false
              ) ) );
          ?>

                
             <fieldset>
                <h3>Datos personales</h3>
                <br/>
                <br/>
                <br/>
                    <div class="row tabular center">
                        <div class="span3">
                            <label class="pull-left">Nombre*:</label>
                        </div>
                        <div class="span5">
                            <?=$this->Form->input("Candidato.candidato_cve" , array(
                                                                                                                                                    
                            ))?>
                            <?=$this->Form->input("Candidato.candidato_nom" , array(
                                //'label' => 'Nombre*:' ,
                                'class' =>'input-medium-formulario',
                                'div' => array('class'=>'controls')                                                     
                            ))?>
                        </div>
                    </div>
                <div class="row">
                    <div class="span3">                                                                                     
                        <label class="pull-left">Apellido Paterno*:</label>
                    </div>
                    <div class="span5">
                        <?=$this->Form->input("Candidato.candidato_pat" , array(
                                //'label' => 'Apellido Paterno*:' ,
                                'class' =>'input-medium-formulario',
                                'div' => array('class'=>'controls')                                                     
                        ))?>
                    </div>
                </div>
                <div class="row">
                    <div class="span3">                                                                                     
                        <label class="pull-left">Apellido Materno:</label>
                    </div>
                    <div class="span5">
                    <?=$this->Form->input("Candidato.candidato_mat" , array(
                                //'label' => 'Apellido Materno:' ,
                                'class' =>'input-medium-formulario',
                                'div' => array('class'=>'controls')                                                                                                                         
                            ))?>
                    </div>
                </div>
                <div class="row">
                    <div class="span3">                                                                                     
                        <label class="pull-left">Correo Electrónico:</label>
                    </div>
                    <div class="span5">
                    <?=$this->Form->input('CandidatoUsuario.cc_email', array(
                                    //'label' => 'Correo ElectrÃ³nico:' ,
                                    'class' =>'input-medium-formulario',
                                    'type' => 'text',
                                    'value' =>  $authUser['cc_email'],
                                    'disabled' => true,
                                    'div' => array('class'=>'controls')                                                                                                                         
                                ))?>
                    </div>
                </div>
                        <div class="row"><div class="span9 pull-left">
                            Por favor selecciona las notificaciones que quieres recibir y elige los 
medios por los que deseas ser contactado:
                            <!--<div class="span4">
                                <//?=$this->Form->input('CandidatoUsuario.cc_email', array(
                                    'label' => 'Correo ElectrÃ³nico:' ,
                                    'class' =>'input-medium-formulario',
                                    'type' => 'text',
                                    'value' =>  $authUser['cc_email'],
                                    'disabled' => true,
                                    'div' => array('class'=>'controls')                                                                                                                         
                                ))?>
                            </div>
                             <div class="span4" style="padding-top:15px;">
                             <button class="btn_color "><i class="icon-envelope"></i>&nbsp;Cambiar correo electr&oacute;nico</button>                       
                            </div> -->
                            </div>
                        </div><br>
                <!-- notificaciones-->
                <div class="row-fluid">
                    <?=$this->element("configcan/notificacion") ?>
                <div class="span2" data-type= style="padding-top:25px;">
                            <button class="btn btn_color" data-target="#change_pass1"   data-toggle="modal" data-keyboard="false" data-backdrop="static"   ><i class="icon-barcode "></i>&nbsp;Cambiar contraseña</button>   
                            </div>
                            <div class="span2" data-type="elementreplece">
                                <?=$this->element("candidatos/button_link",  
                                    $option_button['cuenta'][ $authUser['cc_status']== 1 ?'desactivar':'activar' ]

                                 )?>
                            </div>

                            <div class="span2"  data-type="elementreplece">
                                <?=$this->element("candidatos/button_fb",  
                                   $option_button['facebook'] [!empty($authUser['facebook_id'])   ?'desactivar':'activar' ]

                                 )?>

                            </div>
                </div>  
                <?=$this->Form->submit("Guardar", array ("class"=>'btn_color pull-right',
                                                         "title"=>"Revisa cuidadosamente los datos antes de guardar." , 
                                                         'data-component' => "tooltip",
                                                         "data-placement" => "bottom", 
                                                         "div"=>array("class"=>'form-actions')));  ?>
                </fieldset>
                <?= $this->Form->end();  ?>

</div>

    



<?php
  echo $this->Template->insert(array(
    'activar',
    'desactivar',
    'activar-facebook',
    'desactivar-facebook'
  ));
?>



<?=$this->element("configcan/cambio_contrasena")  ?>
