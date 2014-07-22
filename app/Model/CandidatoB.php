<?php

App::import('Utility','Utilities');

class CandidatoB extends AppModel {
  public $name = 'CandidatoB';

  public $primaryKey = 'candidato_cve';

  public $useTable = 'tcandidatobusqueda';
  public $actsAs = array('Containable');

  public $knows = array(
    'Denuncia'
  );

  public $hasOne = array(
    'Atributos' => array(
      'className' => 'CandidatoEmpresaAtributos',
      'foreignKey' => 'candidato_cve'
    ),
    'Empresa' => array(
      'className' => 'EmpresasCandidatos',
      'foreignKey' => 'candidato_cve'
    ),
    'Cuenta' => array(
      'className' => 'CandidatoUsuario',
      'foreignKey' => 'candidato_cve',
      'fields' => array(
      )
    )
  );

  public $hasAndBelongsToMany = array(
    'Carpetas' => array(
      'className' => 'Carpeta',
      'with' => 'CarpetasCandidatos',
      'foreignKey' => 'candidato_cve',
      'associationForeignKey' => 'carpeta_cve',
      'unique' => false
    )
  );

  public $findMethods = array(
    'by_user'     => true,
    'by_user_folder'=> true,
    'favs' => true,
    'match' => true,
    'paginate' => true,
    'purchased' => true
  );

  private $template_query = array(
    'normal' =>
      '<query>
        <textquery lang="SPANISH" grammar="CONTEXT">  {  __expresion__ }
          <progression>
            <seq><rewrite>transform((TOKENS, "{", "}", " AND "))</rewrite></seq>
            <seq><rewrite>transform((TOKENS, "?{", "}", " AND "))</rewrite></seq>
          </progression>
        </textquery>
        <score datatype="FLOAT" algorithm="DEFAULT"/>
      </query>',
    'match' =>
      '<query>
        <textquery lang="SPANISH" grammar="CONTEXT">  {  __expresion__ }
          <progression>
            <seq><rewrite>transform((TOKENS, "{", "}", " ACCUM "))</rewrite></seq>
          </progression>
        </textquery>
        <score datatype="FLOAT" algorithm="DEFAULT"/>
      </query>'
  );

  private $result_agroup = array();
  private $count = array();

  public function __construct($id = false, $table = null, $ds = null) {
    parent::__construct($id, $table, $ds);
  }

  public function agregarCondiciones($params) {
    $conditions = array();
    $fields = array(
      'sueldo' => "$this->alias.explab_sueldod",
      'ciudad' => "$this->alias.ciudad_nom",
      'estado' => "$this->alias.est_nom",
      'area' =>  array(
        "$this->alias.areaexp1_nom",
        "$this->alias.areaexp2_nom",
        "$this->alias.areaexp3_nom"
      ),
      'edad' => "$this->alias.candidato_edad",
      'genero' => "$this->alias.candidato_genero",
      'categoria' =>  array(
        "$this->alias.categae1_nom",
        "$this->alias.categae2_nom",
        "$this->alias.categae3_nom"
      )
    );

    foreach ($params as $query => $data) {
      if (array_key_exists($query,$fields) !== false && !empty($data)) {
        if (is_array($fields[$query])) {
          foreach ($fields[$query] as $fields_ite) {
            $conditions['OR'][$fields_ite]= $data;
          }
        } else {
          if ($query === 'edad') {
            /*falta decodificar*/
            preg_match_all("/[0-9]+/", $data, $anios, PREG_PATTERN_ORDER);
            if (count($anios[0]) > 1) {
              $conditions['AND'][$fields[$query] . " >="] = $anios[0][0];
              $conditions['AND'][$fields[$query] . " <"] = $anios[0][1];
            }
            $data=false;
          }
          if ($data) {
            $conditions['AND'][$fields[$query]] = $data;
          }
        }
      }
    }
    return $conditions;
  }

