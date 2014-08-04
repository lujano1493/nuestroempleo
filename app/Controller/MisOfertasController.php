<?php

App::uses('CakeTime', 'Utility');
App::uses('Utils', 'Utility');
App::uses('BaseEmpresasController', 'Controller');
/**
 * Controlador Oferta
 */
class MisOfertasController extends BaseEmpresasController {
  /**
    * Nombre del controlador.
    */
  public $name = 'MisOfertas';

  public $uses = array('Oferta');
  /**
   * Componentes necesarios que utiliza el Controlador.
   * @var array
   */
  public $components = array(
    'Shortener' => array(
      'base' => 'http://www.nuestroempleo.com.mx'
    ),
    'Session',
    'Creditos',
  );

  /**
   * [$helpers description]
   * @var array
   */
  public $helpers = array('Menu');

  private function catalogos() {
    $this->loadModel('Catalogo');

    $listas = array(
      'disponibilidad' => $this->Catalogo->lista('disponibilidad'),
      'generos' => $this->Catalogo->lista('genero'),
      'edo_civil' =>  $this->Catalogo->lista('estado_civil'),
      'escolaridad' => $this->Catalogo->lista('nivel_escolar'),
      'experiencia' => $this->Catalogo->lista('experiencia'),
      'tipo_empleo' => $this->Catalogo->lista('disponibilidad_empleo'),
      'prestaciones' => $this->Catalogo->lista('prestaciones'),
      'sueldos' => $this->Catalogo->lista('sueldos'),
      'estados' => ClassRegistry::init('Estado')->getEstadosList(1),
      'users' => ClassRegistry::init('UsuarioEmpresa')->dependents($this->Auth->user('cu_cve'), 'contact'),
      'carpetas' => ClassRegistry::init('Carpeta')->getByUser($this->Auth->user('cu_cve'), 'ofertas'),
    );

    return $listas;
  }

  protected function updateSession() {
    $userId = $this->Auth->user('cu_cve');
    $ciaId = $this->Auth->user('Empresa.cia_cve');

    $stats = $this->Oferta->UsuarioEmpresa->getStats($userId, $ciaId, 'ofertas');
    $this->Session->write('Auth.User.Stats.ofertas', $stats);
  }

  protected function generateShortenURL($id) {
    $success = false;
    $oferta = $this->Oferta->get($id, array('fields' => array(
      'oferta_cve', 'puesto_nom', 'oferta_link'
    )));

    $shortenUrl = $oferta['oferta_link'];

    if (empty($shortenUrl)) {
      $shortenUrl = $this->Shortener->shorten(array(
        'controller' => 'ofertas',
        'id' => $id,
        'slug' => Inflector::slug($oferta['puesto_nom'], '-'),
        'action' => 'ver'
      ));

      $this->Oferta->id = $id;
      $success = $this->Oferta->saveField('oferta_link', $shortenUrl);
    } else {
      $success = true;
    }

    return $success ? $shortenUrl : false;
  }

  /**
    * Método que se ejecuta antes de cualquier acción.
    */
  public function beforeFilter() {
    parent::beforeFilter();
    $this->updateSession();

    /**
      * Acciones que no necesitan autenticación.
      */
    $allowActions = array();

    $this->Auth->allow($allowActions);
  }

  public function index() {
    $title_for_layout = __('Mis Ofertas');

    $stats = array(
      'ofertas' => $this->Oferta->getStatusStats($this->Auth->user('cu_cve'), $this->Auth->user('Empresa.cia_cve'), 'bprd'),
      'creditos' => $this->Creditos->get(array(
        'oferta_publicada',
        'oferta_recomendada',
        'oferta_distinguida'
      ))
    );

    $ofertas_recientes = $this->Oferta->get('recientes', array(
      'fromUser' => $this->Auth->user('cu_cve')
    ));

    $ofertas_a_vencer = $this->Oferta->get('a_vencer', array(
      'fromUser' => $this->Auth->user('cu_cve'),
      'limit' => 4
    ));

    $this->set(compact('title_for_layout', 'stats', 'ofertas_recientes', 'ofertas_a_vencer'));
  }

  public function a_vencer() {
    $title_for_layout = __('Ofertas Próximas a Vencer');

    $stats = array(
      'ofertas' => $this->Oferta->getStatusStats($this->Auth->user('cu_cve'), $this->Auth->user('Empresa.cia_cve'), 'bprd'),
      'creditos' => $this->Creditos->get(array(
        'oferta_publicada',
        'oferta_recomendada',
        'oferta_distinguida'
      ))
    );

    if ($this->isAjax) {
      $ofertas = $this->Oferta->get('a_vencer', array(
        'fromUser' => $this->Auth->user('cu_cve')
      ));
    }

    $this->set(compact('ofertas', 'stats', 'title_for_layout'));
    $this->render('_index');
  }

