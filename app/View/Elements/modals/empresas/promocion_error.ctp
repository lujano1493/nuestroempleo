<div class="">
  <div class="">
    <p>
      Usted adquirió una membresía promocional el día <strong><?php echo $this->Time->d($created); ?></strong>.
    </p>
    <div class="lead text-center">
      Folio: <strong><?php echo $factura; ?></strong>
    </div>
    <div class="alert alert-warning">
      <small>
        Estas promociones no son acumulables, sólo puede adquirir un producto de esta gama.
      </small>
    </div>
  </div>
  <div class="text-center">
    <small>
      Si el asesor no lo ha contactado en un lapso de 48 hrs, por favor reporte su folio a <?php echo $this->Html->link(
        'contacto.ne@nuestroempleo.com.mx', 'mailto:contacto.ne@nuestroempleo.com.mx', array(
          'target' => '_blank'
        )
      ); ?>
    </small>
  </div>
</div>