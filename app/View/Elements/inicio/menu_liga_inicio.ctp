<?php 

	  $activite="current-page";
	  $name="/".strtolower($this->name);
	  $curren_page=strtolower( $name."/".$this->action);


    $m= ( !empty($micrositio)? "$micrositio[name]" :''  ) ;   

	  $activite=  "/{$m}{$curren_page}"=== strtolower($liga) ?  $activite:"" ;


?>
        <li class="dropdown menu_li <?=$activite?>">
          <a href="<?=$liga?>" <?=$extra?> >
            <i class="icon-<?=$icono?>"></i>
          </a>
          <br><?=$titulo ?>        
        </li>