  public function todas() {
    $title_for_layout = __('Todas las Ofertas');

    if ($this->isAjax) {
      $ofertas = $this->Oferta->get('dependientes', array(
        'conditions' => array(
          'Oferta.cia_cve' => $this->Auth->user('Empresa.cia_cve'),
          'Oferta.oferta_inactiva = ' => 0,
        ),
        'parent' => $this->Auth->user('cu_cve')
      ));
    }

    $this->set(compact('ofertas', 'folders', 'title_for_layout'));
    $this->render('_index');
  }

  /**
   * Ver las ofertas compartidas.
   * @return [type] [description]
   */
  public function compartidas() {
    $title_for_layout = __('Mis Ofertas compartidas');

    if ($this->isAjax) {
      $ofertas = $this->Oferta->get('compartidas', array(
        'fromCia' => $this->Auth->user('Empresa.cia_cve')
      ));
    }

    $this->set(compact('ofertas', 'title_for_layout'));
  }

  public function en_borrador() {
    $title_for_layout = __('Mis Ofertas en Borrador');

    $this->paginate = array(
      //'findType' => 'dependents',
      'conditions' => array(
        'Oferta.cu_cve' => $this->Auth->user('cu_cve'),
        'Oferta.oferta_status = ' => 0,
        'Oferta.oferta_inactiva = ' => 0
      ),
      'order' => array(
        'Oferta.created' => 'DESC'
      ),
      //'parent' => $this->Auth->user('cu_cve')
    );
    $ofertas = $this->paginate();
    $this->set(compact('ofertas', 'title_for_layout'));
  }

  /**
   * Ver las ofertas activas.
   * @return [type] [description]
   */
  public function activas($type = null) {
    $title_for_layout = __('Mis Ofertas Activas');

    $stats = array(
      'ofertas' => $this->Oferta->getStatusStats($this->Auth->user('cu_cve'), $this->Auth->user('Empresa.cia_cve'), 'bprd'),
      'creditos' => $this->Creditos->get(array(
        'oferta_publicada',
        'oferta_recomendada',
        'oferta_distinguida'
      ))
    );

    $ofertas = $this->Oferta->find('activas', array(
      'fromUser' => $this->Auth->user('cu_cve')
    ));

    $this->set(compact('ofertas', 'stats', 'title_for_layout'));
    $this->render('_index');
  }

  public function inactivas() {
    $title_for_layout = __('Mis Ofertas Inactivas');

    $this->paginate = array(
      //'findType' => 'dependents',
      'conditions' => array(
        'Oferta.cu_cve' => $this->Oferta->UsuarioEmpresa->getIds('dependents', array(
          'parent' => $this->Auth->user('cu_cve'),
        )),
        'OR' => array(
          'AND' => array(
            'Oferta.oferta_fecfin < CURRENT_DATE',
            'Oferta.oferta_status > ' => 0,
            'Oferta.oferta_inactiva > ' => -2,
          ),
          'Oferta.oferta_inactiva' => array(-1, 1),
        )
      ),
      //'parent' => $this->Auth->user('cu_cve')
    );
    $ofertas = $this->paginate();
    $this->set(compact('ofertas', 'title_for_layout'));
  }

  /**
   * Ver las ofertas inactivas.
   * @return [type] [description]
   */
  public function eliminadas() {
    $title_for_layout = __('Mis Ofertas Eliminadas');

    $this->paginate = array(
      'conditions' => array(
        'Oferta.cu_cve' => $this->Oferta->UsuarioEmpresa->getIds('dependents', array(
          'parent' => $this->Auth->user('cu_cve'),
        )),
        'Oferta.oferta_inactiva' => -2
      ),
      'contain' => array('UsuarioEmpresa' => array(
        'fields' => array('cu_cve', 'cu_sesion', 'keycode')
      )),
      'recursive' => -1
    );
    $ofertas = $this->paginate();
    $this->set(compact('ofertas', 'title_for_layout'));
  }

