<?php

App::uses('BaseEmpresasController', 'Controller');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');
App::uses('Xml', 'Utility');

/**
 * Controlador general de la aplicación.
 */
class FacturasController extends BaseEmpresasController {

  public $name = 'Facturas';

  /**
    * Componentes necesarios que utiliza el Controlador.
    * @var Array
    */
  public $components = array('Session', 'Upload', 'Timbrado');

  /**
    * Método que se ejecuta antes de cualquier acción.
    */
  public function beforeFilter() {
    parent::beforeFilter();

    /**
      * Acciones que no necesitan autenticación.
      */
    $allowActions = array();

    $this->Auth->allow($allowActions);
  }

  public function admin_index() {
    // $this->paginate = array(
    //   'findType' => 'all_facturas'
    // );

    // $facturas = $this->paginate();
    $facturas = $this->Factura->find('all_facturas', array(
      'conditions' => array(
        'Factura.factura_folio NOT LIKE' => '%PROMO%',
      ),
      'order' => array(
        'Factura.created' => 'DESC NULLS LAST'
      )
    ));

    $this->set(compact('facturas'));
  }

  public function admin_ver($folio) {
    $factura = $this->Factura->find('first', array(
      'conditions' => array(
        'factura_folio' => $folio
      ),
      'contain' => array(
        'Timbrado' => array(
          'fields' => array('xml', 'uuid', 'created', 'cadorig_sat')
        )
      ),
      'recursive' => -1
    ));

    $xml = trim($factura['Timbrado']['xml']);

    if ($this->request->params['ext'] === 'pdf') {
      $cadenaOriginal = $factura['Timbrado']['cadorig_sat'];

      $this->set('factura', Xml::toArray(Xml::build($xml)));
      $this->set('cadenaOriginal', $cadenaOriginal);
      $this->render('factura');
    } elseif($this->request->params['ext'] === 'xml') {
      $this->autoRender = false;
      echo $xml;
    }

    $this->response->download(__('Factura_%s.%s', $folio, $this->request->params['ext']));
  }

  public function admin_empresas() {
    $this->paginate = array('Empresa' => array(
      'findType' => 'data'
    ));

    $empresas = $this->paginate('Empresa');
    $this->set(compact('empresas'));
  }

  public function admin_nuevo($empresaId = null) {
    $empresa = array();
    if (isset($empresaId) && is_numeric($empresaId)) {
      $data = $this->Factura->Empresa->get($empresaId);
    }

    $this->set(compact('data'));
  }

  public function admin_recientes() {
    $facturas = $this->Factura->getLast();

    $this->set(compact('facturas'));

    $this->render('admin_index');
  }

  public function admin_timbrar($folio) {
    if (/*!isset($this->request->query['test'])*/ false) {
      $this
        ->warning(__('El servicio de timbrado aún no está disponible o está deshabilitado.'));
      return ;
    } elseif (!$this->Factura->is('activado', $folio)) {
      $this
        ->error(__('No puedes timbrar una factura que no está activada.'));
      return ;
    }

    if ($this->Timbrado->timbrar($folio, 'test')) {
      $factura = $this->Factura->find('all_facturas', array(
        'conditions' => array(
          'Factura.factura_folio' => $folio
        )
      ));

      $this
        ->callback('reloadData')
        ->success(__('El timbrado de la factura con folio %s fue exitoso.', $folio))
        ->set(compact('factura'));
    } else {
      $this
        ->modal('modals/admin/timbrado', array(
          'folio' => $folio,
          'errors' => $this->Timbrado->errors()
        ));
    }
  }

  public function admin_cancelar($folio) {
    if (true) {
      $this
        ->warning(__('El servicio de cancelado aún no está disponible o está deshabilitado.'));
      return ;
    } elseif (!$this->Factura->is('timbrado', $folio)) {
      $this
        ->error(__('No puedes cancelar una factura que no está timbrada.'));
      return ;
    }

    if ((bool)($factura = $this->Timbrado->cancelar($folio, 'igenter'))) {
      $facturaId = $factura['Factura']['factura_cve'];

      $this->Factura->begin();
      $this->Factura->Timbrado->begin();
      if ($this->Factura->Timbrado->delete($facturaId) && $this->Factura->changeStatus($facturaId, 2)) {
        $this->Factura->commit();
        $this->Factura->Timbrado->commit();

        $factura = $this->Factura->find('all_facturas', array(
          'conditions' => array(
            'Factura.factura_folio' => $folio
          )
        ));

        $this
          ->callback('reloadData')
          ->success(__('La factura se canceló correctamente.', $folio))
          ->set(compact('factura'));
      } else {
        $this->Factura->rollback();
        $this->error(__('Ocurrió un error al intentar cancelar la factura.'));
      }
    } else {
      $this->error($this->Timbrado->errors()[0]);
    }
  }

