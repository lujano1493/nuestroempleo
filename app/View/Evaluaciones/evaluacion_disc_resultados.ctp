      <?php 
          $id=$authUser['candidato_cve'];
          $r= split (",",Funciones::getPeticion("http://imx.obail.net/?q=num&h=disc&s=igntr&r=$id"));

        ?>

        <!-- Header -->
<div id="out_container" class="boxed">
  <!-- ventana emergente-->
  <!-- cauteloso-->
  <div class="modal fade" id="Modal" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title forma_genral_tit">Dominante (D)</h4>
      </div>
      <div class="modal-body">
      <div class="row" style="padding-bottom:15px;">
       <div class="barras span2">
<h5>Alta D</h5>
<div class="row">
<div class="progress vertical bottom progress-danger" style="margin-left:80px;"><span class="title"><strong>N</strong></span><div class="bar" style="height:<?=$r[0]?>%;" data-percentage="<?=$r[0]?>"><?=$r[0]?>%</div></div>
</div></div> 
  <div class="barras span2">
<h5>Baja D</h5>
<div class="row">
<div class="progress vertical bottom progress-danger" style="margin-left:80px;"><span class="title"><strong>A</strong></span><div class="bar" style="height: <?=$r[4]?>%;" data-percentage="<?=$r[4]?>"><?=$r[4]?>%</div></div>
</div></div>
</div>
<div class="row">
<table class="table table-bordered table-striped table-hover">
            <thead class="table-fondo-rojo">
            <tr>
            <th colspan="2">Revisa la siguiente descripción según el porcentaje que obtuviste:</th>
            </tr>
            </thead>
            <tbody>
            <tr>
            <td><strong>Alta D
</strong><br>
<span class="text-error">Demandante</span><br>
Dirigido<br>
Enérgico<br>
Osado<br>
Determinante<br>
Competitivo<br>
Responsable<br>
Inquisitivo<br>
Conservador<br>
Afable<br>
Conforme<br>
<span class="text-error">Discreto</span><br>
<strong>Baja D</strong></td>
            <td><strong>Si obtuviste una Alta D
</strong><br>
Tiendes a resolver problemas nuevos con gran rapidez y asertividad. Tomas una actitud
activa y directa dirigida a obtener resultados. La clave son los nuevos problemas, aquellos
que no tienen precedente, que no han ocurrido antes. Pueden toparse con elementos de
riesgo por adoptar un enfoque que pudiera ser equivocado o en el desarrollo de una solución incorrecta, sin embargo, aquellos con puntuación Alta en D están dispuestos a asumir los riesgos, incluso si los resultados pudieran llegar a ser incorrectos.
</td>
           </tr>
            <tr>
            <td></td>
            <td><strong>Si obtuviste una Baja D
</strong><br>
Tiendes a resolver nuevos problemas de una manera más deliberada, controlada y
organizada. Una vez más, la clave son los problemas nuevos y sin precedente. El estilo de
la D Baja es resolver los problemas de rutina muy rápidamente, pues los resultados ya se
conocen. Pero, cuando el problema es incierto y los resultados son desconocidos, el estilo
de la D Baja es acercarse al nuevo problema de forma calculada y meditada, pensando con mucho cuidado antes de actuar.
</td>
           </tr>
            </tbody>
            </table>


</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn_small" data-dismiss="modal">Cerrar</button>       
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>

<!-- Modal amarillo-->

<div class="modal fade" id="Modal2">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title forma_genral_tit">Influyente (I)</h4>
      </div>
      <div class="modal-body">
      <div class="row" style="padding-bottom:15px;">
       <div class="barras span2">
<h5>Alta I</h5>
<div class="row">
<div class="progress vertical bottom progress-warning" style="margin-left:80px;"><span class="title"><strong>N</strong></span><div class="bar" style="height:<?=$r[1]?>%;" data-percentage="<?=$r[1]?>"><?=$r[1]?>%</div></div>
</div></div> 
  <div class="barras span2">
<h5>Baja I</h5>
<div class="row">
<div class="progress vertical bottom progress-warning" style="margin-left:80px;"><span class="title"><strong>A</strong></span><div class="bar" style="height: <?=$r[5]?>%;" data-percentage="<?=$r[5]?>"><?=$r[5]?>%</div></div>
</div></div>
</div>
<div class="row">
<table class="table table-bordered table-striped table-hover">
            <thead class="table-fondo-amarillo">
            <tr>
            <th colspan="2">Revisa la siguiente descripción según el porcentaje que obtuviste:</th>
            </tr>
            </thead>
            <tbody>
            <tr>
            <td><strong>Alta I