  /**
   * Crea una nueva oferta.
   * @return [type] [description]
   */
  public function nueva() {
    $title_for_layout = __('Crear Oferta');

    if ($this->request->is('post')) {

      /**
       * Establece por default el status de borrador. Verifica si se pasa el valor de submit y asigna el valor a
       * status si existe.
       */
      $this->request->data['Oferta']['oferta_status'] = $this->Oferta->getStatusType('borrador');
      if (isset($this->request->data['submit'])) {
        $submitValue = $this->request->data['submitValue'];
        /**
         * Se establece que status va a tener la oferta.
         */
        $this->request->data['Oferta']['oferta_status'] = $this->Oferta->getStatusType($submitValue);
      }

      /**
       * Verifica que se asigne a un usuario, en caso contrario, asigna la oferta al usuario que inicio sesión.
       */
      if (empty($this->request->data['Oferta']['cu_cve'])) {
        $this->request->data['Oferta']['cu_cve'] = $this->Auth->user('cu_cve');
      }
      /**
       * Se detecta si hay alguna referencia hacia algun correo electronico o telefono en la descripción
       */
      if(preg_match('/([a-zA-Z0-9_.+-]+)@([a-zA-Z_-]+).([a-zA-Z]{2,4})(.[a-zA-Z]{2,3})?/i', $this->request->data['Oferta']['oferta_descrip']) ||
        preg_match("/0{0,2}([\+]?[\d]{1,3} ?)?([\(]([\d]{2,3})[)] ?)?[0-9][0-9 \-]{6,}( ?([xX]|([eE]xt[\.]?)) ?([\d]{1,5}))?/i",
          $this->request->data['Oferta']['oferta_descrip']) ){
        $this->error("Hemos detectado una dirección de correo electrónico o teléfono en la Descripción de la oferta, por favor elimínela para continuar con la publicación y active la casilla  Mostrar datos de contacto en la parte de CONFIGURACIÓN  que se localiza más abajo para mostrar los datos al candidato.");
        $this->set('message_time', 10000);
        return;
      }

      /**
       * Obtiene el tipo de crédito del status.
       */
      $creditType = $this->Oferta->checkCredit($this->request->data);

      /**
       * Verifica si tiene crédito dependiendo del tipo. En caso de no tener, vuelve a establecer la oferta como
       * borrador.
       */
      $hasCredits = $this->Creditos->has($creditType);
      if (!$hasCredits) {
        $this->request->data['Oferta']['oferta_status'] = $this->Oferta->getStatusType('borrador');
      }

      // if ($this->request->data['Oferta']['cu_cve'] != $this->Auth->user('cu_cve')) {
      //   $this->request->data['Oferta']['carpeta_cve'] = null;
      // }

      $this->request->data['Oferta']['cu_cvereg'] = $this->Auth->user('cu_cve');        // Qué usuario la crea.
      $this->request->data['Oferta']['cia_cve'] = $this->Auth->user('Empresa.cia_cve'); // A qué compañia pertenece.

      if (!empty($this->request->data['Oferta']['etiquetas'])) {
        $etiquetas = ClassRegistry::init('Etiqueta')->verificar(
          json_decode($this->request->data['Oferta']['etiquetas'])
        );
        $this->request->data['Etiquetas'] = $etiquetas;
      }

      if (!empty($this->request->data['Oferta']['categorias'])) {
        $areas = ClassRegistry::init('AreasOferta')->format(
          json_decode($this->request->data['Oferta']['categorias'])
        );
        $this->request->data['Areas'] = $areas;
      }

      $this->Oferta->begin();   // Transacción.
      $this->Oferta->create();

      if ($this->Oferta->saveAll($this->request->data /*, array('atomic' => false)*/ )) {
        $redirect = array('action' => 'index');
        $id = $this->Oferta->getLastInsertID(); // Id de la oferta insertada.

        if (!$hasCredits) {
          $this->Oferta->commit();
          $this->warning(__('No cuentas con créditos. Se guardo la oferta como borrador.'));
          $this->updateSession();
        } else if($this->Creditos->spend($creditType, $id)) {
          $this->Oferta->commit();
          $this->success(__('Se ha guardado la oferta satisfactoriamente'));
          $this->updateSession();

          /**
           * Si la oferta es activa, mostrará que ha sido publicada.
           */
          if ($this->Oferta->is('activa', $this->request->data)) {
            if ($this->generateShortenURL($id)) {

            } else {
              $this->error(__('Ocurrió un error al generar el link corto.'));
            }

            $redirect = array(
              'action' => 'publicada',
              'id' => $id
            );
          }
        } else {
          $this->Oferta->rollback();
          $this->set('noValidationErrors', true);
          $this->error(__('Ha ocurrido un error al actualizar tus créditos.'));
        }

        $this->redirect($redirect);
      } else {
        $this->Oferta->rollback();
        $this->response->statusCode(400);
        $this->error(__('Ocurrió un error al guardar la oferta.'));
      }
    }

    $listas = $this->catalogos();
    $this->set(compact('listas', 'title_for_layout'));
  }

  public function publicada($id) {
    $title_for_layout = __('Oferta Publicada');
    $this->Oferta->id = $id;

    if (!$this->Oferta->is('activa')) {
      $this->error(__('Esta oferta es un borrador.'));
      $this->redirect(array(
        'action' => 'index'
      ));
    }

    $oferta = $this->Oferta->get($id, array(
      'fields' => array('oferta_cve', 'oferta_link')
    ));

    $shortenUrl = $oferta['oferta_link'];
    if (empty($shortenUrl)) {
      if ($shortenUrl = $this->generateShortenURL($id)) {

      } else {
        $this->error(__('Ocurrió un error al generar el link corto.'));
      }
    }

    $this->set('ofertaID',  $oferta['oferta_cve']);
    $this->set(compact('title_for_layout', 'shortenUrl'));
  }

