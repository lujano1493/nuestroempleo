<?php
class RefCanEnc extends AppModel {
  public $name='RefCanEnc';
  public $useTable = 'tencuestaref';
  public $primaryKey="encuestaref_cve";


  public $belongsTo = array(
    'EvalPreg'=> array(
      'className'    => 'EvalPreg',
      'foreignKey'   => "pregunta_cve",
      'conditions' => array ('EvalPreg.evaluacion_cve' =>'1' )
    )
  );


   public $findMethods = array(
      'RefEnc'    => true
    );


  protected function _findRefEnc($state, $query, $results = array()) {
    if ($state == 'before') {

      $query['fields'] = array(
                              "$this->alias.encuestaref_cve",
                              "$this->alias.pregunta_cve",
                              "$this->alias.respuesta_cve"
        );




      $query['conditions']=array(
                                      "$this->alias.refcan_cve" => $query['idRef'],
                                      "$this->alias.evaluacion_cve"=> $this->checar_relacion($query["refrel"])
          );
      $query['order'] = array(
                                "$this->alias.pregunta_cve ASC",

                             );
      return $query;
    }

    return $results;
  }


  public function crearEncuesta($idUser,$refcan){


        $encuesta=$this->cargarEncuesta($refcan['refrel_cve']);
          $this->begin();
          $conditions=array(
                            "refcan_cve"=> $refcan['refcan_cve']
                            );
          $this->deleteAll($conditions,true,true );

          $idEva=$this->checar_relacion($refcan['refrel_cve']);

          foreach ($encuesta as $value) {
             $data_encref= array( "candidato_cve"=>$idUser,
                                  "refcan_cve"=>$refcan['refcan_cve'],
                                  "evaluacion_cve"=> $idEva,
                                  'pregunta_cve' => $value['EvalPreg']['pregunta_cve']
                                 );
             $this->create();
            if(!$this->save($data_encref)){
                $this->rollback();
                return array("error","No fue posible guardar encuesta de referencia");
            }


          }

          return array("ok","nueva encuesta creada");
  }


  public function cargarEncuesta($refrel_cve=null){

      $id_eva=$this->checar_relacion($refrel_cve);
      return $this->EvalPreg-> find("encuesta",array("idEva" => $id_eva ) );

  }


  private function checar_relacion($refrel_cve=null){



        /*refrel_cve
                      1 amigo
                      2 vecino
                      3 Familiar
                      4 Compañero
                      5 Jefe /super visor
                      6 Subordinado


            evaluaciones_cve
                      3 encuesta para referencias personales
                      4 encuesta para  compañeros laboral
                      5 encuesta para jefes
                      6 encuesta para subordinados
          */

    if(!$refrel_cve){
      return null;
    }

    return  $refrel_cve >= 1 &&  $refrel_cve  <= 3  ? "3" :
                  ($refrel_cve == 4  ?  "4" :
                  ($refrel_cve == 5  ?  "5"  : "6")) ;


  }

  public function guardar($data=array()){
      $this->begin();

      foreach ($data[$this->alias] as $key => $value) {
            $this->id=$value[$this->primaryKey];
            if(!$this->save($value)){
                $this->rollback();
                  return array("error","no se pudo guardar datos de encuesta",$this->validationErrors );

            }

      }
      $refcan=ClassRegistry::init("RefCan");
      $refcan->id=$data['refcan_cve'];
      $refcan->Behaviors->unload('GraficaCan');
      if($refcan->saveField("refencuesta_status",'S')===false ){
          return array("error","No se pudo actualizar campo de status");
      }
     ClassRegistry::init("Ticket")->deleteTicket($data['ticket']);
     $this->commit();
     return array("ok","Los datos de la encuesta fueron guardados con éxito");




  }






}