<?php
  $this->set('noValidationErrors', true);

  $this->_results = array(
    'empresa_id' => $empresaId,
    'folio' => $folio,
    'file' => array(
      'filename' => $fileName,
      'url' => $this->Html->url(array(
        'admin' => $isAdmin,
        'controller' => 'facturas',
        'action' => 'descargar_comprobante',
        'id' => $folio,
        $fileName
      )),
      'deleteUrl' => $this->Html->url(array(
        'admin' => $isAdmin,
        'controller' => 'facturas',
        'action' => 'comprobante',
        'id' => $folio,
        $fileName
      ))
    )
  );
?>