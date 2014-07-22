<?php


App::import('Vendor','funciones');

App::import('Utility','Utilities');
App::import('controller', 'BaseCandidato');

class EvaluacionesController extends BaseCandidatoController {
  public $name = 'Evaluaciones';
  public $components = array('Cookie','Session','Notificaciones');
  public $helpers=array('Session','Time' => array('className' => 'Tiempito','engine' => 'Tiempito'));

  public $uses = array("EvaCan","Evaluacion","EvaCanRes");

  /**
    * Método que se ejecuta antes de cualquier acción.
    */
  public function beforeFilter() {
    parent::beforeFilter();

      $this->Cookie->name = 'cookie_ne';
      $this->Cookie->time = 3600 *24;  // or '1 hour'
      $this->Cookie->path = '/cookie_ne/';
      $this->Cookie->domain = 'nuestroemplo.com.mx';
      $this->Cookie->secure = true;  // i.e. only sent if using secure HTTPS
      $this->Cookie->key = 'qSI232qs*&sXOw!adre@34SAv!@*(XSL#$%)asGb$@11~_+!@#HKis~#^';
      $this->Cookie->httpOnly = true;

    if (!empty($this->params['prefix']) && ($this->params['prefix'] == 'admin')) {
      $this->layout = 'admin/home';
    }
    /**
      * Acciones que no necesitan autenticación.
      */
    $allowActions = array();

    $this->Auth->allow($allowActions);
  }

/*
  funcion para agregar


 */

  public function agregar_tiempo($id,$tipo,$tiempo,$opciones=array()){
       $evaluaciones= $this->Session->read("evaluaciones.$id");
       if(!$evaluaciones){
          $inicio=time()*1000;
          $fecha_inicio=date("Y-m-d H:i:s");
          $this->Session->write("evaluaciones.$id",compact("tipo","inicio","tiempo","opciones","fecha_inicio"));
          return $tiempo;
       }
       else {
           return $evaluaciones['tiempo'];
       }
  }


  public function modifica_tiempo($id,$tiempo){

      $evaluaciones= $this->Session->read("evaluaciones.$id");
       if($evaluaciones){
          $this->Session->write("evaluaciones.$id.tiempo",$tiempo);
       }
  }

  public function remover_tiempo($id){
        $this->Session->delete("evaluaciones.$id");
  }


  public function checar_tiempo($id){
    return $this->Session->check("evaluaciones.$id");
  }


  public function calcular_tiempo($preguntas){
      $result=0;
      foreach ($preguntas as $value) {
          $result+=$value['pregunta_tiempo'];

      }
      return $result;

  }
  public function index() {
    $this->request->data =ClassRegistry::init("Candidato")->find("basic_info",array("idUser"=>$this->user['candidato_cve']  ))[0];

  }

  public function evaluaciones(){
        $this->EvaCan->checarPruebaPsy( $this->user['candidato_cve']);
        $evaluaciones=$this->EvaCan->find("data",array(
                                          'user' => $this->user['candidato_cve']
                                          ));
      $this->set(compact("evaluaciones"));


  }


/**
 *
 *
 */

  public function aplicar($id=null ){   
    $idUser=$this->user['candidato_cve'];
     ClassRegistry::init("Notificacion")->syn_leido($id,"evaluacion");
    $eva= $this->EvaCan->read(null,$id );

    if(empty($eva)){
        $this->error("evaluacion no existe");
        $this->redirect("index");
        return ;
    }
    $eva=$eva['EvaCan'];

    if($eva['candidato_cve'] != $idUser ){
          $this->error("esta evaluación no existe");
          $this->redirect("index");
          return ;
      }

    if(  $eva['evaluacion_status'] != 0  ){
        $this->error("la evaluacion finalizo o fue cancelada");
        $this->redirect("index");
        return ;
    }

    $idEva=$eva['evaluacion_cve'];

    $evaluacion= $this->Evaluacion->find("evaluacion",array(
                                                              "id"=>$idEva,
                                                              "idUser" => $idUser
                                                          )
                                                      );


    $time=$evaluacion['Evaluacion']['evaluacion_time'];
    $tipo_evaluacion=  !$time ? 'N' : ($time > 0 ? 'S' : 'P' ) ;
    $tiempo=array();
    $flag_start="false";
    if($tipo_evaluacion != 'N' ){
      $time= $tipo_evaluacion == 'S' ? $evaluacion['Evaluacion']['evaluacion_time']: $this->calcular_tiempo($evaluacion['Preguntas']);

      $time=$time*1000*60;
      $evaluacion['Preguntas']=array();
      if($this->checar_tiempo($idEva)){
          $inicio=$this->Session->read("evaluaciones.$idEva.inicio");

          $now=time()*1000;
          $time= $time  -($now-$inicio);
          $flag_start="true";
      }

      $seg= $time/1000 ;
      $min=floor($seg/60);
      $seg%=60;
      $tiempo=compact("min","seg","time");


    }
    $this->set(compact("evaluacion","id","tipo_evaluacion","tiempo","flag_start"));



  }



