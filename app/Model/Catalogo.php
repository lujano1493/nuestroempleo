<?php

App::uses('AppModel', 'Model');

class Catalogo extends AppModel {

  /**
    * Nombre del Modelo
    */
	public $name = 'Catalogo';

  /**
    * Nombre de la llave primaria, en este caso es multiple, tabla tcatalogos.
    */
  public $primaryKey = false;

  /**
	 	* Tabla.
	 	*/
	public $useTable = 'tcatalogo';

  /**
   * Genera la lista de Giros.
   * @return [type] [description]
   */
  private function giros() {
    $results = $this->query('SELECT giro_cve as id, giro_nom as name FROM tgiros ORDER BY giro_nom ASC');
    $results = Hash::extract($results, '{n}.{n}');

    return $results;
  }

  /**
   * Genera lista de membresias
   * @return [type] [description]
   */
  private function membresias() {
    $results = $this->query('SELECT
      membresia_cve,
      membresia_nom
      FROM tmembresias
      WHERE membresia_clase = \'mbs\' AND membresia_tipo = \'P\' AND membresia_status = 1
      ORDER BY membresia_cve ASC'
    );
    $results = Hash::combine($results, '{n}.{n}.membresia_cve', '{n}.{n}.membresia_nom');

    return $results;
  }

  /**
   * Genera la lista de sueldos.
   * @return [type] [description]
   */
  private function sueldos() {
    $results = $this->query('SELECT elsueldo_cve, elsueldo_ini FROM texplabsueldos ORDER BY elsueldo_cve ASC');
    $results = Hash::combine($results, '{n}.{n}.elsueldo_cve', '{n}.{n}.elsueldo_ini');
    return $results;
  }

