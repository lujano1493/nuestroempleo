<div class="container without-space">
  <div class="forma_genral_tit"><h2>Notificaciones</h2></div>


  <div class="tabbable historial-notificaciones" data-component="historialntfy" data-role="<?=$role?>"> <!-- Only required for left/right tabs -->
    <ul class="nav nav-tabs nav-tabs_notificaciones" >
      <li class="active">
          <a href="#mensajes" data-toggle="tab">
            <i class="icon-envelope"></i> Mensajes
          </a>
      </li>
      <li class="">
        <a href="#eventos" data-toggle="tab"><i class="icon-calendar"></i> Eventos</a>
      </li>
      <li class="">
        <a href="#notificaciones" data-toggle="tab"><i class="icon-bell"></i> Notificaciones</a>
      </li>
    </ul>
  <div class="tab-content">



    <!--Mensajes -->
    <div class="tab-pane panel  active" id="mensajes">         
      <div class="row-fluid "  >
          <div class="span1"></div>
          <div class="span11 content" data-type="mensaje" data-limit="10">
            
          </div> 

      </div>
      <a href="/notificaciones/notificacion/mensaje" class="more-ntfy hide" > Ver más</a>   
    </div>

      <!--Eventos-->
    <div class="tab-pane panel" id="eventos">
        <div class="row-fluid ">
          <div class="span1"></div>
          <div class="span11 content"  data-type="evento" data-limit="20" >            
          </div>
        </div>
       <a href="/notificaciones/notificacion/evento"  class="more-ntfy hide"> Ver más</a>   
    </div>
    <!-- notificaciones -->
    <div class="tab-pane panel" id="notificaciones">
        <div class="row-fluid "  >
          <div class="span1"></div>
          <div class="span11 content" data-type="notificacion" data-limit="20">            
          </div>
        </div>
        <a href="/notificaciones/notificacion/notificacion" data-target="" class="more-ntfy hide"> Ver más</a>   
    </div>

  
    </div>
  </div>




</div>



<?php
  echo( $this->Template->insert(array(
    'can-notificacion-historial'
  )));
?>