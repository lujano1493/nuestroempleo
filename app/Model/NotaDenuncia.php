<?php

App::uses('AppModel', 'Model');

class NotaDenuncia extends AppModel {
  
  /**
   * Utiliza el comportamiento: Containable
   * @var array
   */
  public $actsAs = array('Containable');

  /**
   * tabla
   * @var string
   */
  public $useTable = 'tanotacionxdenuncia';

  /**
   * Llave primaria
   * @var string
   */
  public $primaryKey = 'anotacion_cve';

  public $belongsTo = array(
   
  );

  /**
   * Validaciones.
   * @var array
   */
  public $validate = array(
    'anotacion_detalles' => array(
      'required' => array(
        'rule' => 'notEmpty',
        'required' => true,
        'message' => 'Ingresa los detalles.'
      ),
      'maxlength' => array(
        'rule' => array('maxLength', 512),
        'message' => 'El máximo de caracteres es 4000.'
      )
    ),
  );
  public $tipo=array("candidato" => 1 ,"oferta" => 0);


  public $findMethods = array(    
    'notas' => true
  );

/**
 * guardar anotaciones de una denuncia
 * @param  [type] $data datos a guardar de la denuncia
 * @return [type]       [description]
 */
  public function guardar($data){
      $data=$data['Nota'];
      if(isset($data['clave'])   ){
          $this->id=$data['clave'];
    
      }
      else{
        $this->create();        
      }    
      $data=array(
        $this->alias=> array(
          "anotacion_tipo" =>  $this->tipo[$data["tipo"]],
          "anotacion_detalles" =>$data['detalles'],
          "anotacion_id" => $data["id"]
        )
        );
      return $this->save($data);

  }
  protected function _findNotas($state, $query, $results = array()) {
    if ($state == 'before') {
      $query["conditions"]=array(
        "$this->alias.anotacion_id" => $query['id'],
        "$this->alias.anotacion_tipo" => $this->tipo[$query['tipo']]
        );  
      return $query;
    }

    return $results;
  }




}