  /**
   * Edita una oferta.
   * @param  [type] $id [description]
   * @return [type]     [description]
   */
  public function editar($id) {
    $this->Oferta->id = $id;
    $isOwnedBy = $this->Oferta->isOwnedBy($this->Oferta->UsuarioEmpresa->getIds('dependents', array(
      'parent' => $this->Auth->user('cu_cve'),
    )), null, array(
      'fields' => array('oferta_fecini', 'oferta_status')
    ));

    $canEdit = false;
    $title_for_layout = __('Editar Oferta');

    if ($isOwnedBy) {
      /**
       * Verifica si es borrador o, en caso de ser activa, no han transurrido 5 días después de su publicación.
       * @var boolean
       */
      $canEdit = (int)$isOwnedBy['Oferta']['oferta_status'] === 0  ||
        CakeTime::wasWithinLast('5 days', $isOwnedBy['Oferta']['oferta_fecini']);

      if ($this->request->is('get')) {
        $oferta = $this->Oferta->get($id, array(
          'recursive' => 1
        ));

        //$oferta['Oferta']['_defaults']['passFields'] = $oferta['Oferta']['campos'] ?: '[]';
        $oferta['Oferta']['oferta_prestaciones'] = json_decode($oferta['Oferta']['oferta_prestaciones']);
        $oferta['Oferta']['categorias'] = Utils::toJSONArray($oferta, 'Areas.{n}.area_cve');
        $oferta['Oferta']['etiquetas'] = Utils::toJSONObjectArray($oferta, array(
          'id' => 'Etiquetas.{n}.etiqueta_cve',
          'name' => 'Etiquetas.{n}.etiqueta_nombre',
          'data' => 'Etiquetas.{n}.etiqueta_nombre'
        ));
        $oferta['Estado'] = ClassRegistry::init('Ciudad')->getEstado($oferta['Oferta']['ciudad_cve'])['Estado'];

        $this->request->data = $oferta;
      } else {
        $data = $this->request->data;
        $data['Oferta']['cia_cve'] = $this->Auth->user('Empresa.cia_cve');

        if (isset($data['submit'])) {
          $submitValue = $data['submitValue'];
          /**
           * Se establece que status va a tener la oferta.
           */
          $data['Oferta']['oferta_status'] = $this->Oferta->getStatusType($submitValue);
        }

        /**
         * Se detecta si hay alguna referencia hacia algun correo electronico o telefono en la descripción
         */
        if(preg_match('/([a-zA-Z0-9_.+-]+)@([a-zA-Z_-]+).([a-zA-Z]{2,4}(.[a-zA-Z]{2,3})?)/i', $data['Oferta']['oferta_descrip']) ||
          preg_match("/0{0,2}([\+]?[\d]{1,3} ?)?([\(]([\d]{2,3})[)] ?)?[0-9][0-9 \-]{6,}( ?([xX]|([eE]xt[\.]?)) ?([\d]{1,5}))?/i", $data['Oferta']['oferta_descrip'])) {
          $this->error("Hemos detectado una dirección de correo electrónico o teléfono en la Descripción de la oferta, por favor elimínela para continuar con la publicación y active la casilla  Mostrar datos de contacto en la parte de CONFIGURACIÓN  que se localiza más abajo para mostrar los datos al candidato.");
          $this->set('message_time', 10000);
          return;
        }

        /**
         * Si el status al que se va actualizar es mayor, va a gastar créditos. Por eso se verifica para que en caso contrario
         * se salte la verficación y el gasto de créditos.
         * @var [type]
         */
        $spendCredit = $data['Oferta']['oferta_status'] > $isOwnedBy['Oferta']['oferta_status'];

        $defaults = array('oferta_redsocial', 'oferta_datos', 'oferta_preguntas', 'oferta_privada', 'oferta_viajar', 'oferta_residencia');
        foreach ($defaults as $key) {
          empty($data['Oferta'][$key]) && ($data['Oferta'][$key] = 0);
        }

        /**
         * Obtiene el tipo de crédito del status.
         */
        $creditType = $this->Oferta->checkCredit($data);

        /**
         * Si no va a cambiar el status, no es necesario verificar que tienen créditos. Ni gastar.
         * Verifica si tiene crédito dependiendo del tipo. En caso de no tener, vuelve a establecer la oferta al status
         * que tenía.
         */
        $hasCredits = !$spendCredit || $this->Creditos->has($creditType);

        if (!$hasCredits) {
          $data['Oferta']['oferta_status'] = $isOwnedBy['Oferta']['oferta_status'];
        }

        $this->Oferta->begin();   // Transacción.

        /**
         * Si la oferta se puede editar entonces guardará toda la información que se haya modificado.
         * Si la oferta no se puede editar pero va a cambiar su status (si $spendCredit es true, siginifica que el
         * status de la oferta va a cambiar por eso se gasta un crédito), entonces se intenta cambiar su status.
         */
        if (($canEdit && $this->Oferta->edit($id, $data)) ||
            ($spendCredit && $this->Oferta->changeStatus($id, $data['Oferta']['oferta_status']))) {
          if (!$hasCredits) {
            $this->Oferta->commit();
            $this->warning(__('No cuentas con créditos. No se actualizó el status de la oferta.'));
            // $this->updateSession();
          } else if(!$spendCredit || $this->Creditos->spend($creditType, $id)) {
            $this->Oferta->commit();
            $this->success(__('Se ha guardado la oferta satisfactoriamente'));
            $this->updateSession();

            /**
             * Si la oferta es activa, mostrará que ha sido publicada.
             */
            if ($this->Oferta->is('activa', $data)) {
              if ($this->generateShortenURL($id)) {

              } else {
                $this->error(__('Ocurrió un error al generar el link corto.'));
              }

              $redirect = array(
                'action' => 'publicada',
                'id' => $id
              );
            } elseif ($this->Oferta->is('borrador', $data)) {
              $redirect = array(
                'action' => 'en_borrador'
              );
            }

            // $this->redirect($redirect);
          } else {
            $this->Oferta->rollback();
            $this->set('noValidationErrors', true);
            $this->error(__('Ha ocurrido un error al actualizar tus créditos.'));
          }
        } else {
          $this->response->statusCode(400);
          $this->error(__('Ocurrió un error al guardar la oferta.'));
        }
      }

    } else {
      $this->error(__('No tienes los permisos para esta acción.'));
      $this->redirect('referer');
    }

    $listas = $this->catalogos();

    $this->set(compact('listas', 'title_for_layout', 'canEdit'));
  }