</strong><br>
<span class="text-warning">Sociable</span><br>
Persuasivo<br>
Inspirador<br>
Entusiasta<br>
Conversador<br>
Desenvuelto<br>
Encantador<br>
Convincente<br>
Reflexivo<br>
Factual<br>
Retraído<br>
<span class="text-warning">Distante</span><br>
<strong>Baja I</strong></td>
            <td><strong>Si obtuviste una Alta I
</strong><br>
Tienden a conocer gente nueva de manera extrovertida, sociable y dinámica. La clave aquí
es la gente totalmente nueva y que no se ha visto antes. Muchos otros estilos son platicadores,
pero sobre todo con la gente que han conocido durante algún tiempo. Aquellos con un puntaje Alto en I, son parlanchines, disfrutan interactuar con los demás y son ampliamente abiertos, incluso con aquellas personas que acaban de conocer. Las personas con calificaciones dentro de este rango también pueden ser un poco impulsivas. En términos generales, los que tienen un puntaje Alto en I son generalmente locuaces y extrovertidos</td>
           </tr>
            <tr>
            <td></td>
            <td><strong>Si obtuviste una Baja I
</strong><br>
Tienden a conocer gente nueva de una manera más controlada, tranquila y reservada. Aquí
es donde la palabra clave "gente nueva" entra en ecuación. Las personas con puntuación Baja en I son mas platicadores con sus amigos y allegados, pero tienden a ser más reservados
con las personas que acaban conocer. Valoran el control de las emociones y construyen nuevas relaciones de una manera más reflexiva que emocional.
</td>
           </tr>
            </tbody>
            </table>


</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn_small" data-dismiss="modal">Cerrar</button>       
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>

<!-- MODAL VERDE-->
<div class="modal fade" id="Modal3">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title forma_genral_tit">Estable (S)</h4>
      </div>
      <div class="modal-body">
      <div class="row" style="padding-bottom:15px;">
       <div class="barras span2">
<h5>Alta S</h5>
<div class="row">
<div class="progress vertical bottom progress-success" style="margin-left:80px;"><span class="title"><strong>N</strong></span><div class="bar" style="height:<?=$r[2]?>%;" data-percentage="<?=$r[2]?>"><?=$r[2]?>%</div></div>
</div></div> 
  <div class="barras span2">
<h5>Baja S</h5>
<div class="row">
<div class="progress vertical bottom progress-success" style="margin-left:80px;"><span class="title"><strong>A</strong></span><div class="bar" style="height:<?=$r[6]?>%;" data-percentage="<?=$r[6]?>"><?=$r[6]?>%</div></div>
</div></div>
</div>
<div class="row">
<table class="table table-bordered table-striped table-hover">
            <thead class="table-fondo-verde">
            <tr>
            <th colspan="2">Revisa la siguiente descripción según el porcentaje que obtuviste:</th>
            </tr>
            </thead>
            <tbody>
            <tr>
            <td><strong>Alta S
</strong><br>
<span class="text-success">Paciente</span><br>
Predecible<br>
Pasivo<br>
Complaciente<br>
Estable<br>
Consistente<br>
Inalterable<br>
Extrovertido<br>
Incansable<br>
Activo<br>
Espontáneo<br>
<span class="text-success">Impetuoso</span><br>
<strong>Baja S</strong></td>
            <td><strong>Si obtuviste una Alta S
</strong><br>
Tienden a preferir los entornos controlados y predecibles. Tienen un alto valor por la seguridad del trabajo y el comportamiento disciplinado. Tienden a mostrar lealtad hacia su equipo u organización y como resultado, tienen mayor duración o permanencia en una posición de trabajo que los otros estilos. Es un estilo excelente para escuchar y son pacientes, coaches y maestros.
</td>
           </tr>
            <tr>
            <td></td>
            <td><strong>Si obtuviste una Baja S
</strong><br>
Tienden a preferir un entorno de trabajo más flexible, dinámico y no estructurado. Valoran
la libertad de expresión y la capacidad de cambiar rápidamente de una actividad a otra.
Tienden a aburrirse con la misma rutina que conlleva seguridad a aquellos con una S Alta.
Como resultado de ello, buscarán oportunidades y salidas para nutrir su alto sentido de urgencia y necesidad de actividad, ya que tienen una marcada preferencia por la  espontaneidad
</td>
           </tr>
            </tbody>
            </table>


