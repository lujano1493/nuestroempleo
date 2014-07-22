<?php 
class ContactoEmpresa extends AppModel {
	public $name='ContactoEmpresa';
	public $useTable = 'tcontactoempresa'; 
	public $primaryKey="contacto_cve";



	
  /**
    * Métodos de búsqueda personalizados.
    */
  public $virtualFields = array();

public $belongsTo = array(    
    'CodigoPostal'=> array(
      'className'    => 'CodigoPostal',
      'foreignKey'   => "cp_cve"
      )
    );



public $validate = array(

  'contacto_nombre' => array(
        'required'=>  array(
         'rule' => 'notEmpty',
         'required' => true,
        'message'    => 'Ingresa nombre(s).'
      )      
    ),
    'contacto_apellidos' => array(
        'required'=>  array(
         'rule' => 'notEmpty',
         'required' => true,
        'message'    => 'Ingresa apellidos.'
      )      
    ),
    'contacto_empresa' => array(
        'required'=>  array(
         'rule' => 'notEmpty',
         'required' => true,
        'message'    => 'Ingresa nombre de la empresa.'
        )
      ),
    'contacto_telefono' => array(
        'required'=>  array(
                 'rule' => 'notEmpty',
                 'required' => true,
                'message'    => 'Ingresa teléfono.'
      ),
        'digits'=>array(
                'rule'=> '/[0-9]+/i',
                'message' => 'Formato de teléfono erroneo.'

          )

    ),
    'contacto_lada' => array(
        'required'=>  array(
                 'rule' => 'notEmpty',
                 'required' => true,
                'message'    => 'Ingresa lada.'
      ),
        'digits'=>array(
                'rule'=> '/[0-9]+/i',
                'message' => 'Formato de lada erroneo'

          )

    ),

    'contacto_email' => array(
        'required'=>  array(
         'rule' => 'notEmpty',
         'required' => true,
        'message'    => 'Ingresa correo electrónico.'
        ),
        'email' => array(
                        'rule'       => array('email', true), // or: array('ruleName', 'param1', 'param2' ...)
                        'message' => 'Formato de correo electrónico no válido.'
                    )
    ),
    'contacto_mensaje' => array(
        'required'=>  array(
         'rule' => 'notEmpty',
         'required' => true,
        'message'    => 'Ingresa mensaje.'
        )
      ),

    'medio_cve' => array(
        'required'=>  array(
         'rule' => 'notEmpty',
         'required' => true,
        'message'    => 'Selecciona opción.'
        )
      )
  
  );





 public $findMethods = array(
    'contacto'    => true
  );


 
 protected function _findContacto($state, $query, $results = array()) {
    if ($state == 'before') {    
    $query['conditions']=array( "$this->alias.$this->primaryKey" => $this->id   );    


    $query['joins']= array(
                              array(
                                      "table" => "tcatalogo",
                                      "alias" => "Catalogo",
                                      "type" => "LEFT",
                                      "fields" => array(  ),
                                      "conditions" => array( 
                                                              "$this->alias.medio_cve=Catalogo.opcion_valor",
                                                              "Catalogo.ref_opcgpo='MEDIO_CVE'" 
                                                            )
                                ),

                              array(
                                       "table" => "tcodigopostal",
                                      "alias" => "Cdi",
                                      "type" => "LEFT",
                                      "fields" => array(  ),
                                      "conditions" => array( 
                                                              "Cdi.cp_cve=$this->alias.cp_cve",
                                                            )
                                ),
                              array(
                                       "table" => "tpais",
                                      "alias" => "Pais",
                                      "type" => "LEFT",
                                      "fields" => array(  ),
                                      "conditions" => array( 
                                                              "Cdi.pais_cve=Pais.pais_cve",
                                                            )
                                ),
                                 array(
                                       "table" => "testado",
                                      "alias" => "Estado",
                                      "type" => "LEFT",
                                      "fields" => array(  ),
                                      "conditions" => array( 
                                                              "Cdi.est_cve=Estado.est_cve",
                                                            )
                                ),
                                  array(
                                       "table" => "tciudad",
                                      "alias" => "Ciudad",
                                      "type" => "LEFT",
                                      "fields" => array(  ),
                                      "conditions" => array( 
                                                              "Cdi.ciudad_cve=Ciudad.ciudad_cve",
                                                            )
                                )

        );   

    $query['fields']=array(

                  " $this->alias.contacto_nombre ||' '||$this->alias.contacto_apellidos  Contacto__nombre",
                  "$this->alias.contacto_lada ||' '|| $this->alias.contacto_telefono|| ' ext: ' ||$this->alias.contacto_ext Contacto__telefono",
                  "$this->alias.contacto_email  Contacto__correo",
                  "$this->alias.contacto_empresa  Contacto__empresa",
                  "Catalogo.opcion_texto  Contacto__medio ",
                  "$this->alias.contacto_mensaje Contacto__comentario",
                  "Cdi.cp_asentamiento   Contacto__colonia" ,
                  "Cdi.cp_cp   Contacto__cp" ,
                  "Ciudad.ciudad_nom   Contacto__ciudad" ,       
                  "Estado.est_nom   Contacto__estado" ,                                                 
                  "Pais.pais_nom  Contacto__pais" 

      ) ;
      return $query;
    }
    return  (empty($results)) ? $results :$results[0]   ;
  }





  public function validateOtros($field){
          $value=$this->data[$this->alias]['contacto_tipo'];
          $otros_value=$this->data[$this->alias]['contacto_otro'];
          if($value!="4"){
              return true;
          }        
          return  !empty($otros_value) ;

  }


  public function guardar($data=array()){
      $this->create();
      $rs= $this->save($data);
      return  $rs!==false? $this->find("contacto"): $rs   ;
  }

  public function __construct($id = false, $table = null, $ds = null) {
    parent::__construct($id, $table, $ds);
    $this->virtualFields=
            array(
                  "telefono"=> " $this->alias.contacto_lada ||' '|| $this->alias.contacto_tel|| ' ' ||$this->alias.contacto_ext"

      );
    $this->fields= array(
                        'contacto_cve',
                        'contacto_nom',
                        'contacto_apellidos',
                        'contacto_lada',
                        'contacto_tel',
                        'contacto_ext',
                        'contacto_email',
                        'cp_cve',

      );

                
  }


  

}