  public function match($ofertaId) {
    $isOwnedBy = $this->Oferta->isOwnedBy($this->Auth->user('Empresa.cia_cve'), $ofertaId, array(
      'userKey' => 'cia_cve'
    ));

    $candidatos = array();
    if ($isOwnedBy) {
      $candidatos = ClassRegistry::init('CandidatoB')->find('match', array(
        'fromUser' => $this->Auth->user('cu_cve'),
        'fromCia' => $this->Auth->user('Empresa.cia_cve'),
        'expresion' => $this->Oferta->find('expresion', array(
          'oferta' => $ofertaId
        )),
        'limit' => 10,
        'order' => array(
          'score(1)' => 'DESC'
        )
      ));
    } else {
      $this->error(__('Esta oferta no existe o no tienes los permisos suficientes.'));
    }

    $this->set(compact('candidatos'));
  }

  public function duplicar($id) {
    $title_for_layout = __('Republicar Oferta');

    if (!$this->request->is('get')) {
      throw new MethodNotAllowedException(__('Método no permitido'), 1);
    }

    if (!$this->Oferta->is('activa', $id)) {
      $this->error(__('No puedes duplicar una oferta que es un borrador.'));
      $this->redirect('referer');
    } else {
      $oferta = $this->Oferta->getCopy($id);

      //$oferta['Oferta']['_defaults']['passFields'] = $oferta['Oferta']['campos'];
      $oferta['Oferta']['oferta_prestaciones'] = json_decode($oferta['Oferta']['oferta_prestaciones']);
      $oferta['Oferta']['categorias'] = Utils::toJSONArray($oferta, 'Areas.{n}.area_cve');
      $oferta['Oferta']['etiquetas'] = Utils::toJSONObjectArray($oferta, array(
        'id' => 'Etiquetas.{n}.etiqueta_cve',
        'name' => 'Etiquetas.{n}.etiqueta_nombre',
        'data' => 'Etiquetas.{n}.etiqueta_nombre'
      ));

      $oferta['Estado'] = ClassRegistry::init('Ciudad')->getEstado($oferta['Oferta']['ciudad_cve'])['Estado'];

      $this->request->data = $oferta;
    }

    $listas = $this->catalogos();
    $canEdit = $new = true;
    $this->set(compact('title_for_layout', 'listas', 'canEdit', 'new'));
    $this->render('editar');
  }

  public function ver($id) {
    if (!$this->Oferta->exists($id)) {
      throw new NotFoundException(__('La oferta que buscas no existe.'));
    }
    $oferta = $this->Oferta->get('oferta', array(
      'idOferta' => $id,
      'conditions' => array(
        // 'Oferta.oferta_cve' => $id,
        'Oferta.cia_cve' => AuthComponent::user('Empresa.cia_cve')
      )
    ));


    $this->set(compact('oferta'));
  }

