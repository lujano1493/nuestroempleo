<?php

require_once(ROOT . DS . 'vendor' . DS . 'tomi-heiskanen' . DS .'twitteroauth' .DS .'twitteroauth'.DS.'twitteroauth.php');
   
  class Twitter{

  	private $temporary_credentials=null;
  	private $connection=null;
  	private $errors=null;

 	public function __construct($url_callback=null){
 		$url_callback= !$url_callback? Router::fullBaseUrl():$url_callback;
 		Configure::load('twitter');
		$twitter_config=   Configure::read('Twitter');
 		$token_credentials=null;
 		if( CakeSession::check("tw_token") ){
 			$token_credentials=CakeSession::read("tw_token");
 		}
 		if( CakeSession::check("tw_token_tempory")&& isset($_REQUEST['oauth_verifier'])  ){ 
 			$tw_token_tempory=CakeSession::read("tw_token_tempory");
 			CakeSession::delete("tw_token_tempory");
 			if(isset($tw_token_tempory['oauth_token']) && isset($tw_token_tempory['oauth_token']) ){
 				$this->connection = new TwitterOAuth($twitter_config['api_key'], $twitter_config['api_secret'], 
 				$tw_token_tempory['oauth_token'], $tw_token_tempory['oauth_token_secret']);
 				$token_credentials = $this->connection->getAccessToken($_REQUEST['oauth_verifier']);
 				CakeSession::write("tw_token",$token_credentials);

 			}
 		

 		}
 		if( !empty($token_credentials) && isset($token_credentials['oauth_token'])  && 
 				 isset($token_credentials['oauth_token_secret']) ){ 
 			$this->connection = new TwitterOAuth($twitter_config['api_key'], $twitter_config['api_secret'], 
 			$token_credentials['oauth_token'],$token_credentials['oauth_token_secret']);
 		}
 		if(!$this->connection ){
 			$this->connection= new TwitterOAuth($twitter_config['api_key'], $twitter_config['api_secret']);
    		$this->temporary_credentials=$this->connection->getRequestToken($url_callback);
    		CakeSession::write("tw_token_tempory",$this->temporary_credentials);
    	
 		}
	}


	public function login($sign_in_with_twitter=true){
		return $this->connection->getAuthorizeURL($this->temporary_credentials,$sign_in_with_twitter);
	}

	public function tweet($options=array()){
		$filename= WWW_ROOT."img/azul1.jpg";
		$name  = basename($filename);
		$options_=array(
				"status" => "mensaje generico para twitter numero 3"
			);
		$options=array_merge($options_,$options);
		if( !$this->getStatus()  ){
			return -1;
		}	
		$multi_file= isset($options['media[]']) ? true :false;   
		$statuses= $multi_file ? 'statuses/update_with_media' :' statuses/update';
		$content = $this->connection->post($statuses, $options,$multi_file );	
		if(isset($content->errors)){
			$this->errors=$content->errors;
			debug($content);	
			return null;

		}
		return $content;
	}

	public function getStatus(){
		$token_credentials=CakeSession::read("tw_token");
		return  !empty($token_credentials) && isset($token_credentials['oauth_token'])  && 
 				 isset($token_credentials['oauth_token_secret']);
	}

	public function getCredentials(){
		return $this->connection->get('account/verify_credentials');
	}

 } 



?>