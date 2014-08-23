<table cellspacing="0" style="width:759px; background-color:#fff;" >
  <tr>
    <td style="width:50%; text-align:left;">
      <?php
        echo $this->Html->image('assets/logo.jpg', array(
          'fullBase' => true,
          'width' => 210,
          'height' => 81
        ));
      ?>
    </td>
    <td style="width:50%;">
      <p style="background-color:#49317b; padding:3px; color:#FFF; font-weight:bold; font-size:16px;">Error al timbrar</p>
    </td>
  </tr>
  <tr>
    <td colspan="2" style=" background-color:#49317b; height:3px;"></td>
  </tr>
  <tr>
    <td colspan="2" style="background-color:#49317b; height:3px;"></td>
  </tr>
  <tr>
    <td colspan="2">
      <div>
        <p>
          Ha ocurrido un error al intentar timbrar la factura con el siguiente folio.
        </p>
      </div>
      <div style="text-align:center; font-size:1.1em;">
        Folio: <strong style="font-size:2em;">
          <?php echo $folio; ?>
        </strong>
      </div>
      <div class="" style="text-align:left;">
        <p>
          A continuación se listan los errores encontrados.
        </p>
        <?php foreach ($errors as $error): ?>
          <div class="">
            <p style="border: 1px #ff4747 solid;background: #fdecec;padding: 5px 20px;color: #ff4747;font-weight: bold;">
              <?php echo $error; ?>
            </p>
          </div>
        <?php endforeach; ?>
      </div>
    </td>
  </tr>
</table>