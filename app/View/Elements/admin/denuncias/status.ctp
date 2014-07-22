  <?php

  /*
    valores

      $it=array( "status" =>array("val" =>""), "id"=>1,"slug"=>"s",  )

   */

  $buttons = array(
      'cv'=> array(
        'icon'=> 'user', 'text'=>'Ver CV',  'link'=> "/admin/denuncias/ $it[id] /candidato/ $it[slug]/"
      ),
      'oferta'=> array(
        'icon'=>'book', 'text'=>'Ver Oferta', 'link'=> "/admin/denuncias/$it[id]/oferta/$it[slug]/"
      )
    );
    $btn = $buttons[$it['tipo']];
    $actions = array(
      array('text'=> 'Reportado',   'icon'=> 'ban-circle',       'value'=> 'reportado'),
      array('text'=> 'En Revisión', 'icon'=> 'question',         'value'=> 'revision'),
      array('text'=> 'Aceptado',    'icon'=> 'thumbs-up-alt',    'value'=> 'aceptado'),
      array('text'=> 'Declinado',   'icon'=> 'thumbs-down-alt',  'value'=> 'declinado')
    );
    $status = $it['status'];
    $disabled = $status >= 2;
    $btnAction = $disabled ? $actions[$status] : $actions[$status + 1];
?>


  <div class="btn-group btn-block">
    <a class="btn btn-primary <?=$disabled ? 'disabled' : '' ?>" 
      href="/admin/denuncias/<?= $it['tipo'] . '-' .$it['id'] ?>/status/<?= $btnAction['value'] ?>" data-component='ajaxlink'  data-after="reloadContent">
      <i class="icon-<?= $btnAction['icon'] ?>">
      </i>
      <?= $btnAction['text'] ?>
    </a>
    <button class="btn btn-primary dropdown-toggle <?= $disabled ? 'disabled' : '' ?>" data-toggle="dropdown">
      <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
      <?php  for($i=1, $_len=count($actions) ;$i<$_len;$i++ )  {
            $btnAction=$actions[$i];
            if( $status < $i){
      ?>
          <li>
            <a href="/admin/denuncias/<?= $it['tipo'] .'-'. $it['id'] ?>/status/<?= $btnAction['value'] ?>" 
              data-component='ajaxlink' data-after="reloadContent">
              <i class="icon-<?= $btnAction['icon'] ?>"></i><?= $btnAction['text'] ?>
            </a>
          </li>
     <?php  }
        }
     ?>
    </ul>
  </div>