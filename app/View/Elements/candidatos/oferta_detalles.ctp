

<!--<div class="alert-container clearfix">
  <div class="alert alert-info fade in popup" data-alert="alert">
    Ya te has postulado a esta oferta.
  </div>
</div>-->
  <?php

    $Oferta=$oferta['Oferta'];
    $id=$Oferta['oferta_cve'];
    //$oferta['Empresa']['cia_nombre']

     // debug($Oferta['oferta_privada'] );


  ?>
<div id="oferta-vista" class="without-space">
    <?
    echo $this->Session->flash();
  ?>

  <?php if(!$isAuthUser) :?>

  <div class="alert alert-info fade in popup" data-alert="alert">
      <h5>
          <div class="row-fluid">
           <div class="span12">
                <i class="icon-info-sign icon-3x"></i>&nbsp;
                  Para poder postularte en esta oferta es necesario ingresar como candidato.
              </div>
          </div>
          <div class="row-fluid">
            <div class="span12">
                 <a href="#" class="btn btn-info" style="width:150px"  data-trigger-slide="#login_form02" > Acceder</a>
            </div>
          </div>
      </h5>
    </div>


    <div class="row-fluid">
      <?=$this->element("candidatos/login_form")?>

    </div>

  <?php  endif; ?>



  <?php echo ($this->Form->input("idOferta",array(
                                    "type" => "hidden",
                                    "value" => $id

  ) )) ?>
   <input type="hidden" id="oferta_cve" name data-url-change-value="/PostulacionesCan/oferta_detalles/<?=$id?>/true" />

  <div class="row-fluid oferta-detalle">

<div class="span9 margen_derecho">
  <div class="span6_oferta">
    <div class="ofertas_back left">
      <div class="row">
        <div class="left span9">
          <?php if( $Oferta['oferta_privada']  != "1"   ):?>
            <h3> <?=$oferta['Empresa']['cia_nombre']?></h3>
          <?php  endif; ?>
          <h4>   <?=$Oferta['puesto_nom'] ?> </h4>
          <p>     <?=$oferta['Direccion']['ciudad']?>,  <?=$oferta['Direccion']['estado']?>.  </p>
          <p> <?=$this->Time->d($Oferta['oferta_fecini'])?></p>
        </div>
        <div class="span3  pull-right">

            <?php
                $cia_cve=$oferta['Oferta']['cia_cve'];
                $ruta_img=  $Oferta['oferta_privada']  == "1"   ?   "/img/oferta/img_oferta_priv.jpg"   :Funciones::check_image_cia($cia_cve);

                $img_tipo_oferta="";
                if( $Oferta['oferta_status'] == "2"){
                    $img_tipo_oferta="/img/oferta/img_oferta_reco.jpg";

                }  else  if ($Oferta['oferta_status'] == "3" ){
                    $img_tipo_oferta="/img/oferta/img_oferta_dis.jpg";

                }
            ?>

            <?php if($Oferta['oferta_status'] > 1):?>
               <img id="img" src="<?=$img_tipo_oferta?>"  width="200px" height="70px"  style="width:200px;height:80px;margin:auto">

            <?php endif; ?>

            <?php

                if($Oferta['oferta_privada']!=1){
                  $base_url=Router::url('/', true);
                  $length=strlen($base_url);
                  $url=substr($base_url,0,$length-1);
                  $this->Html->meta(array("property"=>"og:image","content" =>$url.$ruta_img   ),null, array('inline' => false));
                  $this->Html->meta(array("property"=>"og:image:type","content" =>"image/jpeg"  ),null, array('inline' => false));
                  $this->Html->meta(array("property"=>"og:image:width","content" =>"900"   ),null, array('inline' => false));
                  $this->Html->meta(array("property"=>"og:image:height","content" =>"600"   ),null, array('inline' => false));
                }

            ?>


            <img id="img" src="<?=$ruta_img?>"  width="200px" height="70px"  style="width:200px;height:80px;margin:auto" >


        </div>

      </div>
      <h5>Requisitos</h5>

      <p>+ Experiencia:           <?=$oferta['Catalogo']['experiencia']?> </p>
      <p>+ Escolaridad:           <?=$oferta['Catalogo']['escolaridad']?> </p>
      <p>+ Género:                <?=$oferta['Catalogo']['genero']?> </p>
      <p>+ Estado Civil:          <?=$oferta['Catalogo']['edocivil']?>     </p>

      <?php if ( $Oferta['oferta_privada'] == "1" ) : ?>
        <p>+ Oferta Privada</p>
      <?php  endif;?>
      <?php
            $e_max=$Oferta['oferta_edadmax'];
            $e_min=$Oferta['oferta_edadmin'];
            $rango_edad = ( $e_max && $e_min ) ?  "De $e_min a $e_max años":"Indistinto";




      ?>


      <p>+ Edad: <?=$rango_edad?></p>
      <p>+ Disponibilidad:    <?=$oferta['Catalogo']['disponibilidad']?>  </p>

     <?php if ( $Oferta['oferta_viajar'] ) : ?>

        <p>+ Disponibilidad para viajar</p>
      <?php  endif;?>
     <?php if ( $Oferta['oferta_residencia'] ) : ?>
        <p>+ Disponibilidad para cambiar de residencia</p>
      <?php  endif;?>


      <h5>Descripción de la Oferta</h5>

      <?=$Oferta['oferta_descrip']?>




      <h5>Tipo de empleo y remuneración</h5>
      <p>+ <?=$oferta['Catalogo']['tipo_empleo']?>   </p>

      <p>+ Sueldo: <?=$Oferta['sueldo']?>  </p>


       <?php
        $arra_bene=Oferta::prestaciones_str($oferta["Oferta"]['oferta_prestaciones']);
      ?>

      <?php  foreach ($arra_bene as $value) :?>
        <p>+  <?=$value?>  </p>
      <?php endforeach; ?>

      <?php  if($Oferta['oferta_privada'] != "1"  && $isAuthUser  ) :
        $nombre=$oferta['UsuarioEmpresa']['nombre'];
        $correo=$oferta['UsuarioEmpresa']['cu_sesion'];
        $telefono=$oferta['UsuarioEmpresa']['telefono'];
      ?>
         <h5>DATOS DE CONTACTO</h5>
        <p>  <strong>Nombre:</strong>   <?=$nombre?>  </p>
         <p>  <strong>Correo Electrónico:</strong>   <?=$correo?>  </p>
        <p>  <strong>Teléfono:</strong>   <?=$telefono?>  </p>
      <?php  endif;?>
    </div>
  </div>
 </div>
 <div class="span3">
    <div class="span3_pennant pull-right">
          <?php

              echo $this->element("candidatos/redes_sociales",array(
                  "label" => "esta oferta",
                  "link" => $Oferta['oferta_link'],
                  "title" => $Oferta['puesto_nom']
                )
              );

             ?>

    </div>
    <div class="row-fluid">
            <?php
                $is_premium =ClassRegistry::init('FormularioContactoPremium')->hasAny(array(
                  "cia_cve" => $Oferta['cia_cve'],
                  "premium_status" => 1

                   ) );
            ?>
            <?php  if( $is_premium):?>
              <div
                  class="img-premium"
                  title="Esta vacante cuenta con la Certificación de Empresa confiable que otorga Nuestro Empleo a través de su proceso de verificación"
                  data-placement="top"
                  >
                <img src="/img/premium_sello.png" style="margin-top: 50px">
              </div>
            <?php endif;?>
    </div>
  </div>



