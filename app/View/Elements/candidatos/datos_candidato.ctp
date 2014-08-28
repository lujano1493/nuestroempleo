   
  <?php  if ( !empty($this->data)   )  :?>

    <?php 
      $candidato=$this->data;
      list($dia, $mes, $anio) = split('[/.-]', $candidato['Candidato']['candidato_fecnac']);
      $meses_nombre=array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

      $mes=$meses_nombre[$mes -1 ];

      $ciudad= $candidato ['Ciudad']['ciudad_nom'];
      $estado= $candidato ['Estado']['est_nom'];      

      $modulo=$this->name;


      $ultima_conexion=$authUser['Candidato']['ultima_conexion'];

      $postulaciones= classRegistry::init("Postulacion")->num_postulaciones($candidato['Candidato']['candidato_cve']);

      $visitas= classRegistry::init("VisitaCV")->num_visitas($candidato['Candidato']['candidato_cve']);



    ?>


    <?php  if($modulo != 'Portafolio' )  : ?>
      <?=$this->element("candidatos/editar_foto") ?>
    <?php endif; ?>
   <div class="span3 datos_candidato" style="margin-left:10px;margin-right:10px">

            
           
       <div class="tabular center">
          <img class="foto-candidato" src="/img/candidatos/default.jpg" width="100" height="130">
           <?php  if($modulo != 'Portafolio' )  : ?>
             <p><a  id="subefoto01" href="#" title="Tu fotografía debe  mostrar el rostro de frente, vestimenta apropiada para el puesto, una apariencia seria y responsable. Evita im&aacute;genes en reuniones sociales, desenfocadas y con exceso de maquillaje." data-component="tooltip" data-placement="bottom" class=" subir-foto">
              <span  >Subir fotograf&iacute;a</span>
            </a></p>
          <?php endif; ?> 
        </div>
       <h3><?=$candidato['Candidato']['nombre_'] ?> </h3>
       <h3>  <?=$estado?>, <?=$ciudad ?> </h3>
       <p>
            <?=$candidato['Candidato']['edad'] ?>   años<br/> 
            <?=$dia ?> de <?=$mes?> de <?=$anio ?>  <br/>
              Última conexión <?=$ultima_conexion?>

       </p>


       <div class="span2" style="padding-left:15px;">
          <a class="btn_color btn-small strong" href="<?=$this->Html->url(array("controller" => "postulacionesCan","action" => "index"))?>" > 
            <?= $postulaciones ?>
          </a> Postulaciones
        </div>
        <br/>
        <br/>
      <div class="span2" style="padding-left:15px;">
          <span  id="visitas-cv01" class="badge"   data-value="<?=$visitas?>"  > 
            <?= $visitas ?>
          </span> Han visto tu perfíl
        </div>
       <!-- <div class="span2"  style="padding-left:15px;"><button class="btn_color btn-small strong">4</button> Han visto tu perf&iacute;l</div><br><br> -->
        <div class="span3">
            <?=$this->element("candidatos/status_cv"); ?>
        </div>   
    </div>



<?php endif; ?>