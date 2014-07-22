<?php
/**
  *
  */
App::uses('AppController', 'Controller');

class TicketsController extends AppController {

  /**
    * Nombre del controlador.
    *
    * @var string
    */
  public $name = 'Tickets';

  /**
    * Componentes necesarios que utiliza el Controlador.
    * @var Array
    */
  public $components = array('Session', 'Emailer','VisualCaptcha');
  public $helper = array(
    'VisualCaptcha',
    'Form' => array('className' => 'Formito'),
    'Html' => array('className' => 'Htmlito')
  );

  public function beforeFilter() {
    parent::beforeFilter();

    //$this->layout = 'empresas/simple';
    $this->Auth->allow();
  }


  /**
    * Verifica que existan los tickets.
    *
    */
  public function index($ticket, $type = 'c') {
    if (!isset($ticket)) {
      $this->redirect('/');
    }

    $results = $this->Ticket->checkTicket($ticket);
    if (!empty($results)) {
      $userTicket = $type === 'e' ?
        ClassRegistry::init('UsuarioBase')->find('first', array(
          'fields' => array('UsuarioBase.cu_cve', 'UsuarioBase.cu_sesion', 'UsuarioBase.keycode'),
          'conditions' => array(
            'UsuarioBase.cu_sesion' => $results['Ticket']['info']
          ),
          'recursive' => -1
        )) :
        ClassRegistry::init('CandidatoUsuario')->find('first', array(
          'fields' => array('CandidatoUsuario.candidato_cve', 'CandidatoUsuario.cc_email', 'CandidatoUsuario.keycode'),
          'conditions' => array(
            'CandidatoUsuario.cc_email' => $results['Ticket']['info']
          ),
          'recursive' => -1
        ));

      if ($user = reset($userTicket)) {
        $this->Ticket->deleteTicket($ticket);
        $this->Session->write('Tokens.reset_password', $user['keycode']);
        $this->Session->write('Tokens.user_model', $type === 'e' ? 'UsuarioBase' : 'CandidatoUsuario');
        $this->redirect('/tickets/nueva_contrasena/' . $user['keycode']);
      } else {
        $this->error('Tu ticket no ha sido encontrado.');
        $this->redirect('/');
      }
      //

    } else {
      $this->error('Tu ticket ya ha expirado.');
      $this->redirect('/');
    }
  }

  /**
   * Permite generar una nueva contraseña al usuario con el CÓDIGO CLAVE = $keycode
   *
   * Una vez cambiada la contraseña de usuario genera un nuevo código clave para el usuario.
   * @param String $keycode Código de seguridad del usuario.
   */
  public function nueva_contrasena($keycode = null) {
    $canChangePassword = (
      $this->Session->check('Tokens.reset_password') &&
      $this->Session->read('Tokens.reset_password') === $keycode &&
      $this->Session->check('Tokens.user_model')
    );

    /**
     *
     */
    if (!$canChangePassword) {
      $this->error('No puedes cambiar tu contraseña.');
      $this->redirect('/');
    }

    $modelName = $this->Session->read('Tokens.user_model');
    $UserModel = ClassRegistry::init($modelName);
    $results = $UserModel->findByKeycode($keycode);

    if (!empty($results)) {
      if ($this->request->is('post')) {
          if(!$this->VisualCaptcha->isValid()){
            $this->error('El objeto arrastrado es distinto.');
            $this->response->statusCode(300);
            return ;
          }
        if ($this->request->data['Usuario']['password'] != $this->request->data['Usuario']['confirm_password']) {
          $this->error('Verifica que las contraseñas sean iguales.');
        } else {
          if ($UserModel->changePassword(
            $this->request->data['Usuario']['confirm_password'],
            $results[$modelName][$UserModel->primaryKey]
          )) {
            $this->Session->delete('Tokens.reset_password');
            $this->success('Se ha cambiado tu contraseña con éxito.');
          }
          $this->set('redirectUrl','/');
        }
      }
      $this->set('userFound', true);
      $this->set('keycode', $keycode);
      unset($this->request->data['Usuario']);
    } else {
      $this->error('Tu código clave no es el correcto. No podemos cambiar tu contraseña.');
    }
  }

  public function recuperar_contrasena($type = 'candidatos') {
    if ($type === 'empresas' || $type === 'candidatos') {
      if ($this->request->is('post')) {
        /* Verificamos captcha :P */
        if (!$this->VisualCaptcha->isValid()) {
          $this->response->statusCode(300);
          $sts = array("error", "El objeto arrastrado es distinto", array(
            'codigo' => "Verifique el código de seguridad"
          ));
          $this->responsejson($sts);
          return ;
        }

        /**
          * Dependiendo del tipo de usuario verificará que exista el correo electrónico
          */
        $existsEmail = $type === 'empresas' ?
          ClassRegistry::init('UsuarioBase')->hasAny(array(
            'UsuarioBase.cu_sesion' => $this->request->data['Usuario']['email']
          )) :
          ClassRegistry::init('CandidatoUsuario')->hasAny(array(
            'CandidatoUsuario.cc_email' => $this->request->data['Usuario']['email']
          ));

        if (!$existsEmail) {
          $this->response->statusCode(500);
          if ($this->isAjax) {
            $this->responsejson(array(
              "error",
              'El correo que has proporcionado no está registrado. Intenta con otro.'
            ));
          } else {
            $this->warning('El correo que has proporcionado no está registrado. Intenta con otro.');
          }
        } else {
          $email = $this->request->data['Usuario']['email'];
          $hash = Security::generateAuthKey();

          $existsTicket = $this->Ticket->findByInfo($email);

          if (!empty($existsTicket)) {
            $this->Ticket->id = $existsTicket['Ticket']['ticket_cve'];
          }

          $ticket['Ticket']['hash'] = $hash;
          $ticket['Ticket']['info'] = $email;
          $ticket['Ticket']['fec_exp'] = $this->Ticket->getExpirationDate(1);

          if ($this->Ticket->save($ticket)) {
            $this->Emailer->sendEmail(
              $email,                       // Email del usuario.
              'Recuperación de contraseña', // Titulo del mensaje.
              $type === 'empresas' ? 'empresas/recuperar_contrasena' : 'recuperar_contrasena_candidato',         // Plantilla es general.
              array(
                'email' => $email,
                'hash'  => $hash . '_' . $type[0]
              ),
              'recuperar_pass'
            );
            if($this->isAjax){
              $this->responsejson(array("ok", 'Ha sido enviado el correo con éxito a ' . $email));
            } else {
              $this->success('Ha sido enviado el correo con éxito a ' . $email);
            }
          } else {
            if ($this->isAjax) {
              $this->responsejson(array("error",'Ha ocurrido un error. Intenta más tarde.'));
            } else {
              $this->error('Ha ocurrido un error. Intenta más tarde.');
            }
          }
        }
      }
    } else {
      throw new NotFoundException("La página que buscas no existe.");
    }
  }
}
