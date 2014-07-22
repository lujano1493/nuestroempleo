<?php
if (Configure::read('debug') > 0):
?>
  <h2><?php echo $name; ?></h2>
  <p class="error">
    <strong><?php echo __d('cake', 'Error'); ?>: </strong>
    <?php printf(
      __d('cake', 'The requested address %s was not found on this server.'),
      "<strong>'{$url}'</strong>"
    ); ?>
  </p>
<?php
  echo $this->element('exception_stack_trace');
endif;
?>
<?php
  if ($this->Acceso->is('empresa')) {
    echo $this->element('empresas/error');
  } else {
    echo $this->element('candidatos/error');
  }
?>
