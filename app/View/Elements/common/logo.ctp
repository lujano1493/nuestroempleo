<?php
  $class = isset($class) ? $class : '';
  $url = isset($url) ? $url : '/';
  $section = isset($section) ? $section : '';

  switch ($section) {
    case 'admin':
      $url = array('admin' => $isAdmin, 'controller' => 'mi_espacio', 'action' => 'index');
      break;
    case 'empresas':
      $url = $isAuthUser
        ? array('admin' => 0, 'controller' => 'mi_espacio', 'action' => 'index')
        : array('admin' => 0, 'controller' => 'empresas', 'action' => 'index');
      break;
    case 'candidatos':
      $url = '/';
      break;
  }
?>

<a class="logo <?= $class ?>" href="<?php echo $this->Html->url($url); ?>">
  <span class="nuestro">nuestro</span>
  <span class="empleo">empleo</span>
  <?php if (isset($section)) { ?>
    <span class="<?= $section; ?>"><?= $section; ?></span>
  <?php } ?>
</a>