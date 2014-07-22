<?php
  echo $this->element('empresas/title');
?>

<div class="alert alert-info">
  En esta secci&oacute;n usted podr&aacute; ver un resumen r&aacute;pido de sus candidatos.
</div>

<?php echo $this->element('empresas/candidatos/stats'); ?>
<?php echo $this->element('empresas/candidatos/last_updates'); ?>