  public function admin_devolucion($folio) {
    if (true) {
      $this
        ->warning(__('El servicio de cancelado aún no está disponible o está deshabilitado.'));
      return ;
    } elseif (!$this->Factura->is('timbrado', $folio)) {
      $this
        ->error(__('No puedes cancelar una factura que no está timbrada.'));
      return ;
    }

    if ((bool)($factura = $this->Timbrado->cancelar($folio, 'igenter'))) {
      $facturaId = $factura['Factura']['factura_cve'];

      $this->Factura->begin();
      $this->Factura->Timbrado->begin();
      if ($this->Factura->Timbrado->delete($facturaId) && $this->Factura->cancelar($facturaId)) {
        $this->Factura->commit();
        $this->Factura->Timbrado->commit();

        $factura = $this->Factura->find('all_facturas', array(
          'conditions' => array(
            'Factura.factura_folio' => $folio
          )
        ));

        $this
          ->callback('reloadData')
          ->success(__('El proceso de devolución se realizó correctamente.', $folio))
          ->set(compact('factura'));
      } else {
        $this->Factura->rollback();
        $this->error(__('Ocurrió un error al intentar cancelar la factura.'));
      }
    } else {
      $this->error($this->Timbrado->errors()[0]);
    }
  }

  public function admin_comprobante($folio = null, $name = null) {
    $empresaId = $this->request->data('Empresa.cia_cve') ?: $this->request->data('empresa_id');
    $filePath = ROOT . DS . 'documentos' . DS . 'empresas' . DS . $empresaId . DS . 'facturas' . DS . $folio;

    /**
     * Borramos el archivo.
     */
    if ($this->request->is('DELETE')) {
      if (!$name) {
        $this->error(__('Nombre de archivo no proporcionado'));
      } else {
        $ext = $this->request->param('ext');
        $name .= ($ext ? '.' . $ext: '');

        $file = new File($filePath . DS . $name);

        if ($file->exists() && $file->delete()) {
          $this
            ->success(__('Se borró %s correctamente.', $name));
        } else {
          $this->error(__('El archivo %s no existe o no se ha podido borrar.', $name));
        }
      }

      $this->RequestHandler->renderAs($this, 'json');
      // $this->RequestHandler->respondAs($this, 'json');

      $this->render('admin_comprobante_borrado');
      return;
    }

    $result = $this->Upload->post(false);
    $name = $result['files'][0]->name;

    $folder = new Folder();
    if (!$folder->create($filePath, 0775)) {
      $this->error(__('Ocurrió un error al subir el archivo.'));
    }

    $currentFile = WWW_ROOT . str_replace('/', DS, 'temporales/' . $name);
    $file = new File($currentFile);
    $fileName = Inflector::slug($file->name(), '-') . '.' . $file->ext();
    $newFile = $filePath . DS . $fileName;

    if (rename($currentFile, $newFile)) {
      $this
        ->success(__('Se guardo correctamente el archivo.'))
        ->set(compact('folio', 'fileName', 'empresaId'));
    } else {
      $this->error(__('Ocurrió un error al mover el archivo.'));
    }
  }

  public function admin_descargar_comprobante($folio = null, $name = null) {
    $match = preg_match("/^(\d{5})(\d{3})$/", $folio, $output_array);
    $empresaId = !empty($output_array) && isset($output_array[1]) ? (int)$output_array[1] : false;

    if (!(bool)$match || !(bool)$empresaId) {
      $this
        ->error(__('Ocurrió un error al buscar el folio.'))
        ->redirect('referer');
    }

    $filePath = ROOT . DS . 'documentos' . DS . 'empresas' . DS . $empresaId . DS . 'facturas' . DS . $folio;
    $ext = $this->request->param('ext');
    $name .= ($ext ? '.' . $ext: '');
    $file = new File($filePath . DS . $name);

    if (!$file->exists()) {
      $this
        ->error(__('El archivo %s no existe.', $name))
        ->redirect('referer');
    }

    $this->response->file($file->pwd(), array(
      'download' => true,
      'name' => $file->name
    ));
    return $this->response;
  }
}
