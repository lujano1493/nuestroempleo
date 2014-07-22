<?php
/**
 * This is email configuration file.
 *
 * Use it to configure email transports of Cake.
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
 * @since         CakePHP(tm) v 2.0.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 *
 * Email configuration class.
 * You can specify multiple configurations for production, development and testing.
 *
 * transport => The name of a supported transport; valid options are as follows:
 *		Mail 		- Send using PHP mail function
 *		Smtp		- Send using SMTP
 *		Debug		- Do not send the email, just return the result
 *
 * You can add custom transports (or override existing transports) by adding the
 * appropriate file to app/Network/Email. Transports should be named 'YourTransport.php',
 * where 'Your' is the name of the transport.
 *
 * from =>
 * The origin email. See CakeEmail::from() about the valid values
 *
 */
class EmailConfig {

	public $default = array(
		'transport' => 'Mail',
		'from' => 'you@localhost',
		//'charset' => 'utf-8',
		//'headerCharset' => 'utf-8',
	);




  public $igenter= array(
    'host' =>'mail.igenter.com',
    'port' => 25,
    'username' => 'no_reply@igenter.com',
    'password' => 'yGvLnPopOjnj',
    'transport' => 'Smtp',
    'charset' => 'utf-8',
    'headerCharset' => 'utf-8',
  );

  public $hitenlinea=array(
        'host' =>'mail.hitenlinea.com',
        'port' => 25,
        'username' => 'noreply@hitenlinea.com',
        'password' => '1T3q5W4t8H',
        'transport' => 'Smtp',
        'charset' => 'utf-8',
        'headerCharset' => 'utf-8',

    );


  public $nuestroempleo=array(
       'host' =>'mail.nuestroempleo.com.mx',
        'port' => 2525,
        'username' => 'notificaciones.ne@nuestroempleo.com.mx',
        'password' => '5N2mn2mbMc',
        'transport' => 'Smtp',
        'charset' => 'utf-8',
        'headerCharset' => 'utf-8',
    );


    public $nuestroempleo_gmail = array(
        'host' => 'ssl://smtp.gmail.com',
        'timeout'=>'30', 
        'port' => 465,
        'transport' => 'Smtp',
        'from' => "registro_ne1@nuestroempleo.com.mx",
        'username' => 'nuestroempleoregistra@gmail.com',
        'password' => 'nuestroempleore123'
    );


 public $encuesta= array(
    'host' =>'mail.nuestroempleo.com.mx',
    'port' => 25,    
    'username' => 'encuesta.ne@nuestroempleo.com.mx',
    'password' => 'O3b6B9r2M3c2',
    'transport' => 'Smtp',
    'timeout'=>'30', 
    'auth' => true,
    'log' => true
  );


 public $registra1= array(
    'host' =>'mail.nuestroempleo.com.mx',
    'port' => 25,
    'username' => 'registro_ne1@nuestroempleo.com.mx',
    'password' => 'Hg48Y535D7B9',
    'transport' => 'Smtp',
    'timeout'=>'30', 
    'auth' => true,
    'log' => true
  );

    public $registra2= array(
    'host' =>'mail.nuestroempleo.com.mx',
    'port' => 25,
    'username' => 'registro_ne2@nuestroempleo.com.mx',
    'password' => 'Hg48Y535D7B9',
    'transport' => 'Smtp',
    'timeout'=>'30', 
    'auth' => true,
    'log' => true
  );

   public $registra3= array(
    'host' =>'mail.nuestroempleo.com.mx',
    'port' => 25,
    'username' => 'registro_ne3@nuestroempleo.com.mx',
    'password' => 'Hg48Y535D7B9',
    'transport' => 'Smtp',
    'timeout'=>'30', 
    'auth' => true,
    'log' => true
  );


  public $registra4= array(
    'host' =>'mail.nuestroempleo.com.mx',
    'port' => 25,
    'username' => 'registro_ne4@nuestroempleo.com.mx',
    'password' => 'Hg48Y535D7B9',
    'transport' => 'Smtp',
    'timeout'=>'30', 
    'auth' => true,
    'log' => true
  );


  public $registra5= array(
    'host' =>'mail.nuestroempleo.com.mx',
    'port' => 25,
    'username' => 'registro_ne5@nuestroempleo.com.mx',
    'password' => 'Hg48Y535D7B9',
    'transport' => 'Smtp',
    'timeout'=>'30', 
    'auth' => true,
    'log' => true
  );



   public $registra6= array(
    'host' =>'mail.nuestroempleo.com.mx',
    'port' => 25,
    'username' => 'registro_ne6@nuestroempleo.com.mx',
    'password' => 'Hg48Y535D7B9',
    'transport' => 'Smtp',
    'timeout'=>'30', 
    'auth' => true,
    'log' => true
  );

  public $registra7= array(
    'host' =>'mail.nuestroempleo.com.mx',
    'port' => 25,
    'username' => 'registro_ne7@nuestroempleo.com.mx',
    'password' => 'Hg48Y535D7B9',
    'transport' => 'Smtp',
    'timeout'=>'30', 
    'auth' => true,
    'log' => true
  );

