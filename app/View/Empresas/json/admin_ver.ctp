<?php
  echo json_encode(
    array(
      'empresa' => $empresa['Empresa'],
      'direccion' => $empresa['DirCompania'],
      'codigo_postal' => $cp,
      'facturas' => Hash::extract($facturas, '{n}.Factura'),
    )
  );
?>