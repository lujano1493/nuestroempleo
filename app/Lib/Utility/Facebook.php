<?php 


	require_once(ROOT . DS . 'vendor' . DS . 'facebook' . DS . 'php-sdk-v4'. DS . 'src' . DS . 'Facebook' . DS . 'Entities'.DS.'AccessToken.php' );
	require_once(ROOT . DS . 'vendor' . DS . 'facebook' . DS . 'php-sdk-v4'. DS . 'src' . DS . 'Facebook' . DS . 'Entities'.DS.'SignedRequest.php' );

// added in v4.0.5
	require_once(ROOT . DS . 'vendor' . DS . 'facebook' . DS . 'php-sdk-v4'. DS . 'src' . DS . 'Facebook'.DS.'HttpClients'.DS.'FacebookHttpable.php' );
	require_once(ROOT . DS . 'vendor' . DS . 'facebook' . DS . 'php-sdk-v4'. DS . 'src' . DS . 'Facebook'.DS.'HttpClients'.DS.'FacebookCurl.php' );
	require_once(ROOT . DS . 'vendor' . DS . 'facebook' . DS . 'php-sdk-v4'. DS . 'src' . DS . 'Facebook'.DS.'HttpClients'.DS.'FacebookCurlHttpClient.php' );
	 
// added in v4.0.0
	require_once(ROOT . DS . 'vendor' . DS . 'facebook' . DS . 'php-sdk-v4'. DS . 'src' . DS . 'Facebook'.DS.'FacebookSession.php' );
	require_once(ROOT . DS . 'vendor' . DS . 'facebook' . DS . 'php-sdk-v4'. DS . 'src' . DS . 'Facebook'.DS.'FacebookRedirectLoginHelper.php' );
	require_once(ROOT . DS . 'vendor' . DS . 'facebook' . DS . 'php-sdk-v4'. DS . 'src' . DS . 'Facebook'.DS.'FacebookRequest.php' );
	require_once(ROOT . DS . 'vendor' . DS . 'facebook' . DS . 'php-sdk-v4'. DS . 'src' . DS . 'Facebook'.DS.'FacebookResponse.php' );
	require_once(ROOT . DS . 'vendor' . DS . 'facebook' . DS . 'php-sdk-v4'. DS . 'src' . DS . 'Facebook'.DS.'FacebookSDKException.php' );
	require_once(ROOT . DS . 'vendor' . DS . 'facebook' . DS . 'php-sdk-v4'. DS . 'src' . DS . 'Facebook'.DS.'FacebookRequestException.php' );
	require_once(ROOT . DS . 'vendor' . DS . 'facebook' . DS . 'php-sdk-v4'. DS . 'src' . DS . 'Facebook'.DS.'FacebookOtherException.php' );
	require_once(ROOT . DS . 'vendor' . DS . 'facebook' . DS . 'php-sdk-v4'. DS . 'src' . DS . 'Facebook'.DS.'FacebookAuthorizationException.php' );
	require_once(ROOT . DS . 'vendor' . DS . 'facebook' . DS . 'php-sdk-v4'. DS . 'src' . DS . 'Facebook'.DS.'GraphObject.php' );
	require_once(ROOT . DS . 'vendor' . DS . 'facebook' . DS . 'php-sdk-v4'. DS . 'src' . DS . 'Facebook'.DS.'GraphSessionInfo.php' );
 
use Entities\AccessToken;
use Entities\SignedRequest;

// added in v4.0.5
use HttpClients\FacebookHttpable;
use HttpClients\FacebookCurl;
use HttpClients\FacebookCurlHttpClient;
 
