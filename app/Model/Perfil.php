<?php

class Perfil extends AppModel {

  /**
    * Nombre del Modelo
    */
	public $name = 'Perfil';

  /**
    * Nombre de la llave primaria, en este caso es cia_cve, tabla tcompania.
    */
  public $primaryKey = 'per_cve';

  /**
	 	* Tabla.
	 	*/
	public $useTable = 'tperfil';

  public $knows = array(
    'UsuarioEmpresa'
  );

  public function getProfile($userId, $ciaId, $perfilId = null) {
    if (!$perfilId) {
      $perfilId = $this->UsuarioEmpresa->field('per_cve', array(
        'UsuarioEmpresa.cu_cve' => $userId
      ));
    }

    $perfil = $this->find('first', array(
      'recursive' => -1,
      'fields' => array(
        'Perfil.per_cve',
        'Perfil.per_nom',
        'Perfil.per_descrip'
      ),
      'conditions' => array(
        $this->alias . '.per_cve' => $perfilId,
      ),
      'joins' => array(
        array(
          'table' => 'tperfilxmembresia',
          'alias' => 'PerfilMembresia',
          'type' => 'LEFT',
          'conditions' => array(
            'PerfilMembresia.per_cve = trunc(' . $perfilId . '/100)*100',
            'PerfilMembresia.cia_cve' => $ciaId
          ),
        ),
        array(
          'table' => 'tmembresias',
          'alias' => 'Membresia',
          'type' => 'LEFT',
          'conditions' => array(
            'Membresia.membresia_cve = PerfilMembresia.membresia_cve',
          ),
          'fields' => array(
            'NVL(Membresia.per_cve,100) Perfil__base_perfil',
            'NVL(Membresia.membresia_tipo,\'N\') Perfil__membresia_tipo',
            'NVL(Membresia.membresia_clase,\'mbs\') Perfil__membresia_cls',
            'NVL(CASE WHEN Membresia.per_cve=100 THEN \'Básica\' ELSE Membresia.membresia_nom END,\'Básica\') Perfil__membresia'
          )
        )
      ),
      'order' => array(
        'Membresia.membresia_tipo' => 'ASC'
      )
    ));

    return $perfil['Perfil'];
  }

	public function lista($min = 1, $max = 100) {
    return $this->get(null, 'list', array(
      'fields' => array('Perfil.per_cve', 'Perfil.per_descrip'),
      'conditions' => array(
        'Perfil.per_cve <' => $max,
        'Perfil.per_cve >' => $min
      )
    ));
  }

  public function afterFind($results, $primary = false) {
    if (!empty($results[0]['Perfil']['base_perfil'])) {
      $basePerfil = $results[0]['Perfil']['base_perfil'];
      $results[0]['Perfil']['base_perfil_str'] = Acceso::checkProfile($basePerfil);
    }

    if (!empty($results[0]['Perfil']['membresia_tipo'])) {
      $tipoMembresia = $results[0]['Perfil']['membresia_tipo'];
      $results[0]['Perfil']['is_promo'] = $tipoMembresia === 'P';
    }

    return parent::afterFind($results, $primary);
  }
}