  private function agrupando_($data = null, $name_model, $field) {
    if (!$data) {
      return;
    }
    $keyisita = "$name_model.$field:$data";

    if ($field === 'candidato_edad') {
      $data = intval($data);
      $o = $data % 5;
      $cota_menor = $data - $o;
      $cota_major = $cota_menor + 5;
      $data = "$cota_menor a $cota_major Años";
      $keyisita ="$name_model.$field:$data";
    }

    if (!array_key_exists($keyisita, $this->count)) {
      $this->count[$keyisita] = 1;
    } else {
      $this->count[$keyisita]++;
    }

    $this->result_agroup[$name_model][$field][$data] = $this->count[$keyisita];
  }


  private  function data_contar(&$set = arr, $path = null) {
    if(! Hash::check($set, $path) ){
      $set = Hash::insert($set, $path, 1);
    } else {
      $count = Hash::get($set, $path);
      $set = Hash::insert($set, $path, ++$count);
    }
  }

  public static function cmpcategoria($a, $b) {
    if ($a['count'] == $b['count']) {
      return 0;
    }

    return ($a['count'] > $b['count']) ? -1 : 1;
  }

  public function agrupar($query = array()) {
    $field_descar = array(
      'score'
    );

    $campos = array(
      'explab_sueldod',
      'candidato_genero',
      'candidato_edad',
      'ciudad_nom',
      'est_nom',
      'pais_nom',
      'areaexp1_nom',
      'areaexp2_nom',
      'areaexp3_nom',
      'categae1_nom',
      'categae2_nom',
      'categae3_nom'
    );

    $fields=array();

    foreach ($campos as $value) {
      $fields[]="$this->alias.$value";
    }

    $query['fields'] = $fields;
    $query['is_group'] = true;
    $rs = $this->find('paginate', $query)['data'];

    if (empty($rs)) {
      return array();
    }

    $_campos = array();
    foreach ($campos as $fields_) {
      $_campos[$fields_] = $fields_;
    }

    $_campos = array_merge($_campos, array(
      'areaexp1_nom' => 'areaexp_nom',
      'areaexp2_nom' => 'areaexp_nom',
      'areaexp3_nom' => 'areaexp_nom',
      'categae1_nom' => 'categoriaexp_nom',
      'categae2_nom' => 'categoriaexp_nom',
      'categae3_nom' => 'categoriaexp_nom'
    ));

    $gerarquias = array();
    $gerarquias['localidad'] = array();
    $gerarquias['categoria'] = array();

    foreach ($rs as  $data) {
      $info_ = $data[$this->alias];
      $this->data_contar($gerarquias['localidad'], str_replace(".", "_", $info_['est_nom']) . "." . str_replace(".", "_", $info_['ciudad_nom']));
      for($in_ = 1; $in_ <= 3; $in_++) {
        if (!$info_["categae{$in_}_nom"] || !$info_["areaexp{$in_}_nom"]) {
          continue;
        }
        $this->data_contar($gerarquias['categoria'], str_replace(".", "_", $info_["categae{$in_}_nom"]) . "." . str_replace(".", "_", $info_["areaexp{$in_}_nom"]));
      }
      foreach ($data[$this->alias] as $field => $value) {
        if (!in_array($field,$field_descar)) {
          $name_field = $_campos[$field];
          $this->agrupando_($value, $this->alias, $name_field);
        }
      }
    }

    $agrupados = array();
    $agrupados_g = array();
    foreach ($gerarquias as $tipo => $arra_) {
      foreach ($arra_ as $sub_leve => $array_sub) {
        $count_=0;
        foreach ($array_sub as $sub_leve_2 => $coun_sub) {
          $count_= $coun_sub+ $count_;
        }

        $agrupados_g[$tipo][$sub_leve]['count'] = $count_;
        arsort($array_sub);
        $agrupados_g[$tipo][$sub_leve]['data'] = $array_sub;
        $agrupados_g[$tipo][$sub_leve]['name_parent'] = $sub_leve;
      }
      if (!empty($agrupados_g[$tipo])) {
        usort($agrupados_g[$tipo], array($this, "cmpcategoria"));
      }
      // $agrupados_g[$tipo]['count']=$count_;
      // $agrupados_g[$tipo]['data']=$arra_;
    }

    if (!empty($this->result_agroup)) {
      foreach ($this->result_agroup[$this->alias] as $field_key => $data) {
        arsort($data);
        $agrupados[$field_key] = $data;
      }
    }

    $agrupados = array_merge($agrupados,$agrupados_g);
    return $agrupados;
  }