  public function distinguir($id) {
    if (!$this->Creditos->has('oferta_distinguida')) {
      $this->Creditos->redirect();
      return;
    }

    $isOwnedBy = $this->Oferta->isOwnedBy($this->Oferta->UsuarioEmpresa->getIds('dependents', array(
      'parent' => $this->Auth->user('cu_cve'),
    )), $id);

    if ($isOwnedBy) {
      $this->Oferta->begin();
      if ($this->Oferta->changeStatus($id, $this->Oferta->getStatusType('distinguida'))) {
        if ($this->Creditos->spend('oferta_distinguida', $id)) {
          $this->Oferta->commit();
          $this->updateSession();
          if ($this->generateShortenURL($id)) {
            $this->success(__('La oferta se ha publicado como distinguida.'));
          } else {
            $this->error(__('Ocurrió un error al generar el link corto.'));
          }

          $this->redirect(array(
            'action' => 'publicada', 'id' => $id
          ));
        } else {
          $this->Oferta->rollback();
          $this->error(__('Ha ocurrido un error al actualizar tus créditos.'));
        }
      } else {
        $this->error(__('No se ha podido cambiar la oferta de estado.'));
      }
    } else {
      $this->error(__('No tienes los permisos para esta acción.'));
    }
  }

  public function recomendar($id) {
    if (!$this->Creditos->has('oferta_recomendada')) {
      $this->Creditos->redirect();
      return;
    }

    $isOwnedBy = $this->Oferta->isOwnedBy($this->Oferta->UsuarioEmpresa->getIds('dependents', array(
      'parent' => $this->Auth->user('cu_cve'),
    )), $id);

    if ($isOwnedBy) {
      $this->Oferta->begin();
      if ($this->Oferta->changeStatus($id, $this->Oferta->getStatusType('recomendada'))) {
        if ($this->Creditos->spend('oferta_recomendada', $id)) {
          $this->Oferta->commit();
          $this->updateSession();
          if ($this->generateShortenURL($id)) {
            $this->success(__('La oferta se ha publicado como recomendada.'));
          } else {
            $this->error(__('Ocurrió un error al generar el link corto.'));
          }

          $this->redirect(array(
            'action' => 'publicada', 'id' => $id
          ));
        } else {
          $this->Oferta->rollback();
          $this->error(__('Ha ocurrido un error al actualizar tus créditos.'));
        }
      } else {
        $this->error(__('No se ha podido cambiar la oferta de estado.'));
      }
    } else {
      $this->error(__('No tienes los permisos para esta acción.'));
    }
  }

  public function publicar($id) {
    if (!$this->Creditos->has('oferta_publicada')) {
      $this->Creditos->redirect();
      return;
    }

    $isOwnedBy = $this->Oferta->isOwnedBy($this->Oferta->UsuarioEmpresa->getIds('dependents', array(
      'parent' => $this->Auth->user('cu_cve'),
    )), $id);

    if ($isOwnedBy) {
      $this->Oferta->begin();
      if ($this->Oferta->changeStatus($id, $this->Oferta->getStatusType('publicada'))) {
        if ($this->Creditos->spend('oferta_publicada', $id)) {
          $this->Oferta->commit();
          $this->updateSession();

          if ($this->generateShortenURL($id)) {
            $this->success(__('La oferta se ha publicado.'));
          } else {
            $this->error(__('Ocurrió un error al generar el link corto.'));
          }

          $this->redirect(array(
            'action' => 'publicada', 'id' => $id
          ));
        } else {
          $this->Oferta->rollback();
          $this->error(__('Ha ocurrido un error al actualizar tus créditos.'));
        }
      } else {
        $this->Oferta->rollback();
        $this->error(__('No se ha podido cambiar la oferta de estado.'));
      }
    } else {
      $this->error(__('No tienes los permisos para esta acción.'));
    }
    $this->redirect('referer');
  }

  public function compartir($id, $keycode = null) {
    $isOwnedBy = $this->Oferta->isOwnedBy($this->Oferta->UsuarioEmpresa->getIds('dependents', array(
      'parent' => $this->Auth->user('cu_cve'),
    )), $id, array(
      'fields' => array('Oferta.oferta_status')
    ));

    if ($isOwnedBy) {
      if ($isOwnedBy['Oferta']['oferta_status'] > 0) {
        $isDelete = $this->request->is('delete');
        if ($this->Oferta->compartir($id, !$isDelete)) {
          $msg = $isDelete ? __('La oferta se ha dejado de compartir.') : __('Esta oferta ha sido compartida');
          $this->updateSession();
          $this->success($msg)
            ->html('element', 'empresas/submenus/ofertas');

          $isDelete && $this->callback('deleteRow', array(
            (array)$id
          ));
        } else {
          $this->error(__('No se ha podido cambiar la oferta de estado.'));
        }
      } else {
        $this->error(__('No puedes compartir una oferta que es aún borrador.'));
      }
    } else {
      $this->error(__('No tienes los permisos para esta acción.'));
    }
    //$this->redirect('referer');
  }

