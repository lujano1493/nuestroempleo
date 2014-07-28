<?php

App::uses('AppModel', 'Model');
App::uses('Acceso','Utility');
App::uses('Usuario','Utility');

class Oferta extends AppModel {

  public $name = 'Oferta';

  public $primaryKey = 'oferta_cve';

  public $actsAs = array(
    'Containable',
    'Clob' => array(
      'generateFields' => array(
        'oferta_descripalt' => array(
          'stripHtml' => 'oferta_descrip'
        )
      )
    )
  );

  public $findMethods = array(
    'activas' => true,
    'dependientes' => true,
    'info_completa' => true,
    'por_usuario' => true,
    'compartidas' => true,
    'recientes' => true,
    'a_vencer' => true,
    'postulaciones' => true,
    'expresion' => true,
    'oferta' => true,
    'denuncias' => true,
    'sociales' => true
  );

  public $jsonFields = array('oferta_prestaciones', 'passFields' => 'campos');

  /**
    * No se usará tabla mientras.
    */
  public $useTable = 'tofertas';

  public $belongsTo = array(
    'Empresa' => array(
      'className' => 'Empresa',
      'foreignKey' => 'cia_cve'
    ),
    'UsuarioEmpresa' => array(
      'className' => 'UsuarioEmpresa',
      'foreignKey' => 'cu_cve'
    ),
    'Carpeta' => array(
      'className' => 'Carpeta',
      'foreignKey' => 'carpeta_cve'
    )
  );

  /*

    R.candidato_cve,
                                 R.refcan_nom,
                                 R.refcan_mail,
                                 R.refcan_tel


            Contacto.refcan_mail Postulacion__contacto_email,
            Contacto.refcan_tel Postulacion__contacto_telefono
   */