  protected function _findAll_info($state, $query, $results = array()) {
    if ($state === 'before') {
      $query['contain'] = array(
        'Atributos' => array(
          'conditions' => array(
            'Atributos.cu_cve' => $query['fromUser']
          )
        ),
        'Empresa' => array(
          'fields' => array(
            '(CASE WHEN Empresa.candidato_cve is not NULL THEN 1 ELSE 0 END) Empresa__adquirido'
          ),
          'conditions' => array(
            'Empresa.cia_cve' => $query['fromCia']
          )
        ),
        'Carpetas' => array(
          'conditions' => array(
            'Carpetas.cu_cve' => $query['fromUser']
          )
        ),
      );

      if (empty($query['order'])) {
        $query['order'] = array(
          $this->alias . '.' . $this->primaryKey => 'DESC'
        );
      }

      return $query;
    }
    return $results;
  }

  protected function _findFavs($state, $query, $results = array()) {
    if ($state === 'before') {
      $this->bindModel(array(
        'hasOne' => array(
          'Empresa' => array(
            'type' => 'INNER',
            'className' => 'EmpresasCandidatos',
            'fields' => array(
              '(CASE WHEN Empresa.candidato_cve is not NULL THEN 1 ELSE 0 END) Empresa__adquirido',
            ),
            'foreignKey' => 'candidato_cve'
          ),
          'Atributos' => array(
            'type' => 'INNER',
            'className' => 'CandidatoEmpresaAtributos',
            'foreignKey' => 'candidato_cve',
          ),
        )
      ));

      $query['contain'] = array(
        'Atributos' => array(
          'conditions' => array(
            'Atributos.candidato_cve = CandidatoEmpresa.candidato_cve',
            'Atributos.cu_cve' => $query['fromUser'],
            'Atributos.favorito' => 1
          ),
        )
      );
    }

    return $this->_findAll_info($state, $query, $results);
  }

  protected function _findPurchased($state, $query, $results = array()) {
    if ($state === 'before') {
      $this->bindModel(array(
        'hasOne' => array(
          'Empresa' => array(
            'type' => 'INNER',
            'className' => 'EmpresasCandidatos',
            'fields' => array(
              '(CASE WHEN Empresa.candidato_cve is not NULL THEN 1 ELSE 0 END) Empresa__adquirido'
            ),
            'foreignKey' => 'candidato_cve'
          ),
        )
      ));
    }

    return $this->_findAll_info($state, $query, $results);
  }

  protected function _findBy_user_folder($state, $query, $results = array()) {
    if ($state === 'before') {
      $query['conditions'][] = array(
        $this->alias . '.' . $this->primaryKey . ' in (SELECT DISTINCT('
        . $this->primaryKey .') FROM TCARPETAXCANDIDATO WHERE cu_cve = '
        . $query['fromUser']
        . (!empty($query['fromFolder']) ? ' AND carpeta_cve = ' . $query['fromFolder'] : '')
        . ')'
      );
    }

    return $this->_findAll_info($state, $query, $results);
  }

  protected function _findBy_user($state, $query, $results = array()) {
    if ($state === 'before') {
      $query['conditions'][] = array(
        'OR' => array(
          $this->alias . '.' . $this->primaryKey . ' in (SELECT DISTINCT('
          . $this->primaryKey .') FROM TCARPETAXCANDIDATO WHERE cu_cve = '
          . $query['fromUser']
          . ')',
          $this->alias . '.' . $this->primaryKey . ' in (SELECT DISTINCT('
          . $this->primaryKey .') FROM TCANDIDATOSXCIA WHERE cia_cve = '
          . $query['fromCia']
          . ')'
        )
      );
    }

    return $this->_findAll_info($state, $query, $results);
  }

