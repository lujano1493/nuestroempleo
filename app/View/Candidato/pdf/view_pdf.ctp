<?php
  $list=ClassRegistry::init("Catalogo")->get_list_candidato();

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>
      CV candidato
    </title>

<style>
      
    #wrap { margin:30px auto; width:80%; font-family:sans-serif; color:#444; cursor:default; }
    h1 { font-size:30px; text-align:center; font-weight:bold; margin-bottom:30px; text-shadow:0 0 3px #ddd; }
    pre { background-color:#eee; margin:10px 0; padding:5px; font-size:10px;}
    p.demo { background-color:orange; width:100px; margin:10px 0; font-family:monospace; }
    img{
      width: 100px;
      height: 130px;

    }
    </style>

</head>

<body>

<div id="wrap">
    <h3><?= htmlentities( $info['Candidato']['candidato_perfil'])?></h3>
    <p> Datos Personales: </p>

    <?php  $url_img= ( !empty($info['DocCanFoto'] ) ) ? "documentos/candidatos/".$info['Candidato']['candidato_cve']."/foto.jpg":"img/candidatos/default.jpg"   ?>

<pre><img src="<?=$url_img?>" width="100" height="130"><br/> <br/>
Nombre: <?=htmlentities( $info['Candidato']['nombre_'])?><br/>
Edad: <?=htmlentities( $info['Candidato']['edad'])?> a&ntilde;os<br/>
Direcci&oacute;n: <?= htmlentities($info['Ciudad']['ciudad_nom']) ?>  ,<?= htmlentities($info['Estado']['est_nom'])?>, &nbsp;<?= htmlentities($info['Pais']['pais_nom'])?> C.P. <?=$info['CodigoPostal']['cp_cp']?><br/>
Sueldo: <?=$list['elsueldo_cve'][$info['ExpEcoCan']['explab_sueldoa'] ] ?>
</pre>
    <p> Datos de contacto: </p>
<pre>E-mail: <?=$authUser['cc_email']?><br/>
Celular: <?=$info['Candidato']['candidato_movil']?><br/>
Tel&eacute;fono: <?=$info['Candidato']['candidato_tel']?><br/>
</pre>
<hr>
    <p> Experiencia Profesional: </p>
</hr>

  <?php foreach ($info['ExpLabCan'] as $value ) :?>
        
          <p> <?=Funciones::formato_fecha_1($value['explab_fecini'],$value['explab_fecfin']) ?> </p>
      <pre><?=htmlentities($value['explab_puesto'])?><br/><?=htmlentities($value['explab_empresa'])?> - <?= htmlentities($list['giro_cve'][$value['giro_cve']])?> - <br/><?=htmlentities($value['explab_funciones'])?>
      </pre>

<?php endforeach ?>

  <hr>
  <p> Educaci&oacute;n </p>
  </hr>

  <?php foreach ($info['EscCan'] as $value ) :?>
        
          <p> <?=Funciones::formato_fecha_1($value['ec_fecini'],$value['ec_fecfin']) ?> </p>
          <?
            $car_o="";$titulado="";
            if($value['ec_nivel'] >0 && $value['ec_nivel'] <= 3  ){
                $car_o=$list['ec_nivel'][$value['ec_nivel']];

            }
            else if($value['ec_nivel'] >= 4 && $value['ec_nivel'] <=8 ){


              $car_o=$value['EscCarEspe']['cespe_nom'];
              if($value['ec_nivel'] >= 6 && $value['ec_nivel'] <=8 ){
                $titulado= ($value['ec_nivel'] == 8 ) ?"Titulado":  "No titulado";
              }            


            }
            else{
              $car_o=$value['ec_especialidad'];
            }

          ?>
      <pre><?=htmlentities($car_o)?><br/><?=htmlentities($value['ec_institucion'])?>. <?=$titulado?> 
      </pre>

<?php endforeach ?>



<?php  if(!empty($info['CursoCan']  )) :?> 
  <hr>
  <p> Cursos </p>
    </hr>

<?php endif; ?>
  <?php foreach ($info['CursoCan'] as $value ) :?>
        
          <p> <?=Funciones::formato_fecha_1($value['curso_fecini'],$value['curso_fecfin']) ?> </p>
      <pre><?=htmlentities($value['curso_nom'])?><br/><?=htmlentities($value['curso_institucion'])?>.</pre>

<?php endforeach ?>
   

  <?php  if(!empty($info['ConoaCan']  )) :?> 
  <hr>
  <p> Conocimientos adicionales: </p>
    </hr>
  <?php endif; ?>

<pre><?php foreach ($info['ConoaCan'] as $value ) :?>- <?=htmlentities($value['conoc_descrip'])?><br><?php endforeach ?></pre>

  <?php  if(!empty($info['HabiCan']  )) :?> 
      <hr>
    <p> Habilidades: </p>
      </hr>
  <?php endif; ?>

<pre><?php foreach ($info['HabiCan'] as $value ) :?>- <?=htmlentities($list['habilidad_cve'][$value['habilidad_cve']])?><br><?php endforeach ?></pre>

  <?php  if(!empty($info['AreaIntCan']  )) :?> 
      <hr>
    <p> &Aacute;reas de interes: </p>
      </hr>
  <?php endif; ?>

<pre><?php foreach ($info['AreaIntCan'] as $value ) :?>- <?=htmlentities($value['AreaInt']['area_nom'] )?><br><?php endforeach ?></pre>

  <?php  if(!empty($info['IdiomaCan']  )) :?> 
     <hr>
    <p> Idiomas: </p>
      </hr>
  <?php endif; ?>

<pre><?php foreach ($info['IdiomaCan'] as $value ) :?><?=htmlentities($value['Idioma']['idioma_nom'])?> <?=htmlentities($list['ic_nivel'][$value['ic_nivel']])?><br><?php endforeach ?></pre>

  <?php  if(!empty($info['RefCan']  )) :?> 
        <hr>
      <p> Referencias personales: </p>
        </hr>
  <?php endif; ?>
     <?php foreach ($info['RefCan'] as $value ) :?>
      <pre><?=htmlentities($value['refcan_nom'])?><br/>E-mail: <?=htmlentities($value['refcan_mail'])?> <br/>Tel&eacute;fono: <?=htmlentities($value['refcan_tel'])?> 
      </pre>

<?php endforeach  ?>

  
  </div>


</body></html>