    public $hasMany = array(
      'Denuncia' => array(
        'className' => 'Denuncia',
        'foreignKey' => 'oferta_cve',
        'finderQuery' => 'SELECT 
          Denuncia.denuncia_cve,        
          Denuncia.causa_cve,
          Denuncia.oferta_cve,
          Denuncia.status_cve,
          Denuncia.detalles,
          Denuncia.created,
          Motivo.opcion_texto Denuncia__motivo,
          Usuario.candidato_cve Usuario__id,
          Usuario.cc_email Usuario__correo,          
          (DECODE(Candidato.candidato_movil,NULL,Candidato.candidato_movil,Candidato.candidato_tel) ) Usuario__telefono,
          (Candidato.candidato_nom || \' \' || Candidato.candidato_pat || \' \' || Candidato.candidato_mat) Usuario__nombre  
          FROM  tdenunciasoferta Denuncia INNER JOIN tcatalogo Motivo ON( 
              Motivo.opcion_valor=Denuncia.causa_cve AND  Motivo.ref_opcgpo = \'CAUSA_CVE\' 
            )  INNER JOIN tcuentacandidato Usuario ON(
                  Usuario.candidato_cve =   Denuncia.candidato_cve
            ) INNER JOIN tcandidato Candidato ON(
                  Usuario.candidato_cve = Candidato.candidato_cve
            )
          WHERE Denuncia.oferta_cve in ({$__cakeID__$})  AND ({$__conditions__$})
          ORDER BY Denuncia.denuncia_cve desc'
    ),
     'Postulacion' => array(
                  'className'    => 'Postulacion',
                  'foreignKey'   => 'oferta_cve',
                  'finderQuery' =>
    'SELECT
            Postulacion.oferta_cve,
            Candidato.candidato_cve Postulacion__candidato_cve,
            Candidato.candidato_perfil Postulacion__perfil,
            (Candidato.candidato_nom ||\' \'|| Candidato.candidato_pat ||\' \'|| Candidato.candidato_mat) Postulacion__nombre,
            Candidato.cc_email   Postulacion__email,
            Candidato.candidato_tel Postulacion__telefono,
            Candidato.candidato_movil Postulacion__movil,
            Candidato.candidato_edad  Postulacion__edad,
            Candidato.ciudad_nom      Postulacion__ciudad,
            Candidato.est_nom Postulacion__estado,
            Candidato.pais_nom Postulacion__pais,
            Candidato.cp_asentamiento Postulacion__colonia,
            DECODE(ExpEco.explab_viajar,\'S\',\'Sí\',\'No\') Postulacion__viajar,
            DECODE(ExpEco.explab_reu,\'S\',\'Sí\',\'No\') Postulacion__reubicarse,
            Evaluacion.evalua Postulacion__evalua,
            Candidato.ec_nivel Postulacion__nivel,
            Candidato.cespe_nom Postulacion__carrera,
            Candidato.ec_especialidad  Postulacion__especialidad,
            Candidato.conoc_descrip Postulacion__conocimientos,
            AreaExp.areas_experiencia Postulacion__areas_exp,
            Escuela.escolaridad Postulacion__escolar,
            Candidato.explab_empresa Postulacion__laboral_empresa,
            Candidato.explab_puesto Postulacion__laboral_puesto,
            Candidato.giro_nom   Postulacion__laboral_giro,            
            TO_CHAR(Candidato.explab_fecini,\'DD/MM/YYYY\') Postulacion__laboral_fecini,
            NVL(TO_CHAR(Candidato.explab_fecfin,\'DD/MM/YYYY\'),\'Actual\') Postulacion__laboral_fecfin,
            Candidato.explab_funciones Postulacion__laboral_funciones,
            TO_CHAR(Postulacion.created,\'DD/MM/YYYY\') Postulacion__fecha

    FROM
        tpostulacionxoferta Postulacion INNER JOIN tcandidatobusqueda Candidato ON (
              Postulacion.candidato_cve = Candidato.candidato_cve
            )  LEFT JOIN texpecocandidato ExpEco ON (
                Candidato.candidato_cve = ExpEco.candidato_cve
            ) LEFT JOIN (
                        SELECT
                              candidato_cve,
                              DECODE(evaluacion_status,1,\'terminada\',\'No terminada\') evalua
                        FROM
                          tevaluacandidato
                        WHERE
                          evaluacion_cve=2

            ) Evaluacion ON (
                        Candidato.candidato_cve=Evaluacion.candidato_cve
            )
            LEFT JOIN
                        (SELECT candidato_cve,
                        LISTAGG(
                          area_nom ||\' \'||opcion_texto ||\'::\'
                        ) WITHIN GROUP (
                      ORDER BY area_nom) AS areas_experiencia
                      FROM
                        (SELECT 
                          candidato_cve,
                          area_nom ,      
                          areaexpcan_cve,
                          opcion_texto
                        FROM tareasexplab INNER JOIN tareas ON (tareasexplab.area_cve=tareas.area_cve)
                            INNER JOIN tcatalogo ON (tcatalogo.opcion_valor=tareasexplab.tiempo_cve and tcatalogo.ref_opcgpo=\'ANIOSAREAEXPCAN\' )
                        )
                      GROUP BY candidato_cve
                      ) AreaExp
                    ON ( Candidato.candidato_cve =AreaExp.candidato_cve )

               LEFT JOIN
                        (SELECT candidato_cve,
                        LISTAGG(
                          ec_institucion ||\'_\'||opcion_texto  ||\'_\'|| to_char(ec_fecini,\'DD/MM/YYYY\') ||\'_\'
                          || decode(ec_fecfin,NULL,\'Actual\',to_char(ec_fecfin,\'DD/MM/YYYY\'))||\'::\'
                        ) WITHIN GROUP (
                      ORDER BY ec_institucion) AS escolaridad
                      FROM
                        (SELECT 
                          candidato_cve,
                          ec_institucion ,   
                          cespe_nom,   
                          opcion_texto,
                          ec_fecini,
                          ec_fecfin
                        FROM tesccandidato INNER JOIN tesccarespe ON (tesccandidato.cespe_cve=tesccarespe.cespe_cve)
                            INNER JOIN tcatalogo ON (tcatalogo.opcion_valor=tesccandidato.ec_nivel and tcatalogo.ref_opcgpo=\'NIVEL_ESCOLAR\' )
                        )
                      GROUP BY candidato_cve
                      ) Escuela
                    ON ( Candidato.candidato_cve =Escuela.candidato_cve )


            WHERE
              Postulacion.oferta_cve IN ({$__cakeID__$}) AND rownum<=100
            ORDER BY
              Postulacion.postulacion_cve DESC'
                  )
     );

  public $hasAndBelongsToMany = array(
    'Etiquetas' => array(
      'className' => 'Etiqueta',
      //'joinTable' => 'tetiquetasxoferta',
      'with' => 'EtiquetasOferta',
      'foreignKey' => 'oferta_cve',
      'associationForeignKey' => 'etiqueta_cve',
      'unique' => false
    ),
    'Areas' => array(
      'className' => 'AreaInt',
      //'joinTable' => 'tetiquetasxoferta',
      'with' => 'AreasOferta',
      'foreignKey' => 'oferta_cve',
      'associationForeignKey' => 'area_cve',
      'unique' => false
    ),
    'CandidatosPostulados' => array(
      'className' => 'CandidatoB',
      //'joinTable' => 'tpostulacionxoferta',
      'with' => 'Postulacion',
      'foreignKey' => 'oferta_cve',
      'associationForeignKey' => 'candidato_cve',
      'unique' => false
    )
  );

  protected $joins = array(
    'experiencia' => array(
      'alias' => 'Experiencia',
      'conditions' => array(
        'Experiencia.ref_opcgpo' => 'EXPERIENCIA',
        'Experiencia.opcion_valor = Oferta.oferta_exp'
      ),
      'fields' => array('Experiencia.opcion_texto Catalogo__experiencia'),
      'table' => 'tcatalogo',
      'type' => 'LEFT',
    ),
    'escolaridad' => array(
      'alias' => 'Escolaridad',
      'conditions' => array(
        'Escolaridad.ref_opcgpo' => 'NIVEL_ESCOLAR',
        'Escolaridad.opcion_valor = Oferta.oferta_nivelesc'
      ),
      'fields' => array('Escolaridad.opcion_texto Catalogo__escolaridad'),
      'table' => 'tcatalogo',
      'type' => 'LEFT',
    ),
    'genero' => array(
      'alias' => 'Genero',
      'conditions' => array(
        'Genero.ref_opcgpo' => 'GENERO',
        'Genero.opcion_valor = Oferta.oferta_sexo'
      ),
      'fields' => array('Genero.opcion_texto Catalogo__genero'),
      'table' => 'tcatalogo',
      'type' => 'LEFT',
    ),
    'edocivil' => array(
      'alias' => 'EdoCivil',
      'conditions' => array(
        'EdoCivil.ref_opcgpo' => 'ESTADO_CIVIL',
        'EdoCivil.opcion_valor = Oferta.edocivil_cve'
      ),
      'fields' => array('EdoCivil.opcion_texto Catalogo__edocivil'),
      'table' => 'tcatalogo',
      'type' => 'LEFT',
    ),
    'tipo_empleo' => array(
      'alias' => 'TipoEmpleo',
      'conditions' => array(
        'TipoEmpleo.ref_opcgpo' => 'DISPONIBILIDAD_EMPLEO',
        'TipoEmpleo.opcion_valor = Oferta.oferta_tipoempleo'
      ),
      'fields' => array('TipoEmpleo.opcion_texto Catalogo__tipo_empleo'),
      'table' => 'tcatalogo',
      'type' => 'LEFT',
    ),
    'disponibilidad' => array(
      'alias' => 'Disponibilidad',
      'conditions' => array(
        'Disponibilidad.ref_opcgpo' => 'DISPONIBILIDAD',
        'Disponibilidad.opcion_valor = Oferta.oferta_disp'
      ),
      'fields' => array('Disponibilidad.opcion_texto Catalogo__disponibilidad'),
      'table' => 'tcatalogo',
      'type' => 'LEFT',
    ),
    'ciudad' => array(
      'alias' => 'Ciudad',
      'conditions' => array(
        'Ciudad.ciudad_cve = Oferta.ciudad_cve'
      ),
      'fields' => array('Ciudad.ciudad_nom Direccion__ciudad'),
      'table' => 'tciudad',
      'type' => 'LEFT',
    ),
    'estado' => array(
      'alias' => 'Estado',
      'conditions' => array(
        'Estado.est_cve = Ciudad.est_cve'
      ),
      'fields' => array('Estado.est_nom Direccion__estado'),
      'table' => 'testado',
      'type' => 'LEFT',
    ),
    'postulaciones' => array(
      'alias' => 'Postulacion',
      'conditions' => array(
        'Postulacion.oferta_cve = Oferta.oferta_cve'
      ),
      'fields' => array(
        'NVL(Postulacion.total,0) Oferta__postulaciones'
      ),
      'table' => '(SELECT
          count(oferta_cve) total,
          oferta_cve
          FROM tpostulacionxoferta POferta
          INNER JOIN tcandidatobusqueda PCandidato ON (PCandidato.candidato_cve = POferta.candidato_cve)
          GROUP BY oferta_cve)',
      'type' => 'LEFT'
    )
  );

  /**
    * Validaciones
    */
  public $validate = array(
    'puesto_nom' => array(
      'required' => array(
        'rule' => 'notEmpty',
        'required' => true,
        'message' => 'Ingresa el nombre del puesto.'
      ),
      'maxlength' => array(
        'rule' => array('maxLength', 50),
        'message' => 'El máximo de caracteres para el nombre del puesto es 50.'
      )
    ),
    'oferta_descrip' => array(
      'required' => array(
        'rule' => 'notEmpty',
        'required' => true,
        'message' => 'Ingresa la descripción del puesto.'
      )
    ),
    'oferta_cvealter' => array(
      'validateUnique' => array(
        'rule' => array('uniqueAlterId'),
        'allowEmpty' => true,
        'message' => 'La clave debe ser única. Ya existe en tu compañia.'
      ),
      'maxlength' => array(
        'rule' => array('maxLength', 15),
        'message' => 'El máximo de caracteres para la clave de la oferta es 15.'
      )
    ),
    'ciudad_cve' => array(
      'required' => array(
        'rule' => 'notEmpty',
        'required' => true,
        'message' => 'Selecciona la ciudad a la que pertenece la oferta.'
      ),
    )
  );

  private $status = array(
    'borrador' => array(
      'name' => 'borrador',
      'value' => 0
    ),
    'publicada' => array(
      'name' => 'publicada',
      'value' => 1,
      'type' => 'oferta_publicada'
    ),
    'recomendada' => array(
      'name' => 'recomendada',
      'value' => 2,
      'type' => 'oferta_recomendada'
    ),
    'distinguida' => array(
      'name' => 'distinguida',
      'value' => 3,
      'type' => 'oferta_distinguida'
    )
  );

  private $statusDefaultValues = array(
    'borrador' => 0,
    'publicada' => 0,
    'recomendada' => 0,
    'distinguida' => 0
  );

  private $statusKey = 'oferta_status';

    protected function _findDenuncias($state, $query, $results = array()) {
    if ($state === 'before') {      
      $query['recursive'] =-1;
      $all=isset($query['all']) && $query['all'] ===true;
      $where= $all ?"1=1": "status_cve!=3" ;
      $query['joins'] = array(
        array(
        'alias' => 'Denuncias',
        'conditions' => array(
              "Oferta.oferta_cve = Denuncias.oferta_cve"
          ),
        'fields' => array(  
            "Denuncias.veces_denunciados Denunciado__denunciado"                   
          ),
        "table" => "(select oferta_cve,count (*) veces_denunciados  from tdenunciasoferta where  $where group by oferta_cve)",
        "type" => "inner"
      ));
      $where= $all ? array("1=1"): array("Denuncia.status_cve!=3") ;
      $query['contain'] = array(
         'Denuncia' => array(
                "conditions"=> $where
          ),'UsuarioEmpresa'
        );

      $query['fields'] = array(
          "$this->alias.oferta_cve Denunciado__id",
          "'oferta'  Denunciado__tipo",
          "$this->alias.puesto_nom Denunciado__nombre",
          "UsuarioEmpresa.cu_sesion Denunciado__correo",
          ""
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

  protected function _findPor_usuario($state, $query, $results = array()) {
    if ($state === 'before') {

      $query['conditions'] = array_merge(array(
        'Oferta.oferta_fecfin >= CURRENT_DATE',
        'Oferta.oferta_inactiva = ' => 0,
        'Oferta.cu_cve' => $query['fromUser']
      ), isset($query['conditions']) ? $query['conditions'] : array());

      if (!isset($query['order'])) {
        $query['order'] = array(
          'Oferta.oferta_cve' => 'ASC'
        );
      }

      $query['contain'] = array(
        'UsuarioEmpresa' => array(
          'fields' => array('cu_cve', 'cu_sesion', 'keycode')
        ),
        'Carpeta'
      );

      $query['recursive'] = -1;
      return $query;
    }

    return $results;
  }

  /**
   * Búsqueda de ofertas Activas.
   * @param  [type] $state   [description]
   * @param  [type] $query   [description]
   * @param  array  $results [description]
   * @return [type]          [description]
   */
  protected function _findActivas($state, $query, $results = array()) {
    if ($state === 'before') {
      $query['conditions'] = array(
        'Oferta.cu_cve' => $this->UsuarioEmpresa->getIds('dependents', array(
          'parent' => $query['fromUser']
        )),
        'Oferta.oferta_fecfin >= CURRENT_DATE',
        'Oferta.oferta_status > ' => 0,
        'Oferta.oferta_inactiva = ' => 0
      );

      $query['joins'] = array($this->joins['postulaciones']);

      $query['contain'] = array(
        'UsuarioEmpresa' => array(
          'fields' => array('cu_cve', 'cu_sesion', 'keycode')
        ),
        'Carpeta'
      );

      $query['recursive'] = -1;

      return $query;
    }

    return $results;
  }

  protected function _findPostulaciones($state, $query, $results = array()) {
    if ($state === 'before') {
      $query['joins'] = array($this->joins['postulaciones']);

      $query['contain'] = array(
        'CandidatosPostulados' => array(
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
            ),
          ),
          'Carpetas'
        ),
        'UsuarioEmpresa' => array(
          'fields' => array('cu_cve', 'cu_sesion', 'keycode')
        ),
        'Carpeta'
      );

      $query['recursive'] = -1;

      return $query;
    }

    return $results;
  }
    protected function _findSociales($state, $query, $results = array()) {
    if ($state === 'before') {

        $conditions=array(
          'Oferta.oferta_fecfin >= CURRENT_DATE',
          'Oferta.oferta_redsocial' => 1,
          'Oferta.oferta_status > ' => 0,
          'Oferta.oferta_inactiva = ' => 0
      );


      if(isset($query['id'])){
        $conditions[ "$this->alias.$this->primaryKey"]= $query['id'];      
      }

      if(isset($query['idUser'])){
        $conditions["$this->alias.cu_cve"] = $this->UsuarioEmpresa->getIds('dependents', array(
          'parent' => $query['idUser']
        ));
      }
      $query['conditions']=$conditions;
      $query['joins'] = array(
              array(
                      'table' => '(select compartir_id,count (compartir_id) veces from tcompartir where compartir_tipo=1 and compartir_redsocial=1 group by compartir_id )',
                      'alias' => 'Facebook',
                      'conditions' => array(
                              "$this->alias.oferta_cve= Facebook.compartir_id" 
                        ),
                      'fields' => array(
                          "nvl(Facebook.veces,0)   {$this->alias}__compartido_facebook"
                      ),
                      'type' =>'LEFT'
              ),

              array(
                      'table' => '(select compartir_id,count (compartir_id) veces from tcompartir where compartir_tipo=1 and compartir_redsocial=2 group by compartir_id )',
                      'alias' => 'Twitter',
                      'conditions' => array(
                              "$this->alias.oferta_cve= Twitter.compartir_id" 
                        ),
                      'fields' => array(
                          "nvl(Twitter.veces,0)   {$this->alias}__compartido_twitter"
                      ),
                      'type' =>'LEFT'
              ),
                 array(
                      'table' => '(select compartir_id,count (compartir_id) veces from tcompartir where compartir_tipo=1 and compartir_redsocial=3 group by compartir_id )',
                      'alias' => 'Linkedin',
                      'conditions' => array(
                              "$this->alias.oferta_cve= Linkedin.compartir_id" 
                        ),
                      'fields' => array(
                          "nvl(Linkedin.veces,0)   {$this->alias}__compartido_linkedin"
                      ),
                      'type' =>'LEFT'
              ),
                  array(
                      'table' => '(select compartir_id,count (compartir_id) veces from tcompartir where compartir_tipo=1 group by compartir_id )',
                      'alias' => 'VecesCompartido',
                      'conditions' => array(
                              "$this->alias.oferta_cve= VecesCompartido.compartir_id" 
                        ),
                      'fields' => array(
                          " nvl(VecesCompartido.veces,0)   {$this->alias}__compartido"
                      ),
                      'type' =>'LEFT'
              ),

                array(
                'alias' => 'Sueldo',
                'fields' => array("Sueldo.elsueldo_ini  {$this->alias}__sueldo"),
                'conditions' => array(
                  'Sueldo.elsueldo_cve = '.$this->alias.'.sueldo_cve '
                ),
                'table' => 'texplabsueldos',
                'type' => 'LEFT'
            ),
              $this->joins['ciudad'],
              $this->joins['estado']
        );

      $query['contain'] = array(
        'UsuarioEmpresa' => array(
          'fields' => array('cu_cve', 'cu_sesion', 'keycode')
        ),
        'Empresa' => array(
                'fields' =>array('cia_nombre') 
          )
      );
      $query['recursive'] = -1;
      return $query;
    }
    return $results;
  }


    protected function _findOferta($state, $query, $results = array()) {
      if ($state === 'before') {
          $this->virtualField= array(
          "to_char($this->alias.oferta_fecini,'DD/MM/YYYY')  {$this->alias}__publicacion" ,
          "to_char($this->alias.oferta_fecfin,'DD/MM/YYYY') {$this->alias}__finaliza"
          );        
       $query['joins'] = array_values($this->joins);
          $query['joins'][]=array(
                'alias' => 'Sueldo',
                'fields' => array("Sueldo.elsueldo_ini  {$this->alias}__sueldo"),
                'conditions' => array(
                  'Sueldo.elsueldo_cve = '.$this->alias.'.sueldo_cve '
                ),
                'table' => 'texplabsueldos',
                'type' => 'LEFT'
            );
          $query['joins'][] =array(
               'alias' => 'Contacto',
                'fields' => array(
                    "Contacto.con_nombre ||' '||Contacto.con_paterno||' '||Contacto.con_materno UsuarioEmpresa__nombre",
                    "Contacto.con_tel || decode(Contacto.con_ext,null,'',' ext.: ' )|| Contacto.con_ext UsuarioEmpresa__telefono "
                    ),
                'conditions' => array(
                  'Contacto.cu_cve = '.$this->alias.'.cu_cve '
                ),
                'table' => 'tcontacto',
                'type' => 'LEFT'

            );

          $query['contain'] = array(
        'Empresa',
        'Areas',
        'Postulacion',
        'UsuarioEmpresa'=>array(
                'fields' => array('cu_cve', 'cu_sesion')
          )
      );      
      $query['conditions']= array(
        "$this->alias.oferta_cve" => $query['idOferta']                     
      ); 
      if( Acceso::is()!=='admin' ){
        $query['conditions']["$this->alias.oferta_inactiva"] =0;
      }
      return $query;
    }
    return  !empty($results) ? $results[0]:$results ;
  }


  protected function _findInfo_completa($state, $query, $results = array()) {
    if ($state === 'before') {
      $query['joins'] = array_values($this->joins);

      $query['contain'] = array(
        'UsuarioEmpresa' => array(
          'fields' => array('cu_cve', 'cu_sesion', 'keycode')
        ),
        'Carpeta',
        'Etiquetas',
        'Areas'
      );

      $query['recursive'] = -1;

      return $query;
    }

    return $results;
  }

  protected function _findRecientes($state, $query, $results = array()) {
    if ($state === 'before') {
      $query['conditions'] = array_merge(array(
        'Oferta.oferta_fecfin >= CURRENT_DATE',
        'Oferta.oferta_inactiva = ' => 0,
        'Oferta.cu_cve' => $this->UsuarioEmpresa->getIds('dependents', array(
          'parent' => $query['fromUser']
        ))
      ), isset($query['conditions']) ? $query['conditions'] : array());

      $query['order'] = array(
        'Oferta.created' => 'DESC'
      );

      $query['limit'] = 4;
    }

    return $this->_findInfo_completa($state, $query, $results);
  }

  protected function _findA_vencer($state, $query, $results = array()) {
    if ($state === 'before') {
      $query['joins'] = array($this->joins['ciudad'], $this->joins['estado']);

      $days = isset($query['days']) ? $query['days'] : 5;

      // Campo virtual para calcular los días restantes.
      $this->virtualFields['dias'] = '(trunc(Oferta.oferta_fecfin) - trunc(CURRENT_DATE))';

      $query['conditions'] = array_merge(array(
        'Oferta.oferta_fecfin >= CURRENT_DATE',
        'Oferta.oferta_status >' => 0,
        $this->virtualFields['dias'] . ' <= ' => $days,
        'Oferta.oferta_inactiva = ' => 0,
        'Oferta.cu_cve' => $this->UsuarioEmpresa->getIds('dependents', array(
          'parent' => $query['fromUser']
        ))
      ), isset($query['conditions']) ? $query['conditions'] : array());

      if (!isset($query['order'])) {
        $query['order'] = array(
          'Oferta.oferta_fecfin' => 'ASC'
        );
      }

      $query['contain'] = array(
        'UsuarioEmpresa' => array(
          'fields' => array('cu_cve', 'cu_sesion', 'keycode')
        ),
        'Carpeta'
      );

      $query['recursive'] = -1;
      return $query;
    } else {
      /**
       * Se desactiva el campo virtual 'dias' para que no se calcule en otras búsquedas.
       */
      unset($this->virtualFields['dias']);
    }

    return $results;
  }

  protected function _findCompartidas($state, $query, $results = array()) {
    if ($state === 'before') {

      $query['conditions'] = array(
        'Oferta.oferta_fecfin >= CURRENT_DATE',
        'Oferta.oferta_publica' => 1,
        // 'Oferta.oferta_inactiva = ' => 0,
        'Oferta.cia_cve' => $query['fromCia']
      );

      $query['contain'] = array(
        'UsuarioEmpresa' => array(
          'fields' => array('cu_cve', 'cu_sesion', 'keycode')
        ),
        'Carpeta'
      );

      if (!isset($query['order'])) {
        $query['order'] = array(
          'Oferta.oferta_cve' => 'ASC'
        );
      }

      $query['recursive'] = -1;
      return $query;
    }

    return $results;
  }

  protected function _findDependientes($state, $query, $results = array()) {
    if ($state === 'before') {

      $parent = isset($query['parent']) ? $query['parent'] : -1;

      $query['conditions']['Oferta.cu_cve'] = $this->UsuarioEmpresa->getIds('dependents', array(
        'parent' => $parent
      ));

      $query['contain'] = array(
        'UsuarioEmpresa' => array(
          'fields' => array('cu_cve', 'cu_sesion', 'keycode')
        ),
        'Carpeta'
      );

      if (!isset($query['order'])) {
        $query['order'] = array(
          'Oferta.oferta_cve' => 'ASC'
        );
      }

      $query['recursive'] = -1;
      return $query;
    } elseif ($state === 'after') {

    }

    return $results;
  }

  protected function _findExpresion($state, $query, $results = array()) {
    if ($state === 'before') {
      $id = $query['oferta'];
      $query['fields'] = array(
        'Oferta.puesto_nom Oferta__puesto'
      );

      $query['conditions'] = array(
        'Oferta.oferta_cve' =>  $id
      );

      $query['joins'] = array(
        array(
          'alias' => 'Ciudad',
          'conditions' => array(
            'Ciudad.ciudad_cve = Oferta.ciudad_cve'
          ),
          'table' => 'tciudad',
          'type' => 'INNER'
        ),
        array(
          'alias' => 'Estado',
          'conditions' => array(
            'Ciudad.est_cve = Estado.est_cve'
          ),
          'fields' => array(
            'Estado.est_nom Oferta__estado'
          ),
          'table' => 'testado',
          'type' => 'INNER'
        ),
        array(
          'alias' => 'Areas',
          'conditions' => array(
            'Areas.oferta_cve = Oferta.oferta_cve'
          ),
          'fields' => array(
            'Areas.str Oferta__areas'
          ),
          'table' => '(SELECT
              OA.oferta_cve
            , listagg(A.area_nom, \', \') WITHIN GROUP (ORDER BY A.area_cve) as STR
            FROM tofertaxarea OA
            INNER JOIN tareas A ON (
              A.area_cve = OA.area_cve
            )
            WHERE OA.oferta_cve IN (' . implode(',', (array)$id). ')
            GROUP BY OA.oferta_cve)',
          'type' => 'LEFT'
        ),
        array(
          'alias' => 'Etiquetas',
          'conditions' => array(
            'Etiquetas.oferta_cve = Oferta.oferta_cve'
          ),
          'fields' => array(
            'Etiquetas.str Oferta__etiquetas'
          ),
          'table' => '(SELECT
              EO.oferta_cve
            , listagg(E.etiqueta_nombre, \', \') WITHIN GROUP (ORDER BY E.etiqueta_cve) as STR
            FROM tetiquetasxofertas EO
            INNER JOIN tetiquetas E ON (
              E.etiqueta_cve = EO.etiqueta_cve
            )
            WHERE EO.oferta_cve IN (' . implode(',', (array)$id). ')
            GROUP BY EO.oferta_cve)',
          'type' => 'LEFT'
        )
      );

      $query['recursive'] = -1;

      return $query;
    }

    $oferta = !empty($results[0]['Oferta']) ? $results[0]['Oferta'] : array();
    $results = implode(', ', array_values($oferta));

    return $results;
  }

  /**
   * Actualiza las fechas.
   * @return [type] [description]
   */
  protected function updateDates ($data = array()) {
    $date = new DateTime('NOW');
    $now = $date->format('Y-m-d H:i:s');
    /**
     * Si la oferta es distinguida el periodo de días es 10.
     * @var [type]
     */
    $period = $this->is('distinguida', !empty($data) ? $data : $this->data) ? 10 : 30;
    $endDate = $date->add(new DateInterval('P' . $period . 'D'))->format('Y-m-d H:i:s');

    if (empty($data)) {
      $this->data[$this->alias]['oferta_fecini'] = $now;
      $this->data[$this->alias]['oferta_fecfin'] = $endDate;
    } else {
      if (!empty($data[$this->alias])) {
        $data[$this->alias]['oferta_fecini'] = $now;
        $data[$this->alias]['oferta_fecfin'] = $endDate;
      } else {
        $data['oferta_fecini'] = $now;
        $data['oferta_fecfin'] = $endDate;
      }
    }

    return $data;
  }

  public function edit($id, $data = array()) {
    if (!empty($data[$this->alias]['etiquetas'])) {
      ClassRegistry::init('EtiquetasOferta')->deleteAll(array(
        $this->primaryKey => $id
      ));

      $data['Etiquetas'] = $this->Etiquetas->verificar(
        json_decode($data[$this->alias]['etiquetas']), $id
      );
    }

    if (!empty($data[$this->alias]['categorias'])) {
      $data['Areas'] = ClassRegistry::init('AreasOferta')->format(
        json_decode($data[$this->alias]['categorias']), $id
      );
    }

    $data[$this->alias][$this->primaryKey] = $id;

    return $this->saveAll($data/*, array('atomic' => false)*/);
  }

  public function beforeSave($options = array()) {
    if (!$this->issetId()) {
      $this->updateDates();
      $this->data[$this->alias]['oferta_inactiva'] = 0;
      $this->data[$this->alias]['oferta_publica'] = 0;
    } elseif (isset($this->data[$this->alias][$this->statusKey])) {
      /**
       * Al guardar, si existe el status de la oferta entre la información al guardar, necesitamos comparar
       * que el status es menor al que se va actualizar para así actualizar también las fechas.
       * @var [type]
       */
      $oldData = $this->find('first', array(
        'fields' => array(
          $this->primaryKey, $this->statusKey, 'oferta_fecini'
        ),
        'conditions' => array(
          $this->primaryKey => $this->id
        ),
        'recursive' => -1
      ));

      /**
       * Si el status actual de la oferta es menor, se actualizarán las fechas también...
       */
      if ($oldData[$this->alias][$this->statusKey] < $this->data[$this->alias][$this->statusKey]) {
        $this->updateDates();
      }
    }

    if (isset($this->cachedData['oferta_descrip'])) {
      $this->data[$this->alias]['oferta_resumen'] = substr($this->stripHtml($this->cachedData['oferta_descrip']),0,900);
    }

    return parent::beforeSave($options);
  }

  public function afterFind($results = array(), $primary = false) {
    foreach ($results as $key => $value) {
      if (isset($results[$key][$this->alias]['oferta_fecfin'])) {
        $now = new DateTime('NOW');
        $fecfin = new DateTime($results[$key][$this->alias]['oferta_fecfin']);
        $vigencia = $now->diff($fecfin);
        $results[$key][$this->alias]['vigencia'] = (int)$value[$this->alias][$this->statusKey] === 0
          ? '---' : ($vigencia->invert ? 0 : $vigencia->format('%R%a días'));
      }

      if (isset($results[$key][$this->alias][$this->statusKey])) {
        $index = array_keys($this->status)[$results[$key][$this->alias][$this->statusKey]];
        $results[$key][$this->alias]['status'] = array(
          'text' => $index,
          'value' => $this->status[$index]['value'],
          'html' => '<span class="'. $this->status[$index]['name'] . '">' . ucfirst($index) .'</span>'
        );
      }
    }
    return parent::afterFind($results, $primary);
  }

  /**
   * Actualiza carpeta_cve de la oferta.
   * @param  int $carpetaId id de la carpeta.
   * @param  int $ofertaId  id de la oferta, si no se pasa tomará $this->id.
   * @return boolean        Si se guardó satisfactoriamente.
   */
  public function guardarEnCarpeta($carpetaId, $ofertaId = null) {
    $ofertaId = $ofertaId ?: $this->id;
    if (!isset($ofertaId)) {
      throw new Exception("Error al cambiar datos de la oferta, id no especificado.");
    }

    return $this->updateAll(array(
      'carpeta_cve' => $carpetaId
    ), array(
      $this->primaryKey => $ofertaId
    ));
  }

  /**
   * Cambia el estado de una oferta, y actualiza la vigencia.
   * @param  integer  $id     Id. de la oferta
   * @param  integer  $status Status
   * @return boolean          Si se actualizó correctamente.
   */
  public function changeStatus($id, $status = 0) {
    $oferta = array(
      $this->primaryKey => $id,
      $this->statusKey => $status
    );

    if ($status > 0) {
      //$date = new DateTime('NOW');
      //$oferta['oferta_fecini'] = $date->format('Y-m-d H:i:s');
      //$oferta['oferta_fecfin'] = $date->add(new DateInterval('P30D'))->format('Y-m-d H:i:s');
      //
      $oferta = $this->updateDates($oferta);
    }

    return $this->save($oferta, false, array($this->statusKey, 'oferta_fecini', 'oferta_fecfin'));
  }

  /**
   * Cambia el campo 'oferta_inactiva' de una oferta.
   *    1 : Está pausada
   *    0 : Está activa
   *   -1 : Está inactiva (significa que la vigencia ya caducó [oferta_fecfin < CURRENT_DATE]).
   *   -2 : En papelera (incluye borrador)
   *   -3 : Eliminada Oculta (incluye borrador)
   * @param  [type]  $id      [description]
   * @param  integer $activar [description]
   * @return [type]           [description]
   */
  public function inactivar($id, $inactivar = 1) {
    return $this->updateAll(array(
      'oferta_inactiva' => (int)$inactivar
    ), array(
      $this->primaryKey => $id
    ));
  }

  public function compartir($id, $activar = true) {
    $oferta = array(
      $this->primaryKey => $id,
      'oferta_publica' => $activar ? 1 : 0
    );

    return $this->save($oferta, false, array('oferta_publica'));
  }

  /**
   * Obtiene el número de ofertas en determinado 'status'
   * @param  [type] $userId [description]
   * @return [type]         [description]
   */
  public function getStatusStats($userId, $ciaId, $requiredStats = array()) {
    $users = $this->UsuarioEmpresa->getIds('dependents', array(
      'parent' => $userId
    ));

    $users = implode(',', (array)$users);
    // Datos disponibles.
    $availableStats = array(
      // Ofertas Activas
      'a' => 'COUNT(CASE WHEN
        cu_cve IN ('. $users . ') AND
        oferta_status > 0 AND
        oferta_inactiva = 0 AND
        oferta_fecfin > CURRENT_DATE
        THEN 1 END) Oferta__activas',
      // Ofertas en borrador
      'b' => 'COUNT(CASE WHEN
        cu_cve IN ('. $userId . ') AND
        oferta_status = 0 AND
        oferta_inactiva = 0
        THEN 1 END) Oferta__borrador',
      // Ofertas compartidas
      'c' => 'COUNT(CASE WHEN
        oferta_publica = 1 AND
        oferta_fecfin > CURRENT_DATE
        THEN 1 END) Oferta__compartidas',
      // Ofertas distinguidas
      'd' => 'COUNT(CASE WHEN
        cu_cve IN ('. $users . ') AND
        oferta_status = 3 AND
        oferta_inactiva = 0 AND
        oferta_fecfin > CURRENT_DATE
        THEN 1 END) Oferta__distinguidas',
      // Ofertas eliminadas
      'e' => 'COUNT(CASE WHEN
        cu_cve IN ('. $users . ') AND
        oferta_inactiva = -2
        THEN 1 END) Oferta__eliminadas',
      // Ofertas inactivas
      'i' => 'COUNT(CASE WHEN
        cu_cve IN ('. $users . ') AND (
        oferta_inactiva = 1 OR
        oferta_inactiva = -1 OR
        (oferta_fecfin < CURRENT_DATE AND oferta_status > 0 AND oferta_inactiva > -2))
        THEN 1 END) Oferta__inactivas',
      // Ofertas publicadas
      'p' => 'COUNT(CASE WHEN
        cu_cve IN ('. $users . ') AND
        oferta_status = 1 AND
        oferta_inactiva = 0 AND
        oferta_fecfin > CURRENT_DATE
        THEN 1 END) Oferta__publicadas',
      // Ofertas recomendadas
      'r' => 'COUNT(CASE WHEN
        cu_cve IN ('. $users . ') AND
        oferta_status = 2 AND
        oferta_inactiva = 0 AND
        oferta_fecfin > CURRENT_DATE
        THEN 1 END) Oferta__recomendadas',
    );

    // Si es string, lo convertirá a array.
    $requiredStats = is_string($requiredStats) ? str_split($requiredStats) : $requiredStats;
    // Si el $requiredStats es vacío, se requiere de todos los campos. En caso contrario,
    // obtendrá los campos en base al array.
    $fields = empty($requiredStats) ? $availableStats : array_intersect_key(
      $availableStats, array_flip($requiredStats)
    );

    $stats = $this->find('first', array(
      'fields' => empty($fields) ? array_values($availableStats) : array_values($fields), // Obtiene los valores.
      'conditions' => array(
        'Oferta.cia_cve' => $ciaId
      ),
      'recursive' => -1
    ));

    return reset($stats);
  }

  /**
   * Obtiene los datos de una oferta para duplicarla. Desestableciendo algunos capos.
   * @param  [type] $ofertaId [description]
   * @return [type]           [description]
   */
  public function getCopy($ofertaId = null) {
    $v = $this->get($ofertaId, array(
      'recursive' => 1
    ));

    unset(
      $v['Oferta']['oferta_cve'],
      $v['Oferta']['oferta_cvealter'],
      $v['Oferta']['cu_cve'],
      $v['Oferta']['cu_cvereg'],
      $v['Oferta']['carpeta_cve'],
      $v['Oferta']['oferta_fecini'],
      $v['Oferta']['oferta_fecfin'],
      $v['Oferta']['oferta_publica'],
      $v['Oferta']['oferta_inactiva'],
      $v['Oferta']['status_text'],
      $v['Oferta']['status_class'],
      $v['Oferta']['created'],
      $v['Oferta']['modified']
    );

    $v['Oferta'][$this->statusKey] = 0;
    return $v;
  }

  /**
   * Checa el estado de una oferta. Puede ser de la BD si se pasa el id (debe ser númerico).
   * Si $id es un array, buscará la llave status.
   * @param  string  $type    [description]
   * @param  [type]  $data    [description]
   * @return boolean          [description]
   */
  public function is($type, $data = null) {
    $status = $this->getStatusFromData($data);

    if ($type === 'activa') {
      return $status > $this->getStatusType('borrador');
    }

    return $status === $this->getStatusType($type);
  }

  /**
   * Dependiendo del status de la oferta obtiene el tipo de crédito.
   * @param  mixed    $data     Se puede pasar un array de datos y buscará sobre esos datos. Si es int, buscará la oferta con ese id en la BD.
   * @param  [type] $typeStatus [description]
   * @return [type]             [description]
   */
  public function checkCredit($data, $typeStatus = null) {
    $creditType = false; // Por default, el tipo de crédito es false (no existe).

    $status = $this->getStatusFromData($data);

    /**
     * Si es borrador, no importa el tipo de crédito, por lo tanto regresa true
     * como si fuera un tipo de crédito infinito.
     */
    if ((int)$status === $this->getStatusType('borrador')) {
      $creditType = true;
    } else {
      /**
       * Buscará en los status por el tipo de crédito.
       * @var [type]
       */
      foreach ($this->status as $key => $v) {
        if ($v['value'] === (int)$status && isset($v['type'])) {
          $creditType = $v['type'];
          break;
        }
      }
    }

    return $creditType;
  }

  public function getStatusFromData($data) {
    $status = null;

    if (is_array($data)) {
      /**
       * En base a una Oferta, determinará su status.
       * $data['Oferta'] = array(...)
       */
      $status = isset($data[$this->alias]) ? $data[$this->alias][$this->statusKey] : $data[$this->statusKey];
    } elseif (is_numeric($data) || is_null($data)) {
      /*
       * Buscará la oferta en la base de datos en base al id.
       */
      if ($data) {
        $this->id = $data;
      }

      $status = (int)$this->field($this->statusKey);
    }

    return $status;
  }

  /**
   * Obtiene el valor de status de la oferta.
   * @param  mixed $searchType    Qué buscará.
   * @param  string $getType      Tipo de retorno.
   * @return mixed                El status [$getType = 'value' => int] [$getType = 'credit' => 'string']
   */
  public function getStatusType($searchType, $getType = 'value') {
    if ($getType === 'value' && isset($this->status[$searchType])) {
      return (int)$this->status[$searchType]['value'];
    } elseif ($getType === 'credit') {

    }

    return 0;
  }

  /**
   * Verfica si el id alterno es único.
   * @param  [type] $check [description]
   * @return [type]        [description]
   */
  public function uniqueAlterId($check) {
    $alterKey = 'oferta_cvealter';
    $alterId = $check[$alterKey];

    if ($this->issetId() && $this->data[$this->alias][$alterKey] === $alterId) {
      return true;
    }
    return !$this->hasAny(array(
      $this->alias . '.' . $alterKey => $alterId,
      $this->alias . '.' . 'cia_cve' => $this->data[$this->alias]['cia_cve']
    ));
  }

  /**
   * Remueve las etiquets HTML.
   * @param  [type] $html [description]
   * @return [type]       [description]
   */
  public function stripHtml($html) {
    /**
     * Expresión regular que antepone un espacio entre etiquetas:
     * <h3>Texto1</h3><span>Texto2</span>
     * <h3>Texto1</h3> <span>Texto2</span>
     * Para que cuando se remuevan las etiquetas el texto quede: "Texto1 Texto2".
     * @var [type]
     */
    $html = preg_replace('/(<\/[^>]+?>)(<[^>\/][^>]*?>)/', '$1 $2', $html);

    /**
     * Remueva las etiquetas HTML.
     * @var [type]
     */
    $html = strip_tags($html);
    $html = str_replace('&nbsp;', ' ', $html);
    $html = html_entity_decode($html);
    $html = preg_replace('/\s+/', ' ', $html);
    $html = trim($html);

    return $html;
  }


  public function format_to_share($network_s='facebook',$oferta){
    $of= $oferta[$this->alias];
    $dir=$oferta['Direccion'];

    $imgPath= Usuario::getPhotoPath($of['cia_cve'],'empresa');
    if($network_s==='twitter'){
      $file_name= WWW_ROOT. substr($imgPath,1);
      $name=basename($file_name);     
    }
 
    return    $network_s ==='facebook' ?array(
        'name' => $of['puesto_nom'],
        'description' => "$of[puesto_nom], $of[sueldo], $dir[ciudad] $dir[estado],  $of[oferta_link] " ,
        'picture' => "http://www.nuestroempleo.com.mx/$imgPath",
        'message' => $of['oferta_resumen'],
        'link' => $of['oferta_link']
        ): (  $network_s==='twitter' ?  array(
          'status' => "$of[puesto_nom], $of[sueldo], $dir[ciudad] $dir[estado],  $of[oferta_link] ",
          'media[]'=> "@{$file_name};type=image/jpeg;filename={$name}"
          )   :array() ) ; 

  }

  public function resetFolder($id) {
    return $this->updateAll(array(
      'carpeta_cve' => NULL
    ), array(
      'carpeta_cve' => $id
    ));
  }

  public static function prestaciones_str($json = '[]') {
    $arrayPrestaciones = json_decode($json);
    $prestaciones = ClassRegistry::init('Catalogo')->lista('prestaciones');
    $rs = array();
    if(!empty($arrayPrestaciones)){
      foreach ($arrayPrestaciones as $value) {
        $rs[] = $prestaciones[$value];
      }
    }

    return $rs;
  }
}