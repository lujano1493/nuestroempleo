<?php  
  $status=ClassRegistry::init("Mensaje")->getStats($authUser['candidato_cve'],$role);

  $action=$this->action;

?>
            <!-- menu izq -->
<ul class="nav nav-list msg-menu">
   <li class="nav-header">Mensajes</li>
   <li class="<?=$action=='index'?'active':'';?>">
      <a href="<?=$this->Html->url(array("controller" =>"mensajeCan", "action" => "index" ))?>">
        <span class="pull-left"><i class="icon-envelope"></i></span>&nbsp;&nbsp;Entrada
        <span class="strong pull-right msg-total"><?=$status['recibidos']?></span>
      </a>
    </li>   
   <li class="<?=$action=='importates'?'active':'';?>">
      <a href="<?=$this->Html->url(array("controller" =>"mensajeCan", "action" => "importates" ))?>">
        <span class="pull-left">&nbsp;<i class="icon-exclamation"></i></span>&nbsp;&nbsp;&nbsp;&nbsp;Importantes
        <span class="strong pull-right msg-importantes"><?=$status['importantes']?>
        </span>
      </a>
    </li>
   <li class="<?=$action=='enviados'?'active':'';?>">
      <a href="<?=$this->Html->url(array("controller" =>"mensajeCan", "action" => "enviados" ))?>">
        <span class="pull-left"><i class="icon-share-sign"></i></span>
        &nbsp;&nbsp;&nbsp;Enviados
        <span class="strong pull-right msg-enviados"> <?=$status['enviados']?> 
        </span>
      </a>
    </li>

   <li class="<?=$action=='eliminados'?'active':'';?>">
      <a href="<?=$this->Html->url(array("controller" =>"mensajeCan", "action" => "eliminados" ))?>">
        <span class="pull-left">
          <i class="icon-remove"></i>
        </span>&nbsp;&nbsp;&nbsp;Eliminados
        <span class="strong pull-right msg-eliminados"> <?=$status['eliminados']?> </span>
      </a>
    </li>
   <!--<li class="<?=$action=='carpeta'?'active':'';?>"><a href="/MensajeCan/carpeta"><i class="icon-folder-close-alt"></i>&nbsp;Mensajes archivados&nbsp;<span class="strong pull-right">3</span></a></li> 
   <li class="<?=$action=='nuevo'?'active':'';?>"><a href="/MensajeCan/nuevo"><i class="icon-font"></i>&nbsp;Redactar</a></li> -->
   <!--<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-folder-open-alt"></i>&nbsp; Carpetas<b class="caret"></b></a>
         <ul class="dropdown-menu">
            <li><a href="#">...</a></li>
        </ul>
    </li> -->
    <br>
</ul>

<br/>
<!-- menu inf 
<div class="pull-left left tabular span3">
    <div class="tabular"><h5>M&aacute;s opciones</h5></div>
    <div class="tabular"><a href="#"><i class="icon-group"></i>&nbsp;Buscar contactos</a></div><br>
    <div class="tabular"><a href="#"><i class="icon-download-alt"></i>&nbsp;Guardar mensajes</a></div><br>
    <div class="tabular"><a href="#"><i class="icon-cogs"></i>&nbsp;Soporte t&eacute;cnico</a></div><br>
    <div class="tabular"><a href="#"><i class="icon-exclamation"></i>&nbsp;Mensajes de ayuda</a></div><br>
</div> -->