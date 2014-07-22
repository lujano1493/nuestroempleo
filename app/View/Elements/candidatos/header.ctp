<div class="header row">
  <div class="row">
    <!--logo-->
    <h1>
        <?=$this->Html->link("Nuestro Empleo - Tu espacio laboral en internet",
            array( 
                  "controller" =>"informacion" ,
                  "action" =>"index"),
            array("class"=> "brand"))?>
    
    </h1>
    <!--header candidatos-->
    <div class="pull-right">
      <div class="" style="display:inline-block;">
        <?= $this->element("candidatos/notificaciones"); ?>
      </div>
      <div class="btn-toolbar" style="display:inline-block;">
        <div class="btn-group">
          <a href="/documentos/candidatos/GUIA_DE_USUARIO_CANDIDATO.pdf" target="_blank" class="btn btn-small strong" title="Ayuda"  data-component="tooltip" data-placement="bottom"><i class="icon-question-sign"></i></a>
        </div>
        <div class="btn-group">

            <?=$this->Html->link (" <i class='icon-off'></i> Salir",array(
                "controller" => "candidato",
                "action" => "logout"
            ),array(
                "title" => "Salir",
                "data-component" => "tooltip",
                "data-placement" => "bottom",
                "class" => "btn btn-small strong exit",
                "escape" => false
            ))?>          
        </div>
      </div>
    </div>
  </div>
        <!--termina header candidatos-->
  <div class="span12_2">


          <?php

              $this->url_m= !empty($micrositio) ?  "{$this->webroot}$micrositio[name]/"  :$this->webroot;            

          $arr_menu_bar=array (
            array ("active"=>"","href"=>$this->url_m."Candidato/index","icon"=>"icon-home","text"=>"Inicio" ,"title" => "Inicio" ),
            array ("active"=>"","href"=>$this->url_m."ConfigCan/index","icon"=>"icon-user","text"=>"Mi Cuenta","title" => "Mi Cuenta"),
            array ("active"=>"","href"=>$this->url_m."Candidato/actualizar","icon"=>"icon-edit","text"=>"Mi Currículum" ,"title" => "Mi Currículum"),
            array ("active"=>"","href"=>$this->url_m."PostulacionesCan/index","icon"=>"icon-th","text"=>"Postulaciones", "title" => "Postulaciones" ),
            array ("active"=>"","href"=>$this->url_m."MensajeCan/index","icon"=>"icon-envelope","text"=>"Mensajes","title"=>"Mensajes" ),
            array ("active"=>"","href"=>$this->url_m."Evaluaciones/index","icon"=>"icon-pencil","text"=>"Evaluaciones","title" =>"Evaluaciones"),
            array ("active"=>"","href"=>$this->url_m."Portafolio/index","icon"=>"icon-book","text"=>"Portafolio","title" =>"Portafolio" ),
            array ("active"=>"","href"=>$this->url_m."EventosCan/index","icon"=>"icon-calendar","text"=>"Eventos","title" => "Eventos"),
            );
$url=$this->url_m.$this->name."/".$this->action;
$page_corrent=array();

if($this->name."/".$this->action !== "Candidato/view_header" ){
  foreach ($arr_menu_bar as $key=> $opc){

    if(strpos($url,$opc['href']) !== false  ){
      $page_corrent[]=$key;
    }
  }
}

// verificamos que exista una pagina que coencida
//  debug($this->is("ajax"));
if(!empty($page_corrent)){
  $keyisita=$page_corrent[0];
  if(count($page_corrent)>1 ){
    foreach ($page_corrent as $value) {
      $com_url=$arr_menu_bar[$value]['href'];
      if( $com_url==$url   ){
        $keyisita=$value;
        break  ;
      }
    }
  }
  $arr_menu_bar[$keyisita]['active']='current-page';

}



?>

<!--menu-->
<div class="navbar">
  <div class="navbar-inner_2">
    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </a>
    <div class="nav-collapse collapse">


      <? foreach ($arr_menu_bar as  $value)  :?>

      <div class="span_header_2">
        <ul class="nav margen_menu">
          <li class="<?=$value['active']?> dropdown">
            <a class="dropdown-toggle"  href="<?=$value['href'] ?>">
              <i class="<?=$value['icon']?>">
              </i>
            </a>
          </li>

        </ul>
        <div class="tabular menu_letra center">  <?=$value['text'] ?>   </div>
      </div>
    <? endforeach; ?>


  </div>
</div>
</div>
</div>
</div>

