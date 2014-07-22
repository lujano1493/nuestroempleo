<?php

App::uses('AppModel', 'Model');

class CandidatoEmpresa extends AppModel {

  /**
   * Utiliza el comportamiento: Containable
   * @var array
   */
  public $actsAs = array('Containable');

  /**
   * tabla
   * @var string
   */
  public $useTable = 'vcandidatos';

  /**
   * Llave primaria
   * @var string
   */
  public $primaryKey = 'candidato_cve';

  /**
   * Modelos relacionados.
   * @var array
   */
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
        'candidato_cve', 'cc_email', 'cc_completo', 'cc_status', 'created', 'modified'
      )
    ),
    'Expectativas' => array(
      'className' => 'ExpEcoCan',
      'foreignKey' => 'candidato_cve'
    )
  );

  /**
   * Modelos relacionados.
   * @var array
   */
  public $hasMany = array(
    'Experiencia' => array(
      'className' => 'AreaExpCan',
      'foreignKey' => 'candidato_cve',
      'finderQuery' => 'SELECT
        Experiencia.candidato_cve,
        Experiencia.area_cve,
        Areas.area_nom Experiencia__area,
        Catalogo.opcion_texto Experiencia__tiempo
          FROM tareasexplab Experiencia INNER JOIN tareas Areas ON (
            Areas.area_cve = Experiencia.area_cve
          ) INNER JOIN tcatalogo Catalogo ON (
            Catalogo.opcion_valor = Experiencia.tiempo_cve AND
            Catalogo.ref_opcgpo = \'TIEMPO_CVE\'
          )
          WHERE Experiencia.candidato_cve IN ({$__cakeID__$})'
    ),
    'AreasInteres' => array(
      'className' => 'AreaIntCan',
      'foreignKey' => 'candidato_cve',
      'finderQuery' => 'SELECT
        AreasInteres.candidato_cve,
        AreasInteres.area_cve,
        Areas.area_nom AreasInteres__area
          FROM tareaintcandidato AreasInteres INNER JOIN tareas Areas ON (
            Areas.area_cve = AreasInteres.area_cve
          )
          WHERE AreasInteres.candidato_cve IN ({$__cakeID__$})'
    ),
    'ExpeLaboral' => array(
      'className' => 'ExpLabCan',
      'foreignKey' => 'candidato_cve',
      'finderQuery' => 'SELECT
        ExpeLaboral.candidato_cve,
        ExpeLaboral.explab_empresa ExpeLaboral__empresa,
        ExpeLaboral.explab_funciones ExpeLaboral__funciones,
        ExpeLaboral.explab_actual ExpeLaboral__actual,
        ExpeLaboral.explab_puesto ExpeLaboral__puesto,
        ExpeLaboral.explab_web ExpeLaboral__web,
        ExpeLaboral.explab_fecini ExpeLaboral__inicio,
        ExpeLaboral.explab_fecfin ExpeLaboral__fin,
        Giros.giro_nom ExpeLaboral__giro_nombre
          FROM texplabcandidato ExpeLaboral INNER JOIN tgiros Giros ON (
            Giros.giro_cve = ExpeLaboral.giro_cve
          )
          WHERE ExpeLaboral.candidato_cve IN ({$__cakeID__$})
          ORDER BY ExpeLaboral__fin DESC'
    ),
    'Cursos' => array(
      'className' => 'CursoCan',
      'foreignKey' => 'candidato_cve',
      'finderQuery' => 'SELECT
        Cursos.candidato_cve,
        Cursos.curso_cve,
        Cursos.curso_institucion Cursos__institucion,
        Cursos.curso_nom Cursos__nombre,
        Cursos.curso_fecini Cursos__inicio,
        Cursos.curso_fecfin Cursos__fin
          FROM tcursocandidato Cursos
          WHERE Cursos.candidato_cve IN ({$__cakeID__$})
          ORDER BY Cursos__fin DESC'
    ),
    'Conocimientos' => array(
      'className' => 'ConoaCan',
      'foreignKey' => 'candidato_cve',
    ),
    'Habilidades' => array(
      'className' => 'HabiCan',
      'foreignKey' => 'candidato_cve',
      'finderQuery' => 'SELECT
        Habilidades.candidato_cve,
        Catalogo.opcion_texto Habilidades__habilidad
          FROM thabilidadcandidato Habilidades LEFT JOIN tcatalogo Catalogo ON (
            Catalogo.opcion_valor = Habilidades.habilidad_cve AND
            Catalogo.ref_opcgpo = \'HABILIDAD_CVE\'
          )
          WHERE Habilidades.candidato_cve IN ({$__cakeID__$})
          ORDER BY Habilidades.habilidad_cve DESC'
    ),
    'Estudios' => array(
      'className' => 'EscCan',
      'foreignKey' => 'candidato_cve',
      'finderQuery' => 'SELECT
        Estudios.candidato_cve,
        Estudios.ec_institucion Estudios__instituto,
        Estudios.ec_especialidad Estudios__especialidad,
        Estudios.ec_fecini Estudios__inicio,
        Estudios.ec_fecfin Estudios__fin,
        Estudios.ec_nivel Estudios__nivel_esc,
        Carrera.cespe_nom Estudios__carrera,
        Catalogo.opcion_texto Estudios__nivel_escolar
          FROM tesccandidato Estudios LEFT JOIN tesccarespe Carrera ON (
            Carrera.cespe_cve = Estudios.cespe_cve
          ) LEFT JOIN tcatalogo Catalogo ON (
            Catalogo.opcion_valor = Estudios.ec_nivel AND
            Catalogo.ref_opcgpo = \'NIVEL_ESCOLAR\'
          )
          WHERE Estudios.candidato_cve IN ({$__cakeID__$})
          ORDER BY Estudios__fin DESC'
    ),
    'Idiomas' => array(
      'className' => 'IdiomaCan',
      'foreignKey' => 'candidato_cve',
      'finderQuery' => 'SELECT
        Idiomas.candidato_cve,
        Idiomas.idioma_cve,
        CatalogoIdiomas.idioma_nom Idiomas__idioma,
        Catalogo.opcion_texto Idiomas__nivel
          FROM tidiomacandidato Idiomas INNER JOIN tidioma CatalogoIdiomas ON (
            CatalogoIdiomas.idioma_cve = Idiomas.idioma_cve
          ) INNER JOIN tcatalogo Catalogo ON (
            Catalogo.opcion_valor = Idiomas.ic_nivel AND
            Catalogo.ref_opcgpo = \'IC_NIVEL\'
          )
          WHERE Idiomas.candidato_cve IN ({$__cakeID__$})'
    ),
    'Referencias' => array(
      'className' => 'RefCan',
      'foreignKey' => 'candidato_cve',
      'finderQuery' => 'SELECT
        Referencias.candidato_cve,
        Referencias.refcan_cve Referencias__id,
        Referencias.refcan_nom Referencias__nombre,
        Referencias.refencuesta_status Referencias__status,
        Referencias.refcan_mail Referencias__email,
        Referencias.refcan_tel Referencias__tel,
        Referencias.tipo_movil,
        Catalogo.opcion_texto Referencias__relacion
          FROM trefcandidato Referencias
          INNER JOIN tcatalogo Catalogo ON (
            Catalogo.opcion_valor = Referencias.reftipo_cve AND
            Catalogo.ref_opcgpo = \'REFREL_CVE\'
          )
          WHERE Referencias.candidato_cve IN ({$__cakeID__$})'
    ),
    'Documentos' => array(
      'className' => 'DocCan',
      'foreignKey' => 'candidato_cve',
      'conditions' => array(
        'Documentos.docscan_nom != \'foto\''
      )
    ),
    'Incapacidades' => array(
      'className' => 'IncapCan',
      'foreignKey' => 'candidato_cve',
      'finderQuery' => 'SELECT
        Incapacidades.candidato_cve,
        Incapacidades.incapcan_cve Incapacidades__id,
        Catalogo.opcion_texto Incapacidades__nombre
          FROM tincapcandidato Incapacidades INNER JOIN tcatalogo Catalogo ON (
            Catalogo.opcion_valor = Incapacidades.incapacidad_cve AND
            Catalogo.ref_opcgpo = \'INCAPACIDAD_CVE\'
          )
          WHERE Incapacidades.candidato_cve IN ({$__cakeID__$})'
    ),
    'Anotaciones' => array(
      'className' => 'Anotacion',
      'foreignKey' => 'candidato_cve',
      'finderQuery' => 'SELECT
        Anotaciones.candidato_cve,
        Anotaciones.anotacion_cve Anotaciones__id,
        Anotaciones.anotacion_detalles Anotaciones__detalles,
        Anotaciones.created,
        UsuarioEmpresa.cu_sesion Usuario__email,
        UsuarioEmpresa.cu_cve Usuario__id,
        (C.con_nombre||\' \'||C.con_paterno||\' \'||C.con_materno) Usuario__nombre,
        Catalogo.opcion_texto Anotaciones__tipo
          FROM tanotaciones Anotaciones INNER JOIN tcuentausuario UsuarioEmpresa ON (
            UsuarioEmpresa.cu_cve = Anotaciones.cu_cve
          ) INNER JOIN tcontacto C ON (
            C.cu_cve = Anotaciones.cu_cve
          ) LEFT JOIN tcatalogo Catalogo ON (
            Catalogo.opcion_valor = Anotaciones.anotacion_tipo AND
            Catalogo.ref_opcgpo = \'ANOTACION_TIPO\'
          )
          WHERE Anotaciones.candidato_cve IN ({$__cakeID__$}) AND ({$__conditions__$})
          ORDER BY Anotaciones.created DESC'
    ),
    'Evaluaciones' => array(
      'className' => 'EvaCan',
      'foreignKey' => 'candidato_cve',
      'finderQuery' => 'SELECT
        Evaluaciones.candidato_cve,
        Evaluaciones.evaxcan_cve Evaluaciones__id,
        Evaluaciones.evaluacion_cve Evaluaciones__evaluacion_id,
        Evaluacion.evaluacion_nom Evaluaciones__nombre,
        Evaluacion.evaluacion_descrip Evaluaciones__descripcion,
        Evaluacion.tipoeva_cve Evaluaciones__tipo,
        Evaluaciones.evaluacion_fec Evaluaciones__fecha_resuelta,
        Evaluaciones.created Evaluaciones__fecha_asignada,
        Catalogo.opcion_texto Evaluaciones__tipo_texto
          FROM tevaluacandidato Evaluaciones
          INNER JOIN tevaluacion Evaluacion ON (
            Evaluacion.evaluacion_cve = Evaluaciones.evaluacion_cve AND
            (Evaluacion.tipoeva_cve = 2 OR {$__conditions__$})
          ) LEFT JOIN tcatalogo Catalogo ON (
            Catalogo.opcion_valor = Evaluacion.tipoeva_cve AND
            Catalogo.ref_opcgpo = \'TIPOEVA_CVE\'
          )
          WHERE Evaluaciones.candidato_cve IN ({$__cakeID__$}) AND
            Evaluaciones.evaluacion_status = 1
          ORDER BY Evaluaciones.created DESC'
    ),
  'Denuncia' => array(
      'className' => 'Denuncia',
      'foreignKey' => 'candidato_cve',
      'finderQuery' => 'SELECT 
        Denuncia.denuncia_cve,        
        Denuncia.motivo_cve,
        Denuncia.candidato_cve,
        Denuncia.denuncia_status Denuncia__status_cve,
        Denuncia.detalles,
        Denuncia.cu_cve,
        Denuncia.detalles,
        Denuncia.cia_cve,
        Denuncia.created,
        Motivo.opcion_texto Denuncia__motivo,
        Usuario.cu_cve  Usuario__id,
        Usuario.cu_sesion Usuario__correo,              
        Contacto.con_tel Usuario__tel,
        Contacto.con_ext Usuario__tel_ext,       
        (Contacto.con_nombre || \' \' || Contacto.con_paterno || \' \'|| Contacto.con_materno ) Usuario__nombre
        FROM  tdenunciascv Denuncia INNER JOIN tcatalogo Motivo ON( 
            Motivo.opcion_valor=Denuncia.motivo_cve AND  Motivo.ref_opcgpo = \'MOTIVO_CVE\' 
          )  INNER JOIN tcuentausuario Usuario ON(
                Usuario.cu_cve =   Denuncia.cu_cve
          ) INNER JOIN tcontacto Contacto ON (
                  Contacto.cu_cve = Usuario.cu_cve
          )
        WHERE Denuncia.candidato_cve in ({$__cakeID__$})  AND  ({$__conditions__$})
        ORDER BY Denuncia.denuncia_cve desc'
    )
  );

  /**
   * Modelos relacionados.
   * @var array
   */
  public $hasAndBelongsToMany = array(
    'Carpetas' => array(
      'className' => 'Carpeta',
      'with' => 'CarpetasCandidatos',
      'foreignKey' => 'candidato_cve',
      'associationForeignKey' => 'carpeta_cve',
      'unique' => false
    )
  );

  /**
   * Tipos de búsqueda.
   * @var array
   */
  public $findMethods = array(
    'basic_info'        => true,
    'perfil'            => true,
    'perfil_para_admin' => true,
    'denuncias' => true
  );

  /**
   * Constructor de Candidato.
   * @param boolean $id    [description]
   * @param [type]  $table [description]
   * @param [type]  $ds    [description]
   */
  public function __construct($id = false, $table = null, $ds = null) {
    parent::__construct($id, $table, $ds);

    /**
     * Establece los campos virtuales dependiendo del alias.
     */
    $this->virtualFields = array(
      //'fecha_nac' => "to_char($this->alias.candidato_fecnac,'DD/MM/YYYY')",
      'edad' => "trunc((sysdate - $this->alias.candidato_fecnac) / 365)",
      'nombre' => "$this->alias.candidato_nom || ' ' || $this->alias.candidato_pat || ' ' || $this->alias.candidato_mat",
      'genero' => "decode($this->alias.candidato_sex,'M','Masculino','F','Femenino','Dato no Capturado')"
    );
  }

  protected $joins = array(
    'catalogo' => array(
      array(
        'alias' => 'Catalogo',
        'conditions' => array(
          'Catalogo.ref_opcgpo' => 'ESTADO_CIVIL',
          'Catalogo.opcion_valor = CandidatoEmpresa.edo_civil'
        ),
        'fields' => array('Catalogo.opcion_texto Catalogo__edo_civil'),
        'table' => 'tcatalogo',
        'type' => 'LEFT',
      ),
    ),
    'sueldo' => array(
      array(
        'alias' => 'Expectativas',
        'conditions' => array(
          'Expectativas.candidato_cve = CandidatoEmpresa.candidato_cve',
        ),
        'fields' => array(
          'decode(Expectativas.explab_viajar,\'S\',\'Sí\',\'N\',\'No\',\'Dato no Capturado\') Expectativas__viajar',
          'decode(Expectativas.explab_reu,\'S\',\'Sí\',\'N\',\'No\',\'Dato no Capturado\') Expectativas__reubicacion'
        ),
        'table' => 'texpecocandidato',
        'type' => 'LEFT',
      ),
      array(
        'alias' => 'TipoEmpleo',
        'conditions' => array(
          'TipoEmpleo.ref_opcgpo' => 'DISPONIBILIDAD_EMPLEO',
          'TipoEmpleo.opcion_valor = Expectativas.expeco_tipoe'
        ),
        'fields' => array('TipoEmpleo.opcion_texto Expectativas__tipo_empleo'),
        'table' => 'tcatalogo',
        'type' => 'LEFT',
      ),
      array(
        'alias' => 'SueldoDeseado',
        'conditions' => array(
          'Expectativas.explab_sueldod = SueldoDeseado.elsueldo_cve',
        ),
        'fields' => array(
          'SueldoDeseado.elsueldo_cve Expectativas__sueldo_orden',
          'SueldoDeseado.elsueldo_ini Expectativas__sueldo_deseado'
        ),
        'table' => 'texplabsueldos',
        'type' => 'LEFT',
      ),
    ),
    'direccion' => array(
      array(
        'alias' => 'Direccion',
        'conditions' => array(
          'Direccion.candidato_cve = CandidatoEmpresa.candidato_cve'
        ),
        'table' => 'tdircandidato',
        'type' => 'LEFT',
      ),
      array(
        'alias' => 'CP',
        'conditions' => array(
          'Direccion.cp_cve = CP.cp_cve'
        ),
        'fields' => array('CP.cp_cp Direccion__cp', 'CP.cp_asentamiento Direccion__colonia'),
        'table' => 'tcodigopostal',
        'type' => 'LEFT',
      ),
      array(
        'alias' => 'Ciudad',
        'conditions' => array(
          'Ciudad.ciudad_cve = CP.ciudad_cve'
        ),
        'fields' => array('Ciudad.ciudad_nom Direccion__ciudad'),
        'table' => 'tciudad',
        'type' => 'LEFT',
      ),
      array(
        'alias' => 'Estado',
        'conditions' => array(
          'Estado.est_cve = CP.est_cve'
        ),
        'fields' => array('Estado.est_nom Direccion__estado'),
        'table' => 'testado',
        'type' => 'LEFT',
      ),
      array(
        'alias' => 'Pais',
        'conditions' => array(
          'Pais.pais_cve = CP.pais_cve'
        ),
        'fields' => array('Pais.pais_nom Direccion__pais'),
        'table' => 'tpais',
        'type' => 'LEFT',
      )
    )
  );

  protected function _findDenuncias($state, $query, $results = array()) {
    if ($state === 'before') {
      $this->useTable='tcandidato';
      $query['recursive'] =-1;

      $all=isset($query['all']) && $query['all'] ===true;

      $where= $all ?"1=1": "denuncia_status!=3" ;
      $query['joins'] = array(
        array(
          'alias' => 'Denuncias',
          'conditions' => array(
                "CandidatoEmpresa.candidato_cve = Denuncias.candidato_cve"
            ),
          'fields' => array(  
              "Denuncias.veces_denunciados Denunciado__denunciado"                   
            ),
          "table" => "(select candidato_cve,count (*) veces_denunciados  from tdenunciascv where $where group by candidato_cve)",
          "type" => "inner"
          )
        );
      $where= $all ? array("1=1"): array("Denuncia.denuncia_status!=3") ;
      $query['contain'] = array(
         'Denuncia' =>array("conditions" => $where),'Cuenta'
        );
      $query['fields'] = array(
          "$this->alias.candidato_cve Denunciado__id",
          "'candidato'  Denunciado__tipo",
          "($this->alias.candidato_nom||' '|| $this->alias.candidato_pat || ' ' || $this->alias.candidato_pat) Denunciado__nombre",
          "$this->alias.candidato_perfil    Denunciado__perfil",
          "Cuenta.cc_email Denunciado__correo"
        );
      return $query;
    }

    if(!empty($results)){
        foreach ($results as $key => $value) {
          if(!empty($results[$key]['Denuncia'] )){
            $results[$key]['Denunciado']['status_cve']=$results[$key]['Denuncia'][0]['status_cve'];
            $results[$key]['Denunciado']['created']=$results[$key]['Denuncia'][0]['created'];            
          }
        }
    }

    return $results;
  }

  protected function _findBasic_info($state, $query, $results = array()) {
    if ($state == 'before') {
      $query['contain'] = array(
        'Cuenta' => array(
          'fields' => array(
            'Cuenta.candidato_cve',
            'Cuenta.cc_email Cuenta__email',
            'Cuenta.cc_completo Cuenta__perfil_completo'
          )
        )
      );

      return $query;
    }

    return $results;
  }

  protected function _findComplete_info($state, $query, $results = array()) {
    if ($state === 'before') {
      $query['joins'] = !empty($query['joins']) && is_array($query['joins']) ? $query['joins'] : array();
      $query['contain'] = !empty($query['contain']) && is_array($query['contain']) ? $query['contain'] : array();

      $query['joins'] = array_merge($this->joins['direccion'], $this->joins['catalogo'], $this->joins['sueldo']);

      $query['conditions'][] = 'Cuenta.cc_completo = \'S\'';

      $query['contain'] = array_merge(array(
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
        'Cuenta',
        'Carpetas' => array(
          'conditions' => array(
            'Carpetas.cu_cve' => $query['fromUser']
          )
        ),
        'Experiencia',
        'Estudios',
        'ExpeLaboral',
      ), $query['contain']);

      if (empty($query['order'])) {
        $query['order'] = array(
          $this->alias . '.' . $this->primaryKey => 'DESC'
        );
      }
      return $query;
    }
    return $results;
  }

  protected function _findPerfil_para_admin($state, $query, $results = array()) {
    if ($state === 'before') {
      //$query['joins'] = array_merge($this->joins['direccion'], $this->joins['catalogo'], $this->joins['sueldo']);

      $query['contain'] = array(
        'Cuenta',
        'Experiencia',
        'Idiomas',
        'Estudios',
        'ExpeLaboral',
        'AreasInteres',
        'Cursos',
        'Conocimientos',
        'Habilidades',
        'Referencias',
        'Documentos',
        'Incapacidades',
      );

      return $query;
    }

    return !empty($results) && isset($results[0]) ? $results[0] : $results;
  }

  protected function _findPerfil($state, $query, $results = array()) {
    if ($state === 'before') {
      //$query['joins'] = array_merge($this->joins['direccion'], $this->joins['catalogo'], $this->joins['sueldo']);

      $query['contain'] = array(
        'Atributos' => array(
          'conditions' => array(
            'Atributos.cu_cve' => $query['fromUser']
          )
        ),
        'Empresa' => array(
          'fields' => array(
            '(CASE WHEN Empresa.candidato_cve is not NULL THEN 1 ELSE 0 END) Empresa__adquirido',
            'Empresa.created Empresa__fecha_adquirido'
          ),
          'conditions' => array(
            'Empresa.cia_cve' => $query['fromCia']
          ),
          'UsuarioEmpresa',
          'Contacto'
        ),
        'Cuenta',
        'Carpetas' => array(
          'conditions' => array(
            'Carpetas.cu_cve' => $query['fromUser']
          )
        ),
        'Experiencia',
        'Idiomas',
        'Estudios',
        'ExpeLaboral',
        'AreasInteres',
        'Cursos',
        'Conocimientos',
        'Habilidades',
        'Referencias',
        'Documentos',
        'Incapacidades',
        'Anotaciones' => array(
          'conditions' => array(
            'Anotaciones.cu_cve' => ClassRegistry::init('Empresa')->getUsuarios($query['fromCia'], 'ids'),
            'OR' => array(
              'Anotaciones.anotacion_tipo' => 1,
              'Anotaciones.cu_cve' => $query['fromUser']
            )
          )
        ),
        'Evaluaciones' => array(
          'conditions' => array(
            'Evaluacion.cia_cve' => $query['fromCia'],
          )
        ),
        //'Encuestas'
      );
      $query['conditions']["Cuenta.cc_status"]=1;
      return $query;
    }

    return !empty($results) && isset($results[0]) ? $results[0] : $results;
  }

  public function getStats($userId, $ciaId) {
    $stats = $this->find('all', array(
      'fields' => array(
        'nvl(sum(Atributos.favorito),0) Stats__favoritos',
        'nvl(sum((CASE WHEN Empresa.candidato_cve is not NULL THEN 1 ELSE 0 END)),0) Stats__adquiridos'
      ),
      'contain' => array(
        'Cuenta' => array(
          'fields' => false
        ),
        'Atributos' => array(
          'conditions' => array(
            'Atributos.cu_cve' => $userId
          )
        ),
        'Empresa' => array(
          'conditions' => array(
            'Empresa.cia_cve' => $ciaId
          )
        )
      ),
      'conditions' => array(
        'CandidatoEmpresa.candidato_cve IN (SELECT DISTINCT(candidato_cve) FROM tcandidatosxcia WHERE cia_cve = '. $ciaId . ')',
        'Cuenta.cc_status' => 1,
        'CandidatoEmpresa.candidato_cve NOT IN (SELECT DISTINCT(candidato_cve)
          FROM tdenunciascv WHERE cia_cve = ' . $ciaId . ' AND denuncia_status < 3)'
        // 'OR' => array(
        //   '(CandidatoEmpresa.candidato_cve in (SELECT DISTINCT(candidato_cve) FROM TCARPETAXCANDIDATO WHERE cu_cve = ' . $userId . '))',
        //   '(CandidatoEmpresa.candidato_cve in (SELECT DISTINCT(candidato_cve) FROM TCANDIDATOSXCIA WHERE cia_cve = '. $ciaId . '))'
        // )
      ),
      'recursive' => -1
    ));

    return current(current($stats));
  }

  public function is($type, $opts = array()) {
    /**
     * En caso de pasar una conjunción, buscará los valores.
     * @var [type]
     */
    $conjunction = isset($type['OR']) ? 'OR' : 'AND';
    $type = !empty($type[$conjunction]) ? $type[$conjunction] : (array)$type;

    // Si fue adquirido.
    $adquirido = in_array('adquirido', $type) && $this->Empresa->hasAny(array(
      'Empresa.cia_cve' => $opts['cia'],
      'Empresa.candidato_cve' => $opts['candidato']
    ));

    // Si se postuló.
    $postulado = in_array('postulado', $type) && ClassRegistry::init('Postulacion')->hasAny(array(
      'Postulacion.cia_cve' => $opts['cia'],
      'Postulacion.candidato_cve' => $opts['candidato']
    ));

    /**
     * En base al arreglo busca la variables, generando un array de clave - valor.
     * Después obtinene un arreglo con los puros valores.
     * @var array
     */
    $values = array_values(compact($type));

    /**
     * Si la conjunción es 'OR' buscará un valor TRUE
     * Si la conjunción es 'AND', con que se encuentre un sólo valor false, retornara false.
     * @var [type]
     */
    return $conjunction === 'OR' ? in_array(true, $values, true) : !in_array(false, $values, true);
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
      } elseif (isset($value[$this->primaryKey])) {
        $id = $value[$this->primaryKey];
        $results[$key]['foto_url'] = $this->getPhotoPath($id);
      }
    }

    return parent::afterFind($results, $primary);
  }
}