  public function carpetas() {
    $title_for_layout = __('Carpetas de Mis Ofertas');

    $this->paginate = array(
      'conditions' => array(
        'Carpeta.cu_cve' => $this->Auth->user('cu_cve'),
      ),
      'contain' => array('Usuario', 'Contacto'),
      'findType' => 'ofertas',
      // 'nest' => array(
      //   'idPath' => '{n}.Carpeta.carpeta_cve',
      //   'parentPath' => '{n}.Carpeta.carpeta_cvesup',
      // ),
      'order' => false,
    );

    $carpetas = $this->paginate('Carpeta');
    $this->set(compact('carpetas', 'title_for_layout'));
  }

  public function carpeta($folderId, $folderName = null) {
    $carpeta = $this->Oferta->Carpeta->get($folderId, array(
      'recursive' => -1
    ));

    $title_for_layout = 'Ofertas en ' . $carpeta['carpeta_nombre'];

    $stats = array(
      'ofertas' => $this->Oferta->getStatusStats($this->Auth->user('cu_cve'), $this->Auth->user('Empresa.cia_cve'), 'bprd'),
      'creditos' => $this->Creditos->get(array(
        'oferta_publicada',
        'oferta_recomendada',
        'oferta_distinguida'
      ))
    );

    $this->paginate = array(
      'conditions' => array(
        'Oferta.oferta_fecfin >= CURRENT_DATE',
        'Oferta.cu_cve' => $this->Auth->user('cu_cve'),
        'Oferta.oferta_inactiva = ' => 0,
        'Oferta.carpeta_cve' => $folderId
      ),
      'contain' => array(
        'UsuarioEmpresa' => array(
          'fields' => array('cu_cve', 'cu_sesion', 'keycode')
        )
      ),
      //'limit' => 10,
      'recursive' => 0
    );
    $ofertas = $this->paginate();
    $this->set(compact('ofertas', 'stats', 'carpeta', 'title_for_layout'));
    $this->render('_index');
  }

  /**
   * Guarda una oferta en las carpetas del usuario.
   * @param  int    $candidatoId [description]
   * @return [type]              [description]
   */
  public function guardar_en($ofertaId, $ofertaSlug, $folderId, $folderSlug) {
    $userId = $this->Auth->user('cu_cve');

    if ($ofertaId) {
      $isOwnedBy = $this->Oferta->isOwnedBy($userId, $ofertaId);
      if (!$isOwnedBy) {
        $this->error(__('No tienes los permisos para esta acción.'));
        return;
      }
      $successMsg = __('Se ha guardado la oferta satisfactoriamente.');
    } else {
      $ofertaId = $this->request->data('ids');
      $successMsg = __('Se han guardado las ofertas satisfactoriamente.');
    }

    if ($this->Oferta->guardarEnCarpeta($folderId, $ofertaId)) {
      $this->updateSession();

      $this->success($successMsg)
        ->html('element', 'empresas/submenus/ofertas');
      $this->set(compact('folderId', 'ofertaId'));
    } else {
      $this->error(__('Ha ocurrido un error al procesar tu solicitud.'));
    }
  }

  public function pausar($ofertaId = null) {

    if ($ofertaId) {
      $isOwnedBy = $this->Oferta->isOwnedBy($this->Oferta->UsuarioEmpresa->getIds('dependents', array(
        'parent' => $this->Auth->user('cu_cve'),
      )), $ofertaId);

      if (!$isOwnedBy) {
        $this->error(__('No tienes los permisos para esta acción.'));
        return;
      }
      $successMsg = __('La oferta ha sido pausada.');
    } else {
      $ofertaId = $this->request->data('ids');
      $successMsg = __('Se han pausado las ofertas satisfactoriamente.');
    }

    if ($this->Oferta->inactivar($ofertaId, 1)) {
      $this->updateSession();
      $this->success($successMsg)
        ->callback('deleteRow', array(
          (array)$ofertaId
        ))
        ->html('element', 'empresas/submenus/ofertas');
    } else {
      $this->error(__('La oferta no se ha podido pausar.'));
    }

    $this->redirect('referer');
  }

  public function reanudar($id) {
    $isOwnedBy = $this->Oferta->isOwnedBy($this->Oferta->UsuarioEmpresa->getIds('dependents', array(
      'parent' => $this->Auth->user('cu_cve'),
    )), $id);

    if ($isOwnedBy) {
      if ($this->Oferta->inactivar($id, 0)) {
        $this->updateSession();
        $this->success(__('La oferta ha sido reanudada.'))
          ->callback('deleteRow')
          ->html('element', 'empresas/submenus/ofertas');

      } else {
        $this->error(__('La oferta no se ha podido reanudar.'));
      }
    } else {
      $this->error(__('No tienes los permisos para esta acción.'));
    }

    $this->redirect('referer');
  }