  public function evaluacion_completa($id=null){

    if($id==null){
        $this->statusCode(300);
        $this->error("id de evaluación no es valido");
        return;

    }
    $options=array(
                  "idUser" => $this->user['candidato_cve'],
                  "id"=>$id
                  );
     $evaluacion= $this->Evaluacion->find("evaluacion",$options);
     $total_preguntas=count($evaluacion['Preguntas']);


    $time=$evaluacion['Evaluacion']['evaluacion_time']* 1000*60 ;
    $tipo_evaluacion=  !$time ? 'N' : ($time > 0 ? 'S' : 'P'  );
     if($this->checar_tiempo($id)){
          $inicio=$this->Session->read("evaluaciones.$id.inicio");
          if($tipo_evaluacion=='S'){
             $now=time()*1000;
             $time= $time  -($now-$inicio);
          }
          else{
            $time=-1;
          }

      }
      else{
          $opciones= $tipo_evaluacion=='P'? $evaluacion['Preguntas']:array();
        $this->agregar_tiempo($id,$tipo_evaluacion,$time,$opciones);
      }


       if ($tipo_evaluacion=='P'){
          $param = $this->gestion_pregunta($evaluacion,$id);
          $time=$param['time'];
          $question_solve=$param['question_solve'];
        }

    $this->set(compact("evaluacion","time","tipo_evaluacion","question_solve","total_preguntas"));


  }


  private function eliminar_pregunta($id){
      $preguntas= $this->Session->read("evaluaciones.$id.opciones");
        $numPreg=count($preguntas);
        if($numPreg ==0){
          return ;
        }
        $idpregunta=$this->request->query['idPreg'];

        $index=-1;
        foreach ($preguntas as $index_ => $pregunta) {
            if( $pregunta['pregunta_cve']==$idpregunta){
                  $index=$index_;
                  break;
            }
        }
        if($index>-1){
          $this->Session->write("evaluaciones.$id.inicio",time()*1000 );
          unset($preguntas[$index]);
        }
        $this->Session->write("evaluaciones.$id.opciones",$preguntas);

  }
  private function gestion_pregunta(&$evaluacion=array(),$id=null,$opcion='normal' ){


      if($opcion=='cambiar'){
        $this->eliminar_pregunta($id);

      }

      $preguntas=$this->Session->read("evaluaciones.$id.opciones");
      $inicio=$this->Session->read("evaluaciones.$id.inicio");
      $tiempoTotal=$this->calcular_tiempo($preguntas)*1000*60;
      $now=time()*1000;
      $where= $now-$inicio;
      $idPreg=null;
      $acum_time=0;
      $time=0;
      foreach ($preguntas as $pregunta) {
            $pregunta_tiempo=$pregunta['pregunta_tiempo']*1000*60;
            if($where  >= $acum_time &&  $where <= $acum_time+$pregunta_tiempo ){
              $idPreg=$pregunta['pregunta_cve'];
              $time=$pregunta_tiempo;
              break;
            }
            $acum_time+= $pregunta_tiempo;
      }

      $time= $time -( $where - $acum_time );
      if($idPreg){

            $newEva=array();
            $newEva['Evaluacion']=$evaluacion['Evaluacion'];
            $preguntas=$evaluacion['Preguntas'];
            if($opcion=='normal'){

                foreach ($preguntas as  $key=>$pregunta) {
                     $newEva['Preguntas'][]=   $pregunta;
                      if($pregunta['pregunta_cve'] ===$idPreg){
                        break;
                      }
                }


            }
            else if($opcion=='cambiar'){
                foreach ($preguntas as  $key=>$pregunta) {
                      if($pregunta['pregunta_cve'] ===$idPreg){
                        $newEva['Preguntas'][]=   $pregunta;
                        break;
                      }
                }

            }
           $evaluacion=$newEva;

        }
        $question_solve=count($this->Session->read("evaluaciones.$id.opciones"));
        return compact("time","question_solve");

  }
  public function cambiar_pregunta($id=null){
      if($id==null){
        $this->statusCode(300);
        $this->error("id de evaluación no es valido");
        return;

    }
    $options=array(
                  "idUser" => $this->user['candidato_cve'],
                  "id"=>$id
                  );
    $evaluacion= $this->Evaluacion->find("evaluacion",$options);
    $time=$evaluacion['Evaluacion']['evaluacion_time'];
    $tipo_evaluacion=  !$time ? 'N' : ($time > 0 ? 'S' : 'P'  );
    $param=$this->gestion_pregunta($evaluacion,$id,'cambiar');
    $time=$param['time'];
    $question_solve=$param['question_solve'];
    $this->set(compact("evaluacion","time","tipo_evaluacion","question_solve"));

    $this->render("evaluacion_completa");

  }



