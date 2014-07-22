

<?php 

      $arr_tab_panel=array(
                              "mensaje" => array(
                                                  "id" => "mensajes",
                                                  "tipo"=>"mensaje",
                                                  "limit" => "10",
                                                  "href" => "/notificaciones/notificacion/mensaje"
                                ),
                              "evento" =>array(
                                                 "id" => "eventos",
                                                  "tipo"=>"evento",
                                                  "limit" => "10",
                                                  "href" => "/notificaciones/notificacion/evento"

                                ),
                              "notificacion" =>array(
                                                 "id" => "notificaciones",
                                                  "tipo"=>"notificacion",
                                                  "limit" => "10",
                                                  "href" => "/notificaciones/notificacion/notificacion"

                                )

        );
    $arr_=array();
    $arr_[]=$arr_tab_panel[$tipo];
    unset($arr_tab_panel[$tipo]);
    foreach ($arr_tab_panel as  $value) {
        $arr_[]=$value;
    }

    $arr_[0]['active']=true;

?>



<?php foreach ($arr_ as $key => $v)  :?>

  <div class="tab-pane panel <?=isset($v['active']) && $v['active'] ===true ? 'active' :''  ?>" id="<?=$v['id']?>">
      <div class="row-fluid "  >
        <div class="span1"></div>
        <div class="span11 content" data-type="<?=$v['tipo']?>" data-limit="<?=$v['limit']?>">            
        </div>
      </div>
      <a href="<?=$v['href']?>" data-target="" class="more-ntfy hide"> Ver más</a>   
  </div>


<?endforeach;?>



