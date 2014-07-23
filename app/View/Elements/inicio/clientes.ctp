<?php
  $clientes = ClassRegistry::init("MicroSitio")->find("clientes");
?>
<?php
      $ln=count($clientes);
      for($i=0;$i<$ln;) : ?>
  <li>
    <?php for( $j=0;$j<6;$j++ )  :?>
        <?php   if( $i+$j >= $ln ) break;
          $value=$clientes[$i+$j]['MicroSitio'];
        ?>
        <div class="work span2">
            <a  href="<?=$this->Html->url(array( "compania" => $value['name'],"controller" => "informacion" , "action" => "index" )) ?> " target="_blank" > 
              <img id="img" src="<?=$value['src_img'] ?>" alt=" "  style="width:170px;height:100px;margin:auto" > 
            </a>
        </div>
    <?php  endfor; ?>
    <?php $i=$i+$j ?>
  </li>
<?php  endfor; ?>
