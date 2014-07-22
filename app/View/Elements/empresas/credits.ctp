<ul class="nav navbar-nav credits" id='credits-bar'>
  <?php
    $credits = !empty($credits) ? $credits : $this->Session->read('Auth.User.Creditos');
    foreach ($credits as $key => $value):
      $total = $value['creditos_infinitos'] ? '&infin;' : $value['disponibles'];
      if ((int)$value['visible'] === 0) {
        continue;
      }
    ?>
    <li>
      <span title="<?php echo $value['nombre']; ?>" class="link-icon bg-credit" data-component="tooltip" data-placement="bottom">
        <i class="icon-credit <?php echo $value['identificador']; ?>"></i>
        <span data-credit="<?php echo $value['identificador']; ?>"><?php echo (string)$total; ?></span>
      </span>
      <?php
        // echo $this->Html->spanLink(, '#', array(
        //   'title' => ,
        //   'class' => 'link-icon bg-credit',
        //   'icon' => 'credit ' . ,
        //   'data' => array(
        //     'component' => 'tooltip',
        //     'placement' => 'bottom',
        //   ),
        //   'spanOptions' => array(
        //     'data' => array(
        //       'credit' =>
        //     )
        //   ),
        //   'escape' => false,
        // ));
      ?>
    </li>
  <?php endforeach ?>
</ul>