</div>
<div class="row-fluid">
     <?php if($isAuthUser) :?>

      <div style="padding-top:15px;">
        <form >
          <?php
              $nopostulado=ClassRegistry::init("Postulacion")->checaPostulacion($Oferta['cia_cve'],$Oferta['cu_cve'],$Oferta['oferta_cve'],$authUser['candidato_cve']) ;
          ?>
            <?php

              $color_button=" btn_color";
              $icon_button="icon-thumbs-up";
              $accion="postularse";
              $text_button="Postularse";
            if(!$nopostulado) {

              $color_button=" btn-danger";
              $icon_button="icon-remove";
              $accion="quitar";
              $text_button="Quitar Postulación";

            }



              ?>


           <div class="autoajustable" data-type="elementreplece" >
           
              <?=$this->Html->link("<i class=\"$icon_button\"></i>&nbsp;<span> $text_button</span>",
                array("controller" => "postulacionesCan" ,"action" => $accion, "id" => $Oferta['oferta_cve'] ),
                array("data-component" => "ajaxlink","class" => "btn $color_button btn-large  " , "escape" => false))?>
              
            </div>
          <?php    if(!$denuncia_previa){ ?>
          <?=$this->Html->link("<i class=\"icon-thumbs-down\"></i> <span> Reportar oferta </span>","#",
              array("data-trigger-slide" => "#denunciar01","class" =>"btn  btn-danger btn-large", "escape" => false))?>

            <?php }?>
        
        </form>
      </div>

      <?php    if(!$denuncia_previa){ ?>

        <?= $this->element('candidatos/reportar_oferta', array(
                                                                'id' => $Oferta['oferta_cve']
            ))
        ?>
        <?php }?>

  <?php if (  $Oferta['oferta_preguntas'] =='1' ) :?>
    <?=$this->element("candidatos/comentarios")?>
  <?php endif; ?>


    <?php  endif;?>




<?=$this->Template->insert(array(
        'boton_postular',
        'boton_quitar',
      ), null, array(
        'viewPath' => 'PostulacionesCan'
      ));
?>
</div>

</div>

<?=$this->Template->insert(array(
        'compartir'
      ), null, array(
        'viewPath' => 'BusquedaOferta'
      ));
?>