<h5>
  <i class="icon-building"></i><?php echo __('Datos de Facturación'); ?>
</h5>
<ul class="list-unstyled span-right">
  <li>
    <?php echo __('Empresa'); ?>
    <span><?php echo $datos[0]['FacturacionEmpresa']['cia_razonsoc']; ?></span>
  </li>
  <li>
    <?php echo __('RFC'); ?>
    <span><?php echo $datos[0]['FacturacionEmpresa']['cia_rfc']; ?></span>
  </li>
  <li>
    <?php echo __('Giro'); ?>
    <span><?php echo $datos[0]['FacturacionEmpresa']['giro']; ?></span>
  </li>
  <li>
    <?php
      echo __('Domicilio');
      $dom = $datos[0]['Direccion'];
    ?>
    <span><?php echo $dom['calle']; ?></span>
  </li>
  <li>
    <?php
      echo __('Ubicación');
      $domicilio = implode(', ', array(
        $dom['colonia'],
        $dom['ciudad'],
        $dom['estado'],
        $dom['pais'],
      ));
    ?>
    <span><?php echo $domicilio; ?></span>
  </li>
  <li>
    <?php echo __('Teléfono'); ?>
    <span><?php echo $dom['tel']; ?></span>
  </li>
</ul>