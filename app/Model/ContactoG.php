<?php 
class ContactoG extends AppModel {
	public $name='ContactoG';
	public $useTable = 'tcontactogeneral'; 
	public $primaryKey="contactog_cve";
  public $actsAs = array('Containable');



	
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
    'contactog_nom' => array(
        'required'=>  array(
         'rule' => 'notEmpty',
         'required' => true,
        'message'    => 'Ingresa nombre(s).'
      )      
    ), 
    'contactog_tel' => array(
        'required'=>  array(
                 'rule' => 'notEmpty',
                 'required' => true,
                'message'    => 'Ingresa teléfono.'
      ),
        'digits'=>array(
                'rule'=> '/[0-9]+/i',
                'message' => 'Formato de teléfono erroneo'

          )

    ),
    'contactog_lada' => array(
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

    'contactog_email' => array(
        'required'=>  array(
         'rule' => 'notEmpty',
         'required' => true,
        'message'    => 'Ingresa teléfono.'
        ),
        'email' => array(
                        'rule'       => array('email', true), // or: array('ruleName', 'param1', 'param2' ...)
                        'message' => 'Formato de correo electrónico no válido.'
                    )
    ),


    'contactog_comentario' => array(
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
        'message'    => 'Selecciona forma.'
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

                  "$this->alias.contactog_nom ||' ' || $this->alias.contactog_apellidos  Contacto__nombre",
                  "$this->alias.contactog_lada ||' '|| $this->alias.contactog_tel|| ' Ext: ' ||$this->alias.contactog_ext Contacto__telefono",
                  "$this->alias.contactog_email  Contacto__correo",
                  "Catalogo.opcion_texto  Contacto__medio ",
                  "$this->alias.contactog_comentario Contacto__comentario",
                  "CodigoPostal.cp_asentamiento   Contacto__colonia" ,
                  "CodigoPostal.cp_cp   Contacto__cp" ,
                  "Ciudad.ciudad_nom   Contacto__ciudad" ,       
                  "Estado.est_nom   Contacto__estado" ,                                                 
                  "Pais.pais_nom  Contacto__pais" 

      ) ;
      return $query;
    }
    return  (empty($results)) ? $results :$results[0]   ;
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
                  "telefono"=> " $this->alias.contactog_lada ||' '|| $this->alias.contactog_tel|| ' ' ||$this->alias.contactog_ext"

      );

    $this->fields= array(
                        'contactog_cve',
                        'contactog_nom',
                        'contactog_apellidos',
                        'contactog_lada',
                        'contactog_tel',
                        'contactog_ext',
                        'contactog_email',
                        'cp_cve',

      );

                
  }


  

}