  public $registra8= array(
    'host' =>'mail.nuestroempleo.com.mx',
    'port' => 25,
    'username' => 'registro_ne8@nuestroempleo.com.mx',
    'password' => 'Hg48Y535D7B9',
    'transport' => 'Smtp',
    'timeout'=>'30', 
    'auth' => true,
    'log' => true
  );

   public $registra9= array(
    'host' =>'mail.nuestroempleo.com.mx',
    'port' => 25,
    'username' => 'registro_ne9@nuestroempleo.com.mx',
    'password' => 'Hg48Y535D7B9',
    'transport' => 'Smtp',
    'timeout'=>'30', 
    'auth' => true,
    'log' => true
  );

  public $registra10= array(
    'host' =>'mail.nuestroempleo.com.mx',
    'port' => 25,
    'username' => 'registro_ne10@nuestroempleo.com.mx',
    'password' => 'Hg48Y535D7B9',
    'transport' => 'Smtp',
    'timeout'=>'30', 
    'auth' => true,
    'log' => true
  );



   public $registra11= array(
    'host' =>'mail.nuestroempleo.com.mx',
    'port' => 25,
    'username' => 'registro_ne11@nuestroempleo.com.mx',
    'password' => 'Hg48Y535D7B9',
    'transport' => 'Smtp',
    'timeout'=>'30', 
    'auth' => true,
    'log' => true
  );

    public $registra12= array(
    'host' =>'mail.nuestroempleo.com.mx',
    'port' => 25,
    'username' => 'registro_ne12@nuestroempleo.com.mx',
    'password' => 'Hg48Y535D7B9',
    'transport' => 'Smtp',
    'timeout'=>'30', 
    'auth' => true,
    'log' => true
  );

   public $registra13= array(
    'host' =>'mail.nuestroempleo.com.mx',
    'port' => 25,
    'username' => 'registro_ne13@nuestroempleo.com.mx',
    'password' => 'Hg48Y535D7B9',
    'transport' => 'Smtp',
    'timeout'=>'30', 
    'auth' => true,
    'log' => true
  );


  public $registra14= array(
    'host' =>'mail.nuestroempleo.com.mx',
    'port' => 25,
    'username' => 'registro_ne14@nuestroempleo.com.mx',
    'password' => 'Hg48Y535D7B9',
    'transport' => 'Smtp',
    'timeout'=>'30', 
    'auth' => true,
    'log' => true
  );


  public $registra15= array(
    'host' =>'mail.nuestroempleo.com.mx',
    'port' => 25,
    'username' => 'registro_ne15@nuestroempleo.com.mx',
    'password' => 'Hg48Y535D7B9',
    'transport' => 'Smtp',
    'timeout'=>'30', 
    'auth' => true,
    'log' => true
  );



   public $registra16= array(
    'host' =>'mail.nuestroempleo.com.mx',
    'port' => 25,
    'username' => 'registro_ne16@nuestroempleo.com.mx',
    'password' => 'Hg48Y535D7B9',
    'transport' => 'Smtp',
    'timeout'=>'30', 
    'auth' => true,
    'log' => true
  );

  public $registra17= array(
    'host' =>'mail.nuestroempleo.com.mx',
    'port' => 25,
    'username' => 'registro_ne17@nuestroempleo.com.mx',
    'password' => 'Hg48Y535D7B9',
    'transport' => 'Smtp',
    'timeout'=>'30', 
    'auth' => true,
    'log' => true
  );

  public $registra18= array(
    'host' =>'mail.nuestroempleo.com.mx',
    'port' => 25,
    'username' => 'registro_ne18@nuestroempleo.com.mx',
    'password' => 'Hg48Y535D7B9',
    'transport' => 'Smtp',
    'timeout'=>'30', 
    'auth' => true,
    'log' => true
  );

   public $registra19= array(
    'host' =>'mail.nuestroempleo.com.mx',
    'port' => 25,
    'username' => 'registro_ne19@nuestroempleo.com.mx',
    'password' => 'Hg48Y535D7B9',
    'transport' => 'Smtp',
    'timeout'=>'30', 
    'auth' => true,
    'log' => true
  );

  public $registra20= array(
    'host' =>'mail.nuestroempleo.com.mx',
    'port' => 25,
    'username' => 'registro_ne20@nuestroempleo.com.mx',
    'password' => 'Hg48Y535D7B9',
    'transport' => 'Smtp',
    'timeout'=>'30', 
    'auth' => true,
    'log' => true
  );

	public $fast = array(
		'from' => 'you@localhost',
		'sender' => null,
		'to' => null,
		'cc' => null,
		'bcc' => null,
		'replyTo' => null,
		'readReceipt' => null,
		'returnPath' => null,
		'messageId' => true,
		'subject' => null,
		'message' => null,
		'headers' => null,
		'viewRender' => null,
		'template' => false,
		'layout' => false,
		'viewVars' => null,
		'attachments' => null,
		'emailFormat' => null,
		'transport' => 'Smtp',
		'host' => 'localhost',
		'port' => 25,
		'timeout' => 30,
		'username' => 'user',
		'password' => 'secret',
		'client' => null,
		'log' => true,
		//'charset' => 'utf-8',
		//'headerCharset' => 'utf-8',
	);

}
