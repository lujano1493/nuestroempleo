<?php
$list=ClassRegistry::init("Catalogo")->get_list_candidato();

?>

<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>
  CV candidato
  </title><style>

  body {
    font-family: sans-serif;
    font-size: 10pt;

  }
  table.separate {
    border-collapse: separate;
    border-spacing: 8pt;

  }
  .name{
    font-size: 10pt;
    font-weight: bold;

  }

  p{
    border:   10px solid #FFFFFF;
  }


  ul
  {
    list-style-type: square;    
    padding: 1px;
    margin: 5px;
  }
  ul li
  {

    background-repeat: no-repeat;
    background-position: 0px 5px; 
    padding-left: 14px; 
  }

  table.separate td {

  }
  h1 { font-size:25px; text-align:left; font-weight:bold; }
  .pre { margin:10px 0; padding:5px; font-size:10px; font-family: sans-serif;}

  .border {border-left: 1px dotted #666; text-align:justify;}
  .tit { font-size:14px; color:#666; font-weight:bold;}
  </style>
</head>
<body>
  <p>
    <table class="separate" style="width:100%">
      <tr>
        <td colspan="3">  
          <h1 style="text-align: center;">  <?= htmlentities( $info['Candidato']['candidato_perfil'])?> </h1> 
        </td>
      </tr>
      <tr>
        <td style="width:20%">
          <?php  
          $url_img= ( !empty($info['DocCanFoto'] ) ) ? "documentos/candidatos/".$info['Candidato']['candidato_cve']."/foto.jpg":"img/candidatos/default.jpg"

          ?>
          <img src="<?=$url_img?>" width="100" height="130" >
        </td>
        <td style="width:33%">
          <strong>Datos Personales:</strong>
          <div class="pre">
            <div  class="name" ><?=htmlentities( $info['Candidato']['nombre_'])?></div>
            <div><?= htmlentities($info['Ciudad']['ciudad_nom']) ?>  ,
              <?= htmlentities($info['Estado']['est_nom'])?>, 
              &nbsp;<?= htmlentities($info['Pais']['pais_nom'])?>                  
            </div>
            <div>     C.P. <?=$info['CodigoPostal']['cp_cp']?>  </div>
            <div><?=htmlentities( $info['Candidato']['edad'])?> a&ntilde;os</div>
            <div>Sueldo deseado: <?=$list['elsueldo_cve'][$info['ExpEcoCan']['explab_sueldod'] ] ?></div>
          </div>
        </td>
        <td style="width:33%">
         <strong>Datos de contacto:</strong>
         <div class="pre">
          <div  class="name" > &nbsp; </div>
          <div>
            <?=$authUser['cc_email']?>
          </div> 
          <div>Celular: <?=$info['Candidato']['candidato_movil']?></div> 
          <div>Tel&eacute;fono: <?=$info['Candidato']['candidato_tel']?></div>
          <div>&nbsp;</div>
        </div>
      </td> 
    </tr>     
    <tr>
    </tr>     
  </table>
</p>
<p>

  <table class="separate" style="width:100%">
    <tbody>

      <?php  if (!empty($info['ExpLabCan']))   :?>
      <tr>
        <td valign="top" colspan="2" style="text-align:center;" class="tit">Experiencia profesional</td>
      </tr>



      <?php foreach ($info['ExpLabCan'] as $value ) :?>
      <tr>
        <td valign="top" style="padding:10px;width:30%"> 
          <strong> 
            <?=Funciones::formato_fecha_1($value['explab_fecini'],$value['explab_fecfin']) ?> 
          </strong> 
        </td>
        <td valign="top" style="padding:10px;width:70%" class="border"> <strong><?=htmlentities($value['explab_puesto'])?></strong> <br>
          <?=htmlentities($value['explab_empresa'])?> - <?= htmlentities($list['giro_cve'][$value['giro_cve']])?> <br>
          <?=htmlentities($value['explab_funciones'])?>
        </td>
      </tr>      
    <?php endforeach ?>
  <?php endif; ?>
</tbody>
</table>
</p>
<p>
 <table class="separate" style="width:100%">
  <tbody>

    <?php  if (!empty($info['EscCan']))   :?>
    <tr>
      <td valign="top" colspan="2" style="text-align:center;" class="tit">Educaci&oacute;n</td>
    </tr>

    <?php foreach ($info['EscCan'] as $value ) :?>
    <?
    $car_o="";$titulado="";
    if($value['ec_nivel'] >0 && $value['ec_nivel'] <= 3  ){
      $car_o=$list['ec_nivel'][$value['ec_nivel']];

    }
    else if($value['ec_nivel'] >= 4 && $value['ec_nivel'] <=8 ){


      $car_o= $value['EscCarEspe']['cespe_nom'];
      if($value['ec_nivel'] >= 6 && $value['ec_nivel'] <=8 ){
        $titulado= ($value['ec_nivel'] == 8 ) ?"Titulado":  "No titulado";
      }            


    }
    else{
      $car_o=$value['ec_especialidad'];
    }

    ?>

    <tr>
      <td valign="top" style="padding:10px;width:30%"> 
        <strong>
          <?=Funciones::formato_fecha_1($value['ec_fecini'],$value['ec_fecfin']) ?>
        </strong>
      </td>        
      <td valign="top" style="padding:10px;width:70%" class="border">
       <?=htmlentities($car_o)?><br/><?=htmlentities($value['ec_institucion'])?>. <?=$titulado?>.
     </td>
   </tr>        
 <?php endforeach ?>

<?php endif; ?>
</tbody>
</table>
</p>
<p>
 <table class="separate" style="width:100%">
  <tbody>



    <?php  if (!empty($info['CursoCan']))   :?>
    <tr>
      <td valign="top" colspan="2" style="text-align:center;" class="tit">Cursos</td>
    </tr>


    <?php foreach ($info['CursoCan'] as $value ) :?>
    <tr>
      <td valign="top" style="padding:10px;width:30%"> 
        <strong>
          <?=Funciones::formato_fecha_1($value['curso_fecini'],$value['curso_fecfin']) ?>
        </strong>  
      </td>
      <td valign="top" style="padding:10px;width:70%" class="border">
        <?=htmlentities($value['curso_nom'])?><br/><?=htmlentities($value['curso_institucion'])?>.
      </td>
    </tr>
  <?php endforeach ?>

<?php endif; ?>
</tbody>
</table>
</p>
<p>

 <table class="separate" style="width:100%">
  <tbody>

    <?php  if (!empty($info['AreaIntCan']))   :?>
    <tr>
      <td valign="top" style="padding:10px;;width:30%" >
        <strong>&Aacute;reas de inter&eacute;s: </strong>
      </td>

      <td valign="top" class="border" style="width:70%" >
        <ul>
          <?php foreach ($info['AreaIntCan'] as $value ) :?>
          <li> 
            <?=htmlentities($value['AreaInt']['area_nom'] )?>
          </li>
        <?php endforeach; ?>
      </ul>
    </td>
  </tr>
<?php endif; ?>
</tbody>
</table>
</p>
<p>

 <table class="separate" style="width:100%">
  <tbody>

    <?php  if (!empty($info['HabiCan']))   :?>
    <tr>
      <td valign="top" style="padding:10px;width:30%"> <strong>Habilidades:</strong> 
      </td>
      <td valign="top" class="border" style="width:70%" >
        <ul>
          <?php foreach ($info['HabiCan'] as $value ) :?> 
          <li> 
            <?=htmlentities($list['habilidad_cve'][$value['habilidad_cve']])?>
          </li>
        <?php endforeach; ?>

      </ul> 
    </td>
  </tr>
<?php endif; ?>
</tbody>
</table>
</p>
<p>

 <table class="separate" style="width:100%">
  <tbody>

    <?php  if (!empty($info['ConoaCan']))   :?>
    <tr>
      <td valign="top" style="padding:10px;width:30%"> <strong> Conocimientos adicionales:</strong> 
      </td>
      <td valign="top" class="border" style="width:70%">
        <ul>
          <?php foreach ($info['ConoaCan'] as $value ) :?> 
          <li><?=htmlentities($value['conoc_descrip'])?></li>

        <?php endforeach; ?>
      </ul>
    </td>
  </tr>
<?php endif; ?>
</tbody>
</table>

</p>
<p>

 <table class="separate" style="width:100%">
  <tbody>

    <?php  if (!empty($info['IdiomaCan']))   :?>
    <tr>
      <td valign="top" style="padding:10px;width:30%"> <strong>Idiomas:</strong> 
      </td>
      <td valign="top" style="width:70%" class="border">
        <ul>
          <?php foreach ($info['IdiomaCan'] as $value ) :?>
          <li><?=htmlentities($value['Idioma']['idioma_nom'])?> <?=htmlentities($list['ic_nivel'][$value['ic_nivel']])?></li>
        <?php endforeach ?>

      </ul>
    </td>
  </tr>
<?php endif; ?>
</tbody>
</table>
</p>
<p>
 <table class="separate" style="width:100%">
  <tbody>

    <?php  if (!empty($info['RefCan']))   :?>
    <tr>
      <td valign="top" colspan="2" style="text-align:center;" class="tit">Referencias personales</td>
    </tr>

    <?php foreach ($info['RefCan'] as $value ) :?>
    <tr>

      <td valign="top" colspan="2" style="padding:10px;">

        <strong>
         <?=htmlentities($value['refcan_nom'])?> 
       </strong>
       <div><?=htmlentities($value['refcan_mail'])?> / Tel&eacute;fono:  <?=$value['tipo_movil'] == 1 ? 'Movil':"Fijo" ?>  <?=htmlentities($value['refcan_tel'])?> </div>

     </td>
   </tr>

 <?php endforeach  ?>
<?php endif; ?>

</tbody>
</table>
</p>





</body></html>