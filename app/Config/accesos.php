<?php

class AccesoConfig {

  /**
   * Perfiles de Nuestro Empleo y sus índices.
   * @var array
   */
  public static $profiles = array(
    'admin'   => array('min' =>   0, 'max' =>  99),
    'basic'   => array('min' => 100, 'max' => 199),
    'silver'  => array('min' => 200, 'max' => 299),
    'golden'  => array('min' => 300, 'max' => 399),
    'diamond' => array('min' => 400, 'max' => 499),
  );

  /**
   * Roles del usuario. Por ahora los manejaremos mediante índices, pero más adelante si es necesario
   * se puede crear como un array asociativo donde se especifiquen los rangos, como en los perfiles.
   * @var array
   */
  public static $roles = array(
    'admin',
    'coordinador',
    'reclutador'
  );

  public static $admin_roles = array(
    1 => 'superadmin',
    'admin',
    'contenidos',
    'tesoreria',
    'ventas',
  );

  /**
   * Reglas de acceso.
   * @var array
   */
  public static $rules = array(
    'mis_ofertas' => array(
      'basic' => 'admin',
      'silver' => 'admin',
      'golden' => '*',
      'diamond' => '*'
    ),
    'mis_candidatos' => array(
      'basic' => 'admin',
      'silver' => 'admin',
      'golden' => '*',
      'diamond' => '*'
    ),
    'mis_mensajes' => array(
      'basic' => 'admin',
      'silver' => 'admin',
      'golden' => '*',
      'diamond' => '*'
    ),
    'mis_evaluaciones' => array(
      'silver'  => 'admin',
      'golden'  => '*',
      'diamond' => '*'
    ),
    'mis_eventos' => array(
      'golden'  => '*',
      'diamond' => '*'
    ),
    'mis_cuentas' => array(
      'golden'  => 'admin coordinador',
      'diamond' => 'admin coordinador'
    ),
    'mis_productos' => array(
      '*'  => 'admin',
    ),
    'mis_reportes' => array(
      'silver'  => 'admin',
      'golden'  => 'admin coordinador',
      'diamond' => 'admin coordinador',
    )
  );

  public static $admin_rules = array(
    'empresas' => array(
      '*' => '*',
      'admin_convenios' => 'superadmin admin contenidos ventas',
    ),
    'convenios' => array(
      '*' => 'superadmin admin contenidos ventas',
    ),
    'cuentas' => array(
      '*' => 'superadmin admin',
    ),
    'productos' => array(
      '*' => 'superadmin admin',
    ),
    'facturas' => array(
      '*' => 'superadmin admin tesoreria',
    ),
    'reportes' => array(
      '*' => 'superadmin admin',
    ),
    'denuncias' => array(
      '*' => 'superadmin admin contenidos ventas',
    ),
    'sociales' => array(
      '*' => 'superadmin admin contenidos',
    )
  );
}