//added in v4.0.0
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookOtherException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\GraphSessionInfo;

	class Facebook {

		private $helper=null;
		private $session=null;

		public $loginUrl=null;
		public $logoutUrl=null;


		public function __construct($url= '' ){
			$this->urlredirect=Router::fullBaseUrl()."/admin/sociales/ofertas" ;
			$this->__getSession();
		}


		public  function __getSession(){
			Configure::load('facebook');
			$facebook_config=   Configure::read('Facebook');
			FacebookSession::setDefaultApplication($facebook_config['appId'], $facebook_config['secret']);
				 // login helper with redirect_uri
			$helper = new FacebookRedirectLoginHelper( $this->urlredirect );
			$session=null;
			// see if a existing session exists
			if ( isset( $_SESSION ) && isset( $_SESSION['fb_token'] ) ) {
			  // create new session from saved access_token
			  $session = new FacebookSession( $_SESSION['fb_token'] );
			  
			  // validate the access_token to make sure it's still valid
			  try {
			    if ( !$session->validate() ) {
			      $session = null;
			    }
			  } catch ( Exception $e ) {
			    // catch any exceptions
			    $session = null;
			  }
			}  
			 
			if ( !isset( $session ) || $session === null ) {
			  // no session exists
			  
			  try {

			    $session = $helper->getSessionFromRedirect();			    
			  } catch( FacebookRequestException $ex ) {
			    // When Facebook returns an error
			    // handle this better in production code
			    debug( $ex );
			  } catch( Exception $ex ) {
			    // When validation fails or other local issues
			    // handle this better in production code
			    debug( $ex );
			  }
			  
			}
			// see if we have a session
			if ( isset( $session ) ) {			  
			  // save the session
			  $_SESSION['fb_token'] = $session->getToken();
			  // create a session using saved token or the new one we generated at login
			  $session = new FacebookSession( $session->getToken() );			  						  			 
			 	 $this->logoutUrl=$helper->getLogoutUrl( $session, Router::fullBaseUrl()."/admin/sociales/logout_network");
			} 			
			else{
				 $this->loginUrl=$helper->getLoginUrl( array( 'email', 'user_friends' ) );
			}
			$this->session=$session;	
			$this->helper=$helper;

				
		}

		public function  login(){		
			return   $this->loginUrl;
		}
		public function logout($redirect=null){		
			// $helper = new FacebookRedirectLoginHelper( $redirect );
			 return  $this->logoutUrl; 
		}
	 public function  getIdUser(){	 
	 	$graphObject=$this->getPerfil();
		return !empty($graphObject)  ? $graphObject['id']: $graphObject;
	 }
	 public function getPerfil(){
	 		if(!$this->session || !($this->session instanceof FacebookSession) ){
	 		return false;
	 	}
			  // graph api request for user data
		$request = new FacebookRequest( $this->session, 'GET', '/me' );
		$response = $request->execute();
		  // get response
		$graphObject = $response->getGraphObject()->asArray();
		return $graphObject;
	 }
	 public function postLink($options=array(),$to='me'){
	 		if($this->session) {
				  try {

				    $response = (new FacebookRequest(
				      $this->session, 'POST', '/'+$to+'/feed', $options
				    ))->execute()->getGraphObject();

				   return $response->getProperty('id');

				  } catch(FacebookRequestException $e) {				  		
				  	$this->exception=$e;
				  	return null;
				  }   

			}
			return  -1;
	 }




		public static function _init(){
			// start session
			// session_start();
			
			Configure::load('facebook');
			 $facebook_config=   Configure::read('Facebook');
			FacebookSession::setDefaultApplication($facebook_config['appId'], $facebook_config['secret']);
				 // login helper with redirect_uri
			$helper = new FacebookRedirectLoginHelper( Router::fullBaseUrl()."/admin/sociales/ofertas"  );
			$session=null;
			// see if a existing session exists
			if ( isset( $_SESSION ) && isset( $_SESSION['fb_token'] ) ) {
			  // create new session from saved access_token
			  $session = new FacebookSession( $_SESSION['fb_token'] );
			  
			  // validate the access_token to make sure it's still valid
			  try {
			    if ( !$session->validate() ) {
			      $session = null;
			    }
			  } catch ( Exception $e ) {
			    // catch any exceptions
			    $session = null;
			  }
			}  
			 
			if ( !isset( $session ) || $session === null ) {
			  // no session exists
			  
			  try {

			    $session = $helper->getSessionFromRedirect();			    
			  } catch( FacebookRequestException $ex ) {
			    // When Facebook returns an error
			    // handle this better in production code
			    debug( $ex );
			  } catch( Exception $ex ) {
			    // When validation fails or other local issues
			    // handle this better in production code
			    debug( $ex );
			  }
			  
			}
			// see if we have a session
			if ( isset( $session ) ) {
			  
			  // save the session
			  $_SESSION['fb_token'] = $session->getToken();
			  // create a session using saved token or the new one we generated at login
			  $session = new FacebookSession( $session->getToken() );
			  
			  // graph api request for user data
			  $request = new FacebookRequest( $session, 'GET', '/me' );
			  $response = $request->execute();
			  // get response
			  $graphObject = $response->getGraphObject()->asArray();
			  
			  // print profile data
			  echo '<pre>' . debug( $graphObject, 1 ) . '</pre>';
			  
			  // print logout url using session and redirect_uri (logout.php page should destroy the session)
			  echo '<a href="' . $helper->getLogoutUrl( $session, Router::fullBaseUrl()."/admin/sociales/logout_network") . '">Logout</a>';
			  
			} else {
			  // show login url
			  echo '<a href="' . $helper->getLoginUrl( array( 'email', 'user_friends' ) ) . '">Login</a>';
			}	
			$_SESSION['fb_token'];			
			
		}



	}

?>