  public function guardar_preguntas(){
    $data=$this->request->data;
    $this->Session->write('App.prueba', date('Y-m-d H:i:s'));
    if(empty($data) ){
      $this->response->statusCode(300);
      $this->error("Error al tratar de guardar información: petición vacía");
      return false;
    }
    $id= $data['Evaluacion']['id'];
    $user=$this->user;

    // if(isset($data['time'])){
    //     $this->modifica_tiempo($id,$data['time']);
    // }

    $this->EvaCanRes->deleteAll(array(
                                          "candidato_cve" => $user['candidato_cve'],
                                          "evaluacion_cve" => $id
      ) );

    foreach ($data['Pregunta'] as $value) {
      $opciones= json_decode($value['opciones']);
      $pregunta_cve=$value['pregunta_cve'];
      foreach ($opciones as $opcion) {
        $this->EvaCanRes->id=null;
        $flag_save=  $this->EvaCanRes->save(
          array(
            "evaluacion_cve" => $id,
            "candidato_cve" =>  $user['candidato_cve'],
            "pregunta_cve" => $pregunta_cve,
            "opcpre_cve" =>   $opcion

            )

          );

        if(!$flag_save) {
          $this->response->statusCode(300);
          $this->error("Error al tratar de guardar información: verifique la respuesta");
          return false;
        }


      }

    }
    return true;
  }


  public function guardar() {
    $data = $this->request->data;
    if (empty($data)) {
      $this->response->statusCode(300);
      $this->error("Error al tratar de guardar información: petición vacía");
      return false;
    }

    if (!$this->guardar_preguntas()) {
      return false;
    }
    $id = $data['Evaluacion']['id'];
    $idEva = $data['EvaCan']['id'];
    $this->EvaCan->id = $idEva;
    $this->EvaCan->tipo_eva = $id;
    $this->EvaCan->saveField('evaluacion_status', 1);
    $this->remover_tiempo($id);
  }


  /*
  http://imx.obail.net?q=profile&h=disc&s=igntr&r=11001000008&f=GERALDO&l=…%253A%252F%252Fwww.igenter.net%252Fcolabs%252Fjsp%252FsrvlTermEva.jsp&i=es


  */

  public function evaluacion_disc($id=null){

    if($id==null ){
       throw new NotFoundException("La página que buscas no existe.");
    }

     $status=$this->EvaCan->status($id);

  if($status===false ){
       throw new NotFoundException("La página que buscas no existe.");
    }
    $this->set(compact("id","status"));

  }

  public function evaluacion_disc_gracias($id=null){

    if($id==null){
       throw new NotFoundException("La página que buscas no existe.");
    }
    $status=$this->EvaCan->status($id);

    if($status===false ){
       throw new NotFoundException("La página que buscas no existe.");
    }
    //verificamos si la evaluacion termino con exito
    if($status == 0 ){
      $this->EvaCan->tipo_eva="2";
      $this->EvaCan->finalizado=true;
      $this->EvaCan->idCandidato=$this->user['candidato_cve'];
      $this->EvaCan->cambiaStatus($id,1);
    }


     $this->layout="candidato/iframe";
  }

    public function evaluacion_mantenimiento($id=null){

     $this->layout="candidato/iframe";
  }


  public function evaluacion_disc_resultados($id=null){
    if($id==null){
       throw new NotFoundException("La página que buscas no existe.");
    }
     $status=$this->EvaCan->status($id);

    if($status===false ){
       throw new NotFoundException("La página que buscas no existe.");
    }
    $this->loadModel('Candidato');
    $candidato=$this->Candidato->find("basic_info",array(
      "idUser" =>$this->Auth->user('candidato_cve')
    ))[0];
    $this->set(compact("candidato"));
    // $this->layout="candidato/iframe";
  }


}