</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn_small" data-dismiss="modal">Cerrar</button>       
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>
<!-- MODAL AZUL-->

<div class="modal fade" id="Modal4">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title forma_genral_tit">Cauteloso (C)</h4>
      </div>
      <div class="modal-body">
      <div class="row" style="padding-bottom:15px;">
       <div class="barras span2">
<h5>Alta C</h5>
<div class="row">
<div class="progress vertical bottom" style="margin-left:80px;"><span class="title"><strong>N</strong></span><div class="bar" style="height:<?=$r[3]?>%;" data-percentage="<?=$r[3]?>"><?=$r[3]?>%</div></div>
</div></div> 
  <div class="barras span2">
<h5>Baja C</h5>
<div class="row">
<div class="progress vertical bottom" style="margin-left:80px;"><span class="title"><strong>A</strong></span><div class="bar" style="height: <?=$r[7]?>%;" data-percentage="<?=$r[7]?>"><?=$r[7]?>%</div></div>
</div></div>
</div>
<div class="row">
<table class="table table-bordered table-striped table-hover">
            <thead class="table-fondo">
            <tr>
            <th colspan="2">Revisa la siguiente descripción según el porcentaje que obtuviste:</th>
            </tr>
            </thead>
            <tbody>
            <tr>
            <td><strong>Alta C
</strong><br>
<span class="text-info">Prudente</span><br>
Perfeccionista<br>
Sistemático<br>
Cuidadoso<br>
Analítico<br>
Metódico<br>
Pulcro<br>
Equilibrado<br>
Independiente<br>
Rebelde<br>
Descuidado<br>
<span class="text-info">Desafiante</span><br>
<strong>Baja C</strong></td>
            <td><strong>Si obtuviste una Alta C
</strong><br>
Tienden a adherirse a las reglas, normas, procedimientos y protocolos que han sido establecidos por quienes tienen autoridad y a quienes respetan. Les gusta hacer las cosas en forma correcta y con base en el manual de operación. Las reglas son hechas para seguirse, este es un lema apropiado para aquellos que tienen puntuación alta en C. Tienen un alto interés por el control de la calidad, sobre cualquier otro de los estilos de comportamiento y con frecuencia desean que los demás también los tengan.
</td>
           </tr>
            <tr>
            <td></td>
            <td><strong>Si obtuviste una Baja C
</strong><br>
Tienden a operar con mayor independencia a las normas y procedimientos operativos establecidos. Con tendencia a la obtención de resultados. Si encuentran una forma más fácil
de hacer algo, lo harán mediante el desarrollo de una variedad de estrategias de acuerdo a
como la situación lo demande. Para quienes tienen un puntaje más bajo en C, las normas son sólo directrices y si es necesario pueden romperse o flexibilizarse para obtener resultados.
</td>
           </tr>
            </tbody>
            </table>


</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn_small" data-dismiss="modal">Cerrar</button>       
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>


</div>

<div class="container margin-tables">
        <div class="forma_genral_tit"><h2>Resultado evaluaciones</h2></div>
        <div class="row left" style="padding:15px;">
       <p> Esta evaluación presenta cuatro cuadrantes de conducta, que nos ayudan a comprender las preferencias de comportamiento de las personas y el estilo de comportamiento que son <strong>Natural</strong> y <strong>Adaptado</strong>.</p>
       
        <h4> <?=$candidato['Candidato']['nombre_']?>  </h4>
        <h5>Fecha: <?=date("d")?> de <?=Funciones::mes_numero_palabra(date("m"))?> de <?=date("Y")?> </h5>

      </div>
 <!-- datos natural-->
 <div class="row" style="margin-left:100px;">

 <div class="destacadas_candidato"><div class="span5">
           <div class="destacadas_candidato-title"><h3>Estilo Natural (N)</h3></div>
           <p class=" left">Este estilo se refiere a cómo te comportas cuando estás siendo completamente tú mismo; valga la redundancia: natural. 
<br><br>
Es tu estilo básico, auténtico y fiel a si mismo. También es el estilo al que vuelves cuando te encuentras en situaciones de estrés o bajo presión. 
<br><br>
Comportarse en este estilo, sin embargo, reduce el estrés, la tensión y es reconfortante. 
Cuando eres  auténtico a este estilo, maximizarás tu verdadero potencial con mayor eficacia.
</p></div>
</div>

