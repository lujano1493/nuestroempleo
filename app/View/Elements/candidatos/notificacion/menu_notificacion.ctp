

<?php 

      $arr_tab_menu=array(
                              "mensaje" => array(
                                                  "title" => "Mensajes",
                                                  "href" => "#mensajes",
                                                  "icon"=>"envelope"
                                ),
                              "evento"=> array(
                                                "title"=> "Eventos",
                                                "href" => "#eventos",
                                                "icon" => "calendar",                                              
                                ),
                              "notificacion" => array(
                                                "title" => "Notificaciones",
                                                "href" => "#notificaciones",
                                                "icon" => "bell"
                                )

        );
    $arr_=array();
    $arr_[]=$arr_tab_menu[$tipo];
    unset($arr_tab_menu[$tipo]);
    foreach ($arr_tab_menu as  $value) {
        $arr_[]=$value;
    }

    $arr_[0]['active']=true;

?>



<ul class="nav nav-tabs nav-tabs_notificaciones" >

  <?php foreach ($arr_ as $key => $v)        
  : 
 $active= isset($v['active'] ) && $v['active'] ===true ? 'active':'' ;
  ?>  
   <li class="<?=$active?>">
          <a href="<?=$v['href']?>" data-toggle="tab">
            <i class="icon-<?=$v['icon']?>"></i> <?=$v['title']?>
          </a>
      </li>


  <?php endforeach;?>


</ul>