  protected function _findMatch($state, $query, $results = array()) {
    if ($state === 'before') {
      $strExpr = !empty($query['expresion']) ? $query['expresion'] : false;

      if (!isset($query['fields']) || empty($query['fields'])) {
        $fields = array(
          'candidato_cve', 'candidato_perfil', 'candidato_nom', 'candidato_pat', 'candidato_mat', 'candidato_genero', 'candidato_edad',
          'candidato_edocivil', 'candidato_movil', 'candidato_tel', 'cc_email', 'cp_cp', 'cp_asentamiento', 'ciudad_nom', 'est_nom',
          'pais_nom', 'ec_institucion', 'ec_especialidad', 'ec_nivel', 'cespe_nom', 'cgen_nom', 'carea_nom', 'expeco_tipoe', 'sueldo_cve',
          'explab_sueldod', 'explab_puesto', 'explab_empresa', 'giro_nom', 'explab_fecini', 'explab_fecfin'
        );

        $query['fields'] = array_map(function ($value) {
          return $this->alias . '.' . $value;
        }, $fields);
      }

      if ($strExpr) {
        $tmplQuery = str_replace('__expresion__', $strExpr, $this->template_query['match']);
        $query['conditions']['AND']["contains($this->alias.candidato_texto,?,1) > 0"] = array($tmplQuery);
        $query['fields'][] = 'score(1) ' . $this->alias . '__score';
      }

      $query['contain'] = array(
        'Atributos' => array(
          'fields' => array(
            'candidatoxcu_cve',
            'cu_cve',
            'candidato_cve',
            'favorito'
          ),
          'conditions' => array(
            'Atributos.cu_cve' => $query['fromUser']
          )
        ),
        'Empresa' => array(
          'fields' => array(
            '(CASE WHEN Empresa.candidato_cve is not NULL THEN 1 ELSE 0 END) Empresa__adquirido'
          ),
          'conditions' => array(
            'Empresa.cia_cve' =>  $query['fromCia']
          )
        ),
        'Carpetas' => array(
          'conditions' => array(
            'Carpetas.cu_cve' => $query['fromUser']
          )
        )
      );

      return $query;
    }

    return $results;
  }

