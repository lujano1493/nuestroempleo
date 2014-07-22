<?php
class MicroSitio extends AppModel {

  public $name = 'MicroSitio';

  public $useTable = 'tmicrositio';

  public $primaryKey = 'cia_cve';

  public $actsAs = array('Containable');

  public $findMethods = array(
    'clientes' => true
  );

  public $belongsTo = array(
    'Empresa'=> array(
      'className'    => 'Empresa',
      'foreignKey'   => "cia_cve"
    )
  );

  public function __construct($id = false, $table = null, $ds = null) {
    parent::__construct($id, $table, $ds);

    $this->field_extract_info = array(
      "$this->alias.conoc_descrip"
    );
  }
  protected function _findClientes($state, $query, $results = array()) {
      $isId_Cliente= isset($query['idCliente']) && !empty($query['idCliente']);
    if ($state === 'before') {

      $query['conditions'] =array("$this->alias.status" => 1);
      if( $isId_Cliente ){
          $query['conditions'] ["$this->alias.cia_id"]=$query['idCliente'];
      }  
      $this->add_fields($query);

      if( $isId_Cliente ){
        $query['fields'][] = "$this->alias.cia_descrip {$this->alias}__descrip";
      }
      return $query;
    }
    return    $isId_Cliente && !empty($results) ?   $results[0] :$results;
  }



  private function add_fields(&$query){
    $query['fields'] = array(
      "$this->alias.cia_cve",
      "Empresa.cia_nombre  {$this->alias}__name_full",
      "$this->alias.cia_id {$this->alias}__name",
      "$this->alias.cia_style {$this->alias}__src_css",
      "$this->alias.cia_url {$this->alias}__url_site"
    );
  }

  public function afterFind($results, $primary = false) {
    if (empty($results)) {
      return $results;
    }

    foreach ($results as $key => $value) {
      if (!empty($value[$this->alias]['cia_cve'])) {
        $cia_cve = $value[$this->alias]['cia_cve'];
        $results[$key][$this->alias]['src_img'] = $this->Empresa->getLogoPath($cia_cve);
      }
    }

    return $results;
  }

  public function saveOrUpdate($empresaId, $fields = array(), $attemps = 1) {
    $fields[$this->primaryKey] = $empresaId;

    if ($this->exists($empresaId)) {
      $this->id = $empresaId;
    } else {
      $nombre = $this->getCompanyID($empresaId);

      $this->create();
      $fields['cia_url'] = '/clientes/' . $nombre;
      $fields['cia_style'] = 'clientes/' . $nombre . '.css';
      $fields['cia_id'] = $nombre;
    }

    return $this->save($fields);
  }

  /**
   * Obtiene el nombre de la compañia, buscando en la BD recursivamente.
   * Esto se hace por que el nombre se genera automáticamente.
   * @param  [type]  $id      [description]
   * @param  integer $attempt [description]
   * @return [type]           [description]
   */
  public function getCompanyID($idOrName, $attempt = 1) {
    $nombre = null;

    if (is_numeric($idOrName)) {
      $this->Empresa->id = $idOrName;
      $nombre = Inflector::slug($this->Empresa->field('cia_nombre'), '_');
    } else {
      $nombre = $idOrName;
    }

    $nombre = strtolower($nombre);
    if ($this->hasAny(array(
      $this->alias . '.' . 'cia_id' => $nombre . ($attempt === 1 ? '' : $attempt)
    ))) {
      return $this->getCompanyID($nombre, $attempt + 1);
    }

    return $nombre . ($attempt === 1 ? '' : $attempt);
  }
}