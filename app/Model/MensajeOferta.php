<?php

App::uses('AppModel', 'Model');
class MensajeOferta extends AppModel {
  public $actsAs = array('Containable');
  public $name="MensajeOferta";
  public $useTable = 'tmsjsxoferta';
  public $primaryKey = 'msjxoferta_cve';


  public $belongsTo=array(
         'Mensaje' => array(
              'className' => 'Mensaje',
              'foreignKey' => "msj_cve" ,
              'type' => 'INNER'
            ),
         'Enviado' => array(
              'className' => 'MensajeUsuario',
              'foreignKey' => "msj_cve",
              'type' => 'INNER'
            ),
         'Oferta' =>array(
              'className' => 'Oferta',
              'foreignKey' => "oferta_cve",
              'type' => 'INNER'
            )
    );  



public $option_join=array(
  'Mensaje' => array(
                          'fields' => array(
                                                'msj_cve',
                                                'msj_texto',
                                                'emisor_tipo',
                                                'emisor_cve',
                                                'created'

                            )              


  ));

 public $findMethods = array(
                                'comentarios' => true
                          );
/*
  para esta onsulta traeremos todos los comentarios publicos y que el candidato haya hecho en una determinada oferta

 */
  protected function  _findComentarios($state, $query, $results = array()) {
    if ($state === 'before') {
      $query['public'] = !isset($query['public']) ? true : $query['public'];


      $query['contain']= array(
                              'Mensaje'=>$this->option_join['Mensaje']                 
                               /* ,
                                'Enviado' => array(
                                                      'fields' => array(

                                                                              'msj_cve',
                                                                              'receptor_cve',
                                                                              'receptor_tipo'
                                                        )

                                  )*/

        ); 
        if( isset($query['idOferta'])){
           $query['conditions'][]= array(
            "$this->alias.oferta_cve" => $query['idOferta']
            ) ;
      }    
      $query['conditions']['OR'][] =  array(
        "$this->alias.msjxoferta_public"=> "S"
      );   
      if(isset($query['idUser'])){

         $query['conditions']['OR'][]=array(
                array('Mensaje.emisor_tipo'=>1),
                array("Mensaje.emisor_cve"=> $query['idUser'])
          );

      }



        $query['contain'] =array(
              "Oferta" => array(
                      "fields" => array(
                            "oferta_cve","cu_cve","cia_cve","oferta_privada"
                        )
                ),"Mensaje"=> array(
                      "fields"=> array(
                              "msj_cve",
                              "msj_texto",
                              "msj_asunto",
                              "tipomsj_cve",
                              "emisor_cve",
                              "emisor_tipo",
                              "created"

                        )
                )
          );

      $query['connect'] =array(
        'by' => "PRIOR $this->alias.msj_cve =$this->alias.msj_cvesup",
        'start with' => "$this->alias.msj_cvesup is null",

        );
      $query['fields']=array("msjxoferta_cve","msj_cve","msj_cvesup","msjxoferta_public");
      $query['order'] =array(
                              "$this->alias.created ASC"
        );
      return $query;
    }
    return $results;
  }
  public function guardar($data=array()){

    $oferta_cve=$data['idOferta'];
    $msjxoferta_public= $data['is_public'] ? 'S':'N';
    $emisor_cve=$data['idUser'];
    $emisor_tipo=$data['typeUser'];
    $msj_texto=$data['mensaje'];
    $msj_status=0;
    $tipo=1;
    $oferta=$this->Oferta->find("first",array(
                                    "fields" => array("cu_cve"),
                                    'contain'=> false,
                                    "conditions" => compact("oferta_cve") ));


    ;
    if(empty($oferta)){
        return false;
    }

    $receptor_cve=$oferta['Oferta']['cu_cve'];
    $receptor_tipo=0;
    $msj_leido=0;
    $msj_asunto="Pregunta de Oferta";
    $msj_importante=0;
    $this->Mensaje->recursive=-1;
    $this->Mensaje->create();
    $superior=null;
    $save_mensaje= compact( 
                            "tipo",
                            "superior",
                            "emisor_cve",
                            "emisor_tipo",
                            "msj_asunto",
                            "msj_importante",
                            "msj_texto",
                            "msj_status",
                            "oferta_cve"
                            );
    $save_mensaje['receptores']=json_encode(array( (int) $receptor_cve ));    
    $save_mensaje=array(
        "Mensaje"=> $save_mensaje
      );
    $status=$this->Mensaje->saveMensaje( $save_mensaje);
    $msj_cve=$this->Mensaje->id;   
    $this->contain(
              array(
                      'Mensaje'=>$this->option_join['Mensaje']                                       
                )
      );
    return $this->find("first",array(
      "conditions" => array(
        "$this->alias.msj_cve" => $msj_cve
      )));
  }




}