  public function carreras($query = '') {
    $results = $this->query('SELECT
        Area.area_cve Area__id,
        Area.area_nom Area__name,
        Categoria.categoria_nom Area__categoria
      FROM tareas Area
      LEFT JOIN tcategorias Categoria ON (
        Area.categoria_cve = Categoria.categoria_cve
      )
      ORDER BY Area__categoria, Area.area_nom ASC');

    $results = Hash::extract($results, '{n}.Area');
    return $results;
  }

  public function getGroups() {
    $gpos = $this->find('all', array(
      'order' => array(
        'Catalogo.opcion_sec' => 'ASC'
      )
    ));

    return Hash::combine($gpos, '{n}.Catalogo.opcion_sec', '{n}.Catalogo', '{n}.Catalogo.ref_opcgpo');
  }

  /**
   * Obtiene la lista en base a grupo.
   * @param  [type] $gpo    [description]
   * @param  array  $fields [description]
   * @return [type]         [description]
   */
  public function lista($gpo = null, $fields = array()) {
    if ($gpo === 'giros') {
      return $this->giros();
    } elseif ($gpo === 'sueldos') {
      return $this->sueldos();
    } elseif ($gpo === 'membresias') {
      return $this->membresias();
    }

    $conditions = array();
    if (isset($gpo)) {
      $conditions = array('Catalogo.ref_opcgpo =' => strtoupper($gpo));
    }

    return $this->find('list', array(
      'fields' => !empty($fields) ? $fields : array('trim(Catalogo.opcion_valor)', 'Catalogo.opcion_texto'),
      'conditions' => $conditions,
      'order' => 'Catalogo.opcion_sec ASC',
      'recursive' => -1
    ));
  }

  /**
   * Obtiene el texto en base a un grupo y su valor.
   * @param  string $group [description]
   * @param  [type] $value [description]
   * @return [type]        [description]
   */
  public function getText($group = '', $value = null) {
    $lista = $this->lista($group);

    return $value ? $lista[$value] : $lista;
  }

  function getTipo_EmpleoList(){
    return $this->find("list", array(
      'fields' => array(
        "Catalogo.opcion_valor",
        "Catalogo.opcion_texto"
      ),
      'conditions' => array(
        "Catalogo.ref_opcgpo"=> "DISPONIBILIDAD_EMPLEO"
      ),
      'order'=> array(
        "Catalogo.opcion_sec ASC"
      )
    ));
  }

  function getAnioAreaExpCan(){
    return $this->find("list", array(
      'fields' => array(
        "Catalogo.opcion_valor",
        "Catalogo.opcion_texto" ),
      'conditions' => array(
        "Catalogo.ref_opcgpo"=> "ANIOSAREAEXPCAN"
      ),
      'order'=> array(
        "Catalogo.opcion_sec ASC"
      )
    ));
  }

  function get_list($ref_opcgpo='',$conditions=null ,$order='asc'){
    if($conditions) {
     $conditions["Catalogo.ref_opcgpo"] = $ref_opcgpo;
    } else {
      $conditions=array(
        "Catalogo.ref_opcgpo" => $ref_opcgpo
      );
    }
     if( strtolower ($order ) === 'asc'){
        $order=  array (
        "Catalogo.opcion_sec ASC"
      );
    }
    else{
         $order=  array (
        "Catalogo.opcion_sec DESC"
      );

    }
    return $this->find("list", array(
      'fields'=>array(
        "Catalogo.opcion_valor",
        "Catalogo.opcion_texto"
      ),
      'conditions'=>$conditions,
      'order'=> $order
    ));
  }

  public function get_list_candidato(){
    $edo_civil= $this->get_list("ESTADO_CIVIL",array("Catalogo.opcion_valor >"=> 0  ));
    $genero= $this->get_list("GENERO",array("Catalogo.opcion_valor !="=> "I" ));
    $ic_nivel=$this->get_list("IC_NIVEL");
    $tiempo_cve=$this->get_list("TIEMPO_CVE");
    $ec_nivel=$this->get_list("NIVEL_ESCOLAR",array("Catalogo.opcion_valor >"=> 0 ));
    $cursotipo_cve=$this->get_list("CURSOTIPO_CVE");
    $refrel_cve=$this->get_list("REFREL_CVE");
    $reftiempo_cve=$this->get_list("REFTIEMPO_CVE");
    $incapacidad_cve=$this->get_list("INCAPACIDAD_CVE");
    $tipo_movil=$this->get_list("TIPO_MOVIL");

    $siono=array("S"=>'S&iacute;',"N"=>"No");
    $area_int=$this->getList_Auto("tareas","area_cve","area_nom",array("field" =>"area_nom","order"=>"asc" ));
    $idiomas=$this->getList_Auto("tidioma","idioma_cve","idioma_nom",array("field" =>"idioma_nom","order"=>"asc" ));
    $tipo_empleo=$this->get_list("DISPONIBILIDAD_EMPLEO");

    $interes_cve=$this->get_list("INTERES_CVE");
    $habilidad_cve=$this->get_list("HABILIDAD_CVE");

    /* Sueldos*/
    $elsueldo_cve=ClassRegistry::init('ExpLabSue')->lista();
    $giro_cve=ClassRegistry::init('Giros')->lista();
    $list=compact('edo_civil','genero',"area_int","idiomas","ic_nivel","tiempo_cve","ec_nivel","cursotipo_cve",
      "siono","elsueldo_cve","giro_cve","tipo_empleo","refrel_cve","reftiempo_cve" ,
      "interes_cve","habilidad_cve","incapacidad_cve","tipo_movil");
    return $list;
  }


  /*catalogo necesario para registrar un candidato */
  public function get_list_candidato_registrar(){
    $edo_civil= $this->get_list("ESTADO_CIVIL",array("Catalogo.opcion_valor >"=> 0 ));
    $genero= $this->get_list("GENERO",array("Catalogo.opcion_valor !="=> "I" ));
    $siono=array("S"=>'S&iacute;',"N"=>"No");
    $list=compact('edo_civil','genero',"siono");
    return $list;
  }



  public function afterFind($results = array(), $primary = false) {
    return $results;
  }

}