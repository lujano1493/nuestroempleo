<?php
  echo $this->element('empresas/title');
?>
<div class="alert alert-info">
  En esta secci&oacute;n usted podr&aacute; crear, administrar, compartir o eliminar ofertas de empleo de manera eficaz.
</div>
<?php echo $this->element('empresas/ofertas/stats'); ?>
<?php echo $this->element('empresas/ofertas/last_updates'); ?>
<?php echo $this->element('empresas/ofertas/to_expire'); ?>