<div class="destacadas_candidato"><div class="span5">
           <div class="destacadas_candidato-title"><h3>Estilo Adaptado (A)</h3></div>
           <p class=" left">El estilo adaptado es cómo te comportas cuando sientes que estás siendo observado o cuando eres consciente de tu comportamiento.
<br><br>
Este estilo es menos natural y auténtico que su tendencia y preferencias reales. 
<br><br>
Cuando te ves obligado a adoptar este estilo durante mucho tiempo puedes llegar a estresarte y a ser menos eficaz.<br><br><br>
</p></div>
</div>

         </div>
        <!-- datos adaptado-->
        <div class="row" style="margin-left:100px;">
<div class="span5">
 <div class="barras span2" style="padding-top:10px;">
<h5>Dominante</h5>
<div class="row">
<div class="progress vertical bottom progress-danger"><span class="title"><strong>N</strong></span><div class="bar" style="height: <?=$r[0]?>%;" data-percentage="<?=$r[0]?>"><?=$r[0]?>%</div></div> 
<div class="progress vertical bottom progress-danger"><span class="title"><strong>A</strong></span><div class="bar" style="height: <?=$r[4]?>%;" data-percentage="<?=$r[4]?>"><?=$r[4]?>%</div></div> </div>
<div class="row">
<div><div class="evaluaciones_rojo center">Preferencia por la solución de problemas y la obtención de resultados</div><br>
<a data-toggle="modal" href="#Modal" class="btn btn-danger btn-small">Ver resultados</a></div></div></div>
<div class="span2 barras" style="padding-top:10px;">
<h5>Influyente</h5>
<div class="row">
<div class="progress vertical bottom progress-warning"><span class="title"><strong>N</strong></span><div class="bar" style="height: <?=$r[1]?>%;" data-percentage="<?=$r[1]?>"><?=$r[1]?>%</div></div>
<div class="progress vertical bottom progress-warning"><span class="title"><strong>A</strong></span><div class="bar" style="height: <?=$r[5]?>%;" data-percentage="<?=$r[5]?>"><?=$r[5]?>%</div></div></div>
<div class="row">
<div><div class="evaluaciones_amarillo center">Preferencia por la interacción con los otros y mostrar emociones</div><br>
<a data-toggle="modal" href="#Modal2" class="btn btn-warning btn-small">Ver resultados</a></div></div></div>
</div>
<div class="span5">
<div class="span2 barras" style="padding-top:10px;">
<h5>Estable</h5>
<div class="row">
<div class="progress vertical bottom progress-success"><span class="title"><strong>N</strong></span><div class="bar" style="height: <?=$r[2]?>%;" data-percentage="<?=$r[2]?>"><?=$r[2]?>%</div></div>
<div class="progress vertical bottom progress-success"><span class="title"><strong>A</strong></span><div class="bar" style="height: <?=$r[6]?>%;" data-percentage="<?=$r[6]?>"><?=$r[6]?>%</div></div></div>
<div class="row">
<div><div class="evaluaciones_verde center">Preferencia por el ritmo constante, la persistencia y la estabilidad</div><br>
<a data-toggle="modal" href="#Modal3" class="btn btn-success btn-small">Ver resultados</a></div></div></div>
<div class="span2 barras" style="padding-top:10px;">
<h5>Cauteloso</h5>
<div class="row">
<div class="progress vertical bottom"><span class="title"><strong>N</strong></span><div class="bar" style="height: <?=$r[3]?>%;" data-percentage="<?=$r[3]?>"><?=$r[3]?>%</div></div>
<div class="progress vertical bottom"><span class="title"><strong>A</strong></span><div class="bar" style="height: <?=$r[7]?>%;" data-percentage="<?=$r[7]?>"><?=$r[7]?>%</div></div>
</div>
<div class="row">
<div><div class="evaluaciones_azul center">Preferencia por los procedimientos, estándares y protocolos
</div><br>
<a data-toggle="modal" href="#Modal4" class="btn btn-primary btn-small">Ver resultados</a></div></div></div>
 </div>
</div>
 
      
        
        
        
             
 </div>

<br>

  <div class="row-fluid">
          <?=$this->Html->link("Regresar",array('controller' => 'Evaluaciones',
                                  'action' => 'index',                                  
                                  'full_base' => true  ),array('data-component' =>"linkref", 
                                                               "class"=>"btn_color btn-large link-href" )  )  ?> 
    </div>
<br>



<?php 
  $this->AssetCompress->addCss(array(
            'app/inicio/bootstrap-progressbar.css',
            'vendor/progress-bar-vertical.css'
        ),"progressbar");

?>

