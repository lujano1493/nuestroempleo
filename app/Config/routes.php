<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
  App::uses('MicrositioRoute', 'Routing/Route');

  Router::parseExtensions('json','pdf', 'xls', 'xml');

/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */

  Router::connect('/admin/iniciar_sesion/:key', array(
    'controller' => 'nuestro_empleo',
    'action' => 'iniciar_sesion',
  ), array(
    'pass' => array('key'),
    'key' => '[a-zA-Z0-9]+'
  ));

  Router::connect('/admin/:controller/:id', array(
    'admin' => 1, 'action' => 'ver'
  ), array(
    'pass' => array('id'),
    'id' => '[0-9]+'
  ));

  Router::connect('/admin/:controller/:slug-:id', array(
    'admin' => 1,
    'action' => 'ver'
  ), array(
    'pass' => array('id', 'slug'),
    'id' => '[0-9]+',
    'slug' => '[A-Za-z0-9-_]+'
  ));

  Router::connect('/admin/:controller/:id/:action/:keycode', array(
    'admin' => 1
  ), array(
    'pass' => array('id', 'keycode'),
    'id' => '[0-9]+',
    'keycode' => '[a-fA-F0-9]{40}',
  ));

  Router::connect('/admin/:controller/:slug-:id/:action', array(
    'admin' => 1
  ), array(
    'pass' => array('id', 'slug'),
    'id' => '[0-9]+',
    'slug' => '[A-Za-z0-9-_]+'
  ));

  Router::connect('/admin/:controller/:slug-:id/:action/:keycode', array(
    'admin' => 1
  ), array(
    'pass' => array('id', 'slug', 'keycode'),
    'id' => '[0-9]+',
    'keycode' => '[a-fA-F0-9]{40}',
    'slug' => '[A-Za-z0-9-_]+',
  ));

  Router::connect('/admin/:controller/:slug-:id/:action/:itemSlug-:itemId', array(
    'admin' => 1
  ), array(
    'pass' => array('id', 'slug', 'itemId', 'itemSlug'),
    'id' => '[0-9]+',
    'itemId' => '[0-9]+',
    'slug' => '[A-Za-z0-9-_]+',
    'itemSlug' => '[A-Za-z0-9-_]+'
  ));

  Router::connect('/admin/:controller/:slug-:id/:action/:itemId/:subaction', array(
    'admin' => 1
  ), array(
    'pass' => array('id', 'slug', 'itemId', 'subaction'),
    'slug' => '[A-Za-z0-9-_]+',
    'id' => '[0-9]+',
    'itemId' => '[0-9-]+|([0-9-]+PROMO$)', // Acepta números y guiones 000-000
    'subaction' => '[A-Za-z0-9-_]+'
  ));

  Router::connect('/admin/:controller/:slug-:id/:action/*', array(
    'admin' => 1
  ), array(
    'pass' => array('id', 'slug'),
    'id' => '[0-9]+',
    'slug' => '[A-Za-z0-9-_]+',
  ));

  Router::connect('/admin/facturas/:id/:action/:name', array(
    'admin' => 1,
    'controller' => 'facturas',
  ), array(
    'pass' => array('id', 'name'),
    'id' => '[0-9]+',
    'action' => 'descargar|comprobante',
    'name' => '[A-Za-z0-9-_.]+',
  ));

  Router::connect('/admin/:controller/:id/:action/:itemSlug-:itemId', array(
    'admin' => 1
  ), array(
    'pass' => array('id', 'itemId', 'itemSlug'),
    'id' => '[0-9]+',
    'itemSlug' => '[A-Za-z0-9-_]+',
    'itemId' => '[0-9-]+',
  ));

  Router::connect('/admin/:controller/:id/:action/*', array(
    'admin' => 1
  ), array(
    'pass' => array('id'),
    'id' => '[0-9]+'
  ));

  /**
   * Configuracion para microSitios
   */
  Router::connect('/:compania/:controller/:action', array(
    // 'action' => 'index'
  ), array(
    'pass' => array(),
    'compania' => '[a-zA-Z0-9]+',
    'routeClass' => 'MicrositioRoute'
  ));

  Router::connect('/:compania/:controller/:id/:action/*', array(
    // 'action' => 'index'
  ), array(
    'pass' => array('id'),
    'compania' => '[a-zA-Z0-9]+',
    'id' => '[0-9]+|^{{[\sa-zA-Z.=]+}}$',
    'routeClass' => 'MicrositioRoute'
  ));

  Router::connect('/:compania/:controller/:action/*', array(
    // 'action' => 'index'
  ), array(
    'pass' => array(),
    'compania' => '[a-zA-Z0-9]+',
    'routeClass' => 'MicrositioRoute'
  ));

  Router::connect('/', array('controller' => 'informacion', 'action' => 'index'));
  Router::connect('/planes', array('controller' => 'empresas', 'action' => 'planes'));

  Router::connect('/cerrar_sesion', array('controller' => 'nuestro_empleo', 'action' => 'cerrar_sesion'));
  Router::connect('/terminos_condiciones', array('controller' => 'informacion', 'action' => 'terminos_condiciones'));
  Router::connect('/aviso_privacidad', array('controller' => 'informacion', 'action' => 'aviso_privacidad'));

  Router::connect('/tickets/:ticket_:type', array('controller'=> 'tickets', 'action' => 'index'), array(
    'pass' => array('ticket', 'type'),
    'ticket' => '[0-9a-fA-F]+',
    'type' => '[ace]?'
  ));

  Router::connect('/:controller/:id', array('admin' => 0, 'action' => 'ver', 'slug' => false), array(
    'pass' => array('id', 'slug'),
    'id' => '[0-9]+',
    'slug' => '[A-Za-z0-9-_]+'
  ));

  Router::connect('/:controller/:slug-:id', array('admin' => 0, 'action' => 'ver'), array(
    'pass' => array('id', 'slug'),
    'id' => '[0-9]+',
    'slug' => '[A-Za-z0-9-_]+'
  ));

  Router::connect('/:controller/:slug-:id/:action', array('admin' => 0), array(
    'pass' => array('id', 'slug'),
    'id' => '[0-9]+',
    'slug' => '[A-Za-z0-9-_]+'
  ));

  Router::connect('/:controller/:slug-:id/:action/:keycode', array('admin' => 0), array(
    'pass' => array('id', 'slug', 'keycode'),
    'id' => '[0-9]+',
    'keycode' => '[a-fA-F0-9]{40}',
    'slug' => '[A-Za-z0-9-_]+',
  ));

  Router::connect('/:controller/:action/:itemSlug-:itemId', array('admin' => 0, 'id' => false, 'slug' => false), array(
    'pass' => array('id', 'slug', 'itemId', 'itemSlug'),
    'id' => '[0-9]+',
    'slug' => '[A-Za-z0-9-_]+',
    'itemId' => '[0-9]+',
    'itemSlug' => '[A-Za-z0-9-_]+'
  ));

  Router::connect('/:controller/:id/:action/:itemId', array('admin' => 0, 'slug' => false, 'itemSlug' => false), array(
    'pass' => array('id', 'slug', 'itemId', 'itemSlug'),
    'id' => '[0-9]+',
    'itemId' => '[0-9]+',
    'slug' => '[A-Za-z0-9-_]+',
    'itemSlug' => '[A-Za-z0-9-_]+'
  ));

  Router::connect('/:controller/:id/:action/:itemSlug-:itemId', array('admin' => 0, 'slug' => false), array(
    'pass' => array('id', 'slug', 'itemId', 'itemSlug'),
    'id' => '[0-9]+',
    'itemId' => '[0-9]+',
    'slug' => '[A-Za-z0-9-_]+',
    'itemSlug' => '[A-Za-z0-9-_]+'
  ));

  Router::connect('/:controller/:slug-:id/:action/:itemId', array('admin' => 0, 'itemSlug' => false), array(
    'pass' => array('id', 'slug', 'itemId', 'itemSlug'),
    'id' => '[0-9]+',
    'itemId' => '[0-9]+',
    'slug' => '[A-Za-z0-9-_]+',
    'itemSlug' => '[A-Za-z0-9-_]+'
  ));

  Router::connect('/:controller/:slug-:id/:action/:itemSlug-:itemId', array('admin' => 0), array(
    'pass' => array('id', 'slug', 'itemId', 'itemSlug'),
    'id' => '[0-9]+',
    'itemId' => '[0-9]+',
    'slug' => '[A-Za-z0-9-_]+',
    'itemSlug' => '[A-Za-z0-9-_]+'
  ));

  Router::connect('/:controller/:id/:action/*', array(
    'admin' => 0,
    // 'action' => 'index' [0-9{}=it.idOferta]+
  ), array(
    'pass' => array('id'),
    'id' => '[0-9]+|^{{[\sa-zA-Z.=]+}}$'
  ));

  // Router::connect('/:controller/:id/:action/*', array('admin' => 0), array(
  //   'pass' => array('id'),
  //   'id' => '[0-9]+'
  // ));

/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
  Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));


/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
  CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
  require CAKE . 'Config' . DS . 'routes.php';