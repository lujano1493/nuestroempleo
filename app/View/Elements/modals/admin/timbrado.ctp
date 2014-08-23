<div class="">
  <h4 class="modal-header text-center">
    Ocurrió un error al timbrar factura.
  </h4>
  <div class="lead text-center">
    Folio: <strong><?php echo $folio; ?></strong>
  </div>
  <?php foreach ($errors as $error): ?>
    <div class="alert alert-danger">
      <p><?php echo $error; ?></p>
    </div>
  <?php endforeach ?>
</div>