<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if ( session_status() == PHP_SESSION_NONE ) {
  session_start();
}
// Autoload the required files
require_once( APPPATH . 'modules/panel/libraries/facebook/vendor/autoload.php' );

use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookSession;
use Facebook\FacebookRequest;


class Facebooklib {
  var $ci;
  var $helper;
  var $session;
  var $helperjs;
  var $permissions;

  public function __construct() {

    $this->ci =& get_instance();
    $this->permissions = $this->ci->config->item('permissions', 'facebook');


    // Initialize the SDK
    FacebookSession::setDefaultApplication( $this->ci->config->item('api_id', 'facebook'), $this->ci->config->item('app_secret', 'facebook') );

    // Create the login helper and replace REDIRECT_URI with your URL
    // Use the same domain you set for the apps 'App Domains'
    // e.g. $helper = new FacebookRedirectLoginHelper( 'http://mydomain.com/redirect' );
   // $this->helperjs=new FacebookJavascriptLoginHelper
    $this->helper = new FacebookRedirectLoginHelper( base_url().$this->ci->config->item('redirect_url', 'facebook') );
 //   var_dump($this->ci->session->userdata('fb_token'));
    if ( $this->ci->session->userdata('fb_token') ) {
      $this->session = new FacebookSession( $this->ci->session->userdata('fb_token') );

      // Validate the access_token to make sure it's still valid
      try {
        if ( ! $this->session->validate() ) {
          $this->session = null;
        }
      } catch ( Exception $e ) {
        // Catch any exceptions
        $this->session = null;
      }
    } else {
      // No session exists
      try {
        $this->session = $this->helper->getSessionFromRedirect();
      } catch( FacebookRequestException $ex ) {
        // When Facebook returns an error
      } catch( Exception $ex ) {
        // When validation fails or other local issues
      }
    }

    if ( $this->session ) {
      $this->ci->session->set_userdata( 'fb_token', $this->session->getToken() );

      $this->session = new FacebookSession( $this->session->getToken() );
    }
  }
  public function setSession($fb_token="")
  {

  	$this->ci->session->set_userdata('fb_token',false);
  	//$this->session = new FacebookSession( $this->ci->session->userdata('fb_token') );
  }
  public function setSessionfromToken($fb_token)
  {

  	$this->session = new FacebookSession( $fb_token );
  }
  /**
   * Returns the login URL.
   */
  public function getSession()
  {
  	return $this->session;
  }
  public function login_url() {
    $url=$this->helper->getLoginUrl( $this->permissions );
    redirect($url);
  }

  /**
   * Returns the current user's info as an array.
   */
  public function get_user() {
    if ( $this->session ) {
      /**
       * Retrieve User’s Profile Information
       */
      // Graph API to request user data
      $request =  new FacebookRequest( $this->session, 'GET', '/me' ) ;
      $request->execute();

      // Get response as an array
      $user = $request->getGraphObject()->asArray();

      return $user;
    }
    return false;
  }
  public function api_post($path,$params=array())
  {
	  if ( $this->session ) {
      /**
       * Retrieve User’s Profile Information
       */
      $params=array_merge($params,array('locale'=>"es_ES"));
      try{
      // Graph API to request user data
	      $request =  new FacebookRequest( $this->session, 'post', $path ,$params) ;
	      $response=$request->execute();
	      $user = $response->getGraphObject()->asArray();
	      return $user;
 	}catch( Exception $e)
 	{
 	
 		return array('error'=>$this->TRanlateAPIERROR($e->getHttpStatusCode()));
 	}
      // Get response as an array
      

      
 	}
 	return false;
  }
  public function api($path,$params=array(),$method='GET')
  {
  	
  	  if ( $this->session ) {
      /**
       * Retrieve User’s Profile Information
       */
      // Graph API to request user data
      $request =  new FacebookRequest( $this->session, $method, $path ) ;
      $response=$request->execute();

      // Get response as an array
      $user = $response->getGraphObject()->asArray();

      return $user;
    }
    return false;
  }
 	public $errorArray=array(500=>"No puede publicar el mismo contenido más de una vez",
 				200=>"No tiene permisos para publicar en ésta página o la página ya no existe.");

 		
  	public function TRanlateAPIERROR($error,$page=null)
     {
     	if($error>200 && $error>=299)
     		return $this->errorArray[200];
     	else if(array_key_exists($error, $this->errorArray))
     		return $errorArray[$error];
          else     
            return "Ha ocurrido un error en la publicación";
        
    }
    public function validatePerms()
    {
	    	if($this->session)
	    	{
	    		echo "pp";
	    			$valid=true;
				$perms=$this->api('/me/permissions');    		
	//			var_dump($perms);
				foreach ($this->permissions as $perm) {
					if(!array_key_exists($perm, $perms))
					{
						$valid=false;
						break;
					}
					

				}
				//var_dump($valid);
				return $valid;
	    	}
	    	return false;
    }
     
}