
<?php
  echo $this->element('admin/title');
?>

<ul class="nav nav-pills tasks">
  <li>
    <?php
      echo $this->Html->link('Todas las Empresas', array(
        'admin' => $isAdmin,
        'controller' => 'empresas',
        'action' => 'index'
      ));
    ?>
  </li>
</ul>

<?php echo $this->element('empresas/registrar'); ?>