  protected function _findPaginate($state, $query, $results = array()) {
    if ($state === 'before') {
      $params = $query['params'];
      $is_group = isset($query['is_group']) && $query['is_group'] ? true : false;
      $query['is_group'] = $is_group;
      $str_expresion = isset($params['dato']) && !empty($params['dato'])  ? $params['dato'] : false;
      $query['conditions'] = $this->agregarCondiciones($params);

      if ($str_expresion !== false ) {
        $template_query = str_replace("__expresion__", $str_expresion, $this->template_query['normal']);
        $query['conditions']['AND']["contains($this->alias.candidato_texto,?,1) > 0"] = array($template_query);
      }

      $fields = array();
      if (!isset($query['fields']) || empty($query['fields'])) {
        $campos = array(
          'candidato_cve',
          'candidato_perfil',
          'candidato_nom',
          'candidato_pat',
          'candidato_mat',
          'candidato_genero',
          'candidato_edad',
          'candidato_edocivil',
          'candidato_movil',
          'candidato_tel',
          'cc_email',
          'cp_cp',
          'cp_asentamiento',
          'ciudad_nom',
          'est_nom',
          'pais_nom',
          'ec_institucion',
          'ec_especialidad',
          'ec_nivel',
          'cespe_nom',
          'cgen_nom',
          'carea_nom',
          'expeco_tipoe',
          'sueldo_cve',
          'explab_sueldod',
          'explab_puesto',
          'explab_empresa',
          'giro_nom',
          'explab_fecini',
          'explab_fecfin'
        );

        foreach ($campos as $value) {
          $fields[] = "$this->alias.$value";
        }
        $query['fields'] = $fields;
      }

      if ($str_expresion !== false) {
        $query['fields'][] = "score(1) " . $this->alias . "__score";
      }
      if (!$is_group) {
        if (isset($params['iDisplayStart']) && !empty($params['iDisplayStart'])) {
          $query['offset'] = $params['iDisplayStart'];
        }
        if(isset($params['iDisplayLength']) && !empty($params['iDisplayLength'])) {
          $query['limit'] = $params['iDisplayLength'];
        }
      }

      $arra_columns = array(
        0 => array(),
        1 =>array(),
        2 => array("candidato_perfil","ciudad_nom","est_nom","cp_cp"),
        3 =>array("sueldo_cve"),
        4 =>array("explab_puesto","explab_empresa"),
        5 =>array("ec_institucion","cespe_nom")
      );

      $query['order']=array();
      if (isset($params['iSortCol_0']) && isset($params['sSortDir_0'])) {
        $i = $params['iSortCol_0'];
        $dir = $params['sSortDir_0'];
        $colums_order = $arra_columns[$i];

        foreach ($colums_order as $value) {
          $query['order'][] = "$value $dir";
        }
      }

      $query['contain'] = array(
        'Atributos' => array(
          'fields' => array(
            'candidatoxcu_cve',
            'cu_cve',
            'candidato_cve',
            'favorito'
          ),
          'conditions' => array(
            'Atributos.cu_cve' => $query['fromUser']
          )
        ),
        'Empresa' => array(
          'fields' => array(
            '(CASE WHEN Empresa.candidato_cve is not NULL THEN 1 ELSE 0 END) Empresa__adquirido'
          ),
          'conditions' => array(
            'Empresa.cia_cve' =>  $query['fromCia']
          )
        ),
        'Carpetas' => array(
          'conditions' => array(
            'Carpetas.cu_cve' => $query['fromUser']
          )
        )
      );

      if ($query['is_group']) {
        $query['contain'] = array();
      }

      if (empty($query['order'])) {
        $query['order'] = array(
          $this->alias . '.' . $this->primaryKey => 'DESC'
        );
      }
      return $query;
    }

    $params = $query['params'];

    $iTotal = 0;
    if (!$query['is_group']) {
      $iTotal = $this->find('count', array(
        'conditions' => $query['conditions'],
        'contain' => array()
      ));
    }

    $resultado = array(
      'iTotalRecords' => count($results),
      'iTotalDisplayRecords' => $iTotal,
      'data' => $results
    );
    if (isset($params['sEcho']) && !empty($params['sEcho'])) {
      $resultado['sEcho'] = intval($params['sEcho']);
    }
    return  $resultado;
  }


  /**
   * Obtiene la url de la imagen del candidato si ésta existe.
   * @param  int      $id   Id del candidato.
   * @return string         Path de la imagen.
   */
  public function getPhotoPath($id) {
    App::uses('Usuario', 'Utility');

    return Usuario::getPhotoPath($id);
  }

  /**
   * [afterFind description]
   * @param  [type]  $results [description]
   * @param  boolean $primary [description]
   * @return [type]           [description]
   */
  public function afterFind($results, $primary = false) {
    foreach ($results as $key => $value) {
      if (isset($value[$this->alias][$this->primaryKey])) {
        $id = $value[$this->alias][$this->primaryKey];
        $results[$key][$this->alias]['foto_url'] = $this->getPhotoPath($id);
      } elseif(isset($value[$this->primaryKey])) {
        $id = $value[$this->primaryKey];
        $results[$key]['foto_url'] = $this->getPhotoPath($id);
      }
    }

    return parent::afterFind($results, $primary);
  }

  public function beforeFind($queryData = array()) {
    $queryData = parent::beforeFind($queryData);

    if (!empty($queryData['fromCia'])) {
      $usersId = $this->Denuncia->getReportedUsers($queryData['fromCia']);
      !empty($usersId) && $queryData['conditions']['NOT'][$this->alias . '.candidato_cve'] = $usersId;
    }

    return $queryData;
  }
}