  public function eliminar($ofertaId = null, $slug = null, $keycode = null) {
    $userId = $this->Auth->user('cu_cve');
    $isKey = $keycode === $this->Auth->user('keycode') && $this->Oferta->isOwnedBy($userId, $ofertaId);
    if ($ofertaId) {
      $isOwnedBy = $this->Oferta->isOwnedBy($this->Oferta->UsuarioEmpresa->getIds('dependents', array(
        'parent' => $this->Auth->user('cu_cve'),
      )), $ofertaId);
      if (!$isOwnedBy) {
        $this->error(__('No tienes los permisos para esta acción.'));
        return;
      } elseif (!empty($keycode) && !$isKey) {
        $this->error(__('No tienes los permisos para esta acción, tú no has creado la oferta.'));
        return;
      }

      $successMsg = 'Se ha borrado la oferta' . ($isKey ? ' de forma permanente.' : '.');
    } else {
      $ofertaId = $this->request->data('ids');
      $successMsg = 'Se han borrado las ofertas' . ($isKey ? ' de forma permanente.' : '.');
    }

    if ($isKey && $this->Oferta->inactivar($ofertaId, -3)) {
      $this->updateSession();
      $this->success($successMsg)
        ->callback('deleteRow')
        ->html('element', 'empresas/submenus/ofertas');
      $this->redirect(array('action' => 'papelera'));
    } elseif ($this->Oferta->inactivar($ofertaId, -2)) {
      $this->updateSession();
      $this->success($successMsg)
        ->callback('deleteRow')
        ->html('element', 'empresas/submenus/ofertas');
    } else {
      $this->error(__('No se han podido inactivar las ofertas que seleccionaste.'));
    }

    $this->redirect('referer');
  }

  public function recuperar($ofertaId = null) {
    if ($ofertaId) {
      $isOwnedBy = $this->Oferta->isOwnedBy($this->Oferta->UsuarioEmpresa->getIds('dependents', array(
        'parent' => $this->Auth->user('cu_cve'),
      )), $ofertaId);
      if (!$isOwnedBy) {
        $this->error(__('No tienes los permisos para está acción.'));
        return;
      }
      $successMsg  = __('La oferta se ha recuperado.');
    } else {
      $ofertaId = $this->request->data('ids');
      $successMsg = __('Las ofertas se han recuperado');
    }

    if ($this->Oferta->inactivar($ofertaId, false)) {
      $this->updateSession();
      $this->success($successMsg)
        ->html('element', 'empresas/submenus/ofertas')
        ->callback('deleteRow', array(
          (array)$ofertaId
        ));
      //$this->redirect(array('action' => 'index'));
    } else {
      $this->error(__('No se han podido recuperar las ofertas que seleccionaste.'));
    }
  }

  public function postulaciones($ofertaId, $ofertaSlug = null, $itemId = null, $itemSlug = null) {
    if ($itemId === null) {
      $isOwnedBy = $this->Oferta->isOwnedBy($this->Auth->user('Empresa.cia_cve'), $ofertaId, array(
        'userKey' => 'cia_cve'
      ));

      $candidatos = array();
      if ($isOwnedBy) {
        $candidatos = $this->Oferta->get('postulaciones', array(
          'fromUser' => $this->Auth->user('cu_cve'),
          'fromCia' => $this->Auth->user('Empresa.cia_cve'),
          'conditions' => array(
            'Oferta.oferta_cve' => $ofertaId
          ),
          'first' => true
        ));
        $title_for_layout = __('Postulaciones en %s', $candidatos['Oferta']['puesto_nom']);
      } else {
        $title_for_layout = __('Esta oferta no existe');
        $this->error(__('Esta oferta no existe o no tienes los permisos suficientes.'));
      }

      $this->set(compact('title_for_layout', 'candidatos'));
    } else {
      $candidato = ClassRegistry::init('CandidatoEmpresa')->get($itemId, 'perfil', array(
        'fromUser' => $this->Auth->user('cu_cve'),
        'fromCia' => $this->Auth->user('Empresa.cia_cve'),
      ));
      $c = $candidato['CandidatoEmpresa'];
      $isAcquired = (int)$candidato['Empresa']['adquirido'] === 1;

      if ($isAcquired) {
        $this->redirect(array(
          'controller' => 'candidatos',
          'action' => 'perfil',
          'id' => $itemId,
          'slug' => Inflector::slug($c['candidato_perfil'], '-')
        ));

        return true;
      }

      $nombre = $c['candidato_nom'] . ' ' . $c['candidato_pat'] . ' ' . $c['candidato_mat'];
      $title_for_layout = __('Perfil de %s', $nombre);
      $_listas = array(
        'motivos' => ClassRegistry::init('Catalogo')->lista('MOTIVO_CVE'),
        'notas' => ClassRegistry::init('Catalogo')->lista('ANOTACION_TIPO')
      );
      $this->set(compact('title_for_layout','candidato', '_listas'));

      $this->render('/Candidatos/perfil_postulado');
    }
  }
}