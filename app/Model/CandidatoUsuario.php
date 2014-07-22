<?php
  App::import('Vendor','funciones');
  App::import('model','Candidato');

  App::uses('UsuarioBase', 'Model');
  class CandidatoUsuario extends UsuarioBase {
    var $name='CandidatoUsuario';
    var $useTable = 'tcuentacandidato';
    var $primaryKey="candidato_cve";

  /**
   * Nombre del campo del sesión del usuario.
   * @var string
   */
  public $sessionKey = 'cc_email';

  /**
   * Nombre del campo del status del usuario.
   * @var string
   */
  public $statusKey = 'cc_status';

  /**
   * Nombre del campo del password del usuario.
   * @var string
   */
  public $passwordKey = 'cc_password';



  public $belongsTo= array(
      'Candidato'=> array(
      'className'    => 'Candidato',
      'foreignKey'   => "candidato_cve"
      ));



public $validate = array(
    'cc_email' => array(
                  "required"=> array(
                                      'rule' => 'notEmpty',
                                      'required' => true,
                                      'message'    => 'Ingresa un correo electrónico.'
                                    ),
                  'email' => array(
                        'rule'       => array('email', true), // or: array('ruleName', 'param1', 'param2' ...)
                        'message' => 'Formato de correo electrónico no válido.'
                    ),
                   "unique"=> array(
                                          'rule' => 'isUnique',
                                          'message' => 'Ya existe un correo registrado en Nuestro Empleo.'
                                    )

                ),
     'cc_email_confirm' => array(
       "required"=> array(
                                      'rule' => 'notEmpty',
                                      'required' => true,
                                      'message'    => 'Ingresa de nuevo el mismo correo electrónico.'
                                    ),
        "equalto"=> array(
                                      'rule'   => array('equalTo','cc_email'),
                                      'message'    => 'Ingresa de nuevo el mismo correo electrónico.'
                                    )

                ),

     'contrasena' => array(
                  "required"=> array(
                                      'rule' => 'notEmpty',
                                      'required' => true,
                                      'message'    => 'Ingresa una contraseña.'
                                    ),
                  'minlength' => array(
                                      'rule'=> array('minLength',8 ),
                                      'message' => 'Ingresa una contraseña mínimo de 8 caracteres.'
                                      ),
                 'maxlength' => array(
                                  'rule'=> array('maxLength',15),
                                  'message' => 'Ingresa una contraseña máximo de 15 caracteres.'
                                  ),
                 'alphanumeric' => array(
                                 'rule'=> array('alphaNumeric'),
                                  'message' => 'Verifica que tu contraseña esté conformada por letras y números.'

                  )


                ),
     'contrasena_confirma' => array(
      "required"=> array(
                                      'rule' => 'notEmpty',
                                      'required' => true,
                                      'message'    => 'Ingresa una nueva contraseña.'
                                    ),
        "equalto"=> array(
                                      'rule'   => array('equalTo','contrasena'),
                                      'message'    => 'Ingresa de nuevo la contraseña.'
                                    )

                ),




     'cc_password' => array(
       "required"=> array(
                                      'rule' => 'notEmpty',
                                      'required' => true,
                                      'message'    => 'Ingresa contraseña.'
                                    ))
  );



public function registrar($data, $perfil = null) {
    /**
      * Reinica los valores por default del Usuario y limpia el id.
      */
    $this->create();
    /*parametros a enviar al correo*/
    $this->name_full=$data['Candidato']['candidato_nom'] ." ".
                  $data['Candidato']['candidato_pat'] ." ".
                  $data['Candidato']['candidato_mat'];



    $this->email = $data['CandidatoUsuario']['cc_email'];
    $this->password =  $data['CandidatoUsuario']['contrasena'];

      /*configuramos el usuario del candidato con el password generado*/

      /*
      $db =& ConnectionManager::getDataSource('default');
        $db->showLog();
      */
    $data['CandidatoUsuario']['cc_password']=$this->password;
    $data['CandidatoUsuario']['per_cve']="10";
    $data['CandidatoUsuario']['cc_status']="-1";

   if (  $this->save($data['CandidatoUsuario']) ) {
        $data['Candidato']['candidato_cve']=$data['DirCandidato']['candidato_cve']=$this->id;
        $resultado= $this->Candidato->registrar($data);

      if($resultado[0]=="ok"){
           return array("ok","Los datos fueron guardados con éxito.");
      }
      else{
          return $resultado;
      }
   }

   return array("error","No se pudo guardar la información del  usuario.",$this->validationErrors);

  }

  public function guardar_primera($data,$id){

      $sts=$this->Candidato->guardar_primera($data,$id);
        if($sts[0]=='ok'){
            $user_data=array('CandidatoUsuario'=> array('candidato_cve'=>$id,'cc_completo'=>"S" )  );
            if($this->save($user_data,false) ){
                return array("ok","Los datos de Perfil General fueron guardados con éxito.");
            }
            else{
              return array("error","Error al guardar datos de usuario.");
            }

        }
        return $sts;

  }


  public  function existeEmail($email){
      $conditions = array(
          'cc_email' => $email
      );
      return  $this->hasAny($conditions);
    }

  public function existeEmailandPass($email,$pass){
      $conditions = array(
          'cc_email' => $email,
        'cc_password'=>$pass
      );
      return  $this->hasAny($conditions);
    }




    public function cambiar_contrasena($id,$password_old,$password){
        $first= $this->find("first",array("conditions"=>array("CandidatoUsuario.candidato_cve"=>$id) ));

      if(empty($first)){
          return array("error","El usuario no existe.");

      }


      $usu=$first[$this->name];
        /*encriptamos la contraseÃ±a envia y checamos que exista*/
        $password_old = Security::hash($password_old, 'blowfish',$usu['cc_password'] );
      if($usu[$this->passwordKey]!==$password_old){
          return array("error","La contraseña actual es incorrecta.");
      }
      $this->id=$id;
      if($this->changePassword($password,$id)){
          return array("ok","Se ha establecido la nueva contraseña.");
      }
      else{
        return array("error","La nueva contraseña no fue cambiada.");
      }

    }


    public function login($data){

        if(empty($data)){
           return array("error","Formulario vacio.");
        }
        $data=$data[$this->name];

          $first= $this->find("first",
                    array("conditions"=>array(
                        "cc_email"=>$data['cc_email'] )   )
                    );
          if(empty($first[$this->name])){
              return array("error","Este usuario no existe.");
          }
          else{
                 if($first[$this->name]['cc_status']=="1"  || $first[$this->name]['cc_status']=="0"  ){
                    return array("ok","Usuario existe y esta activo falta login.");
                  }

                  if($first[$this->name]['cc_status']==-2  ){
                    return array("error","Cuenta bloqueada.");
                  }
                  else if($first[$this->name]['cc_status']=="-1") {
                     return array("warning","Tu cuenta no ha sido activada verifica tu correo.");
                  }
                  else{
                      return array("warning","Tu cuenta esta dada de baja.");
                  }
          }

    }


public function status($idUser=null){

  return  $this->hasAny(array(
      "candidato_cve" => $idUser,
      "cc_status" => 1,
      "cc_completo"=> "S"
    ));

}
  public function activar_facebook($idFacebook =null,$idUser=null){
    $arr= $this->findByFacebookId($idFacebook);
    if( !empty($arr ) ){
      foreach($arr as $i  => $v ){
          $this->id=$v[$this->alias][$this->primaryKey];
          $this->saveField("facebook_id",null);
      }
    }
    $this->id=$idUser;
    $this->saveField("facebook_id",$user_id);
  }

  /**
   * verifica si la contraseña del usuario es nula
   * @param  inteher $idUser id del usuario
   * @return bool         regresa  true si la contraseña no esta vacia, false si lo esta.
   */
  public function checarPsw($idUser=null){
      $u=$this->read("cc_password",$idUser);
     return   isset($u[$this->alias])&&  !empty($u[$this->alias]['cc_password']) ;

  }

  public function getPhotoPath($id) {
    App::uses('Usuario', 'Utility');

    return Usuario::getPhotoPath($id);
  }

  public function formatByStatus($results, $options = array()) {
    $emails = array();
    $completos = array();
    $incompletos = array();
    $inactivos = array();

    foreach ($results as $_k => $_v) {
      $id = (int)$_v['CandidatoUsuario'][$this->primaryKey];
      $perfil = $_v['Candidato']['candidato_perfil'];
      $email = $_v['CandidatoUsuario']['cc_email'];
      $perfilCompleto = $_v['CandidatoUsuario']['cc_completo'] === 'S';
      $inactivo = (int)$_v['CandidatoUsuario']['cc_status'] === -1;

      $candidato = array(
        'id' => $id,
        'nombre' => $_v['Candidato']['nombre_'],
        'email' => $email,
        'foto_url' => $this->getPhotoPath($id)
      );

      if ($perfilCompleto) {
        $candidato['perfil'] = array(
          'nombre' => $perfil,
          'completo' => $perfilCompleto,
          'slug' => $perfilCompleto ? Inflector::slug($perfil . '-' . $id, '-') : false
        );
      } else {
        $candidato['perfil'] = false;
      }

      $emails[] = $email;

      if ($inactivo) {
        $inactivos[] = $candidato;
      } elseif ($perfilCompleto) {
        $completos[] = $candidato;
      } else {
        $incompletos[] = $candidato;
      }
    }

    return compact('emails', 'completos', 'incompletos', 'inactivos');
  }
  public function usuariosActivos($idConfig){
    return $this->_formEmail($idConfig,array(
       //"$this->alias.cc_email" => "lujano14.93@gmail.com"
              "$this->alias.cc_status" => 1    
      ));

  }
   public function usuariosInactivos(){
     return $this->_formEmail(null,array(
             // "$this->alias.cc_email" => "lujano14.93@gmail.com"
             "OR" => array(            
              "$this->alias.cc_status <>" => 1,
              "$this->alias.cc_completo <>" => "S",
              )   
      ));

   }
  private function _formEmail($idConfig=null,$conditions=array()){  
       $params=$this->init_param();
       $joins=$params['joins'];
       $fields=$params['fields'];
    
      if($idConfig !==null){
        $joins[]=array(
                  "table" => "tconfigcan",
                  "alias" => "ConfigCan",
                  "type" => "INNER",
                  "conditions"=> array(
                              "$this->alias.candidato_cve=ConfigCan.candidato_cve",
                              'ConfigCan.config_cve'=> $idConfig         
                    )
              );
      }
      return $this->find("all", array(  
        "recursive" => -1,
        "fields" => $fields,
        "joins" => $joins,
        "conditions" => $conditions
        ));
  }

  private  function init_param(){
          $fields=array(
              "$this->alias.candidato_cve",
              "{$this->alias}.cc_email {$this->alias}__correo",
              "$this->alias.keycode",
              "Candidato.candidato_nom||' '||Candidato.candidato_pat ||' ' ||Candidato.candidato_mat  {$this->alias}__nombre",
              "Pais.pais_cve  {$this->alias}__pais_cve  ",
              "Estado.est_cve {$this->alias}__est_cve",
              "Ciudad.ciudad_cve {$this->alias}__ciudad_cve",              
              "Pais.pais_nom  {$this->alias}__pais  ",
              "Estado.est_nom {$this->alias}__estado",
              "Ciudad.ciudad_nom {$this->alias}__ciudad",
              "CodigoPostal.cp_asentamiento {$this->alias}__colonia"
        );
      $joins=array(
                  array(
                        "table" => "tcandidato",
                        "alias" => "Candidato",
                        "type" => "INNER",
                        "conditions" => array(
                              "$this->alias.candidato_cve=Candidato.candidato_cve"
                    )
                )

        );
      $joins_d=$this->Candidato->joins['direccion'];

      foreach ($joins_d as  $key=>$value) {  
        $joins_d[$key]['fields']=array();
      }

      $joins=array_merge( $joins ,$joins_d);

      return compact("joins","fields");

  }
  public function registro_rapido($data=array()){

    /**
      * Reinica los valores por default del Usuario y limpia el id.
      */
    $this->create();
    /*parametros a enviar al correo*/
    $this->name_full=$data['Candidato']['candidato_nom'] ." ".
                  $data['Candidato']['candidato_pat'] ." ".
                  $data['Candidato']['candidato_mat'];                    
    $this->email = $data['CandidatoUsuario']['cc_email'];
    $this->password =  $data['CandidatoUsuario']['contrasena'];

      /*configuramos el usuario del candidato con el password generado*/
      /*
      $db =& ConnectionManager::getDataSource('default');
        $db->showLog();
      */
    $data['CandidatoUsuario']['cc_password']=$this->password;
    $data['CandidatoUsuario']['per_cve']="10";
    $data['CandidatoUsuario']['cc_status']="-1";

    $data['Candidato']['candidato_fecnac'] = "07/05/1985";
    $data['Candidato']['candidato_movil'] = "0";
    $data['Candidato']['edo_civil'] = 1;      
    $data['Candidato']['candidato_sex']='M';

   if ($this->save($data ) ) 
   {
        $this->Candidato->create();
        $data['Candidato']['candidato_cve'] =$this->id;
        if( $this->Candidato->save($data) ){
           $data_save=array(
            "EvaCan" =>array(
              "candidato_cve"=>$this->id,
              "evaluacion_cve"=>2,
              "cu_cve" => 1,
              "evaluacion_status" =>0,
              "evaluacion_fec" =>  date("Y-m-d ")
              ));
          $this->Candidato->id=$this->id;
          $this->Candidato->save(
                        array(
                          "candidato_sex"=>null,
                          "candidato_movil" =>null,
                          "edo_civil" =>null,
                          "candidato_sex" =>null
                          ),
                        false
            );
          return ClassRegistry::init("EvaCan")->save($data_save);
        }
       

   }
  
   return false;
  }

}
