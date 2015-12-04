<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once( APPPATH . 'modules/panel/libraries/GooglePlus/src/Google/autoload.php' );



class GooglePlus {
	
	public function __construct() {
		
		$CI =& get_instance();
		$CI->config->load('googleplus');
						
		$cache_path = $CI->config->item('cache_path');
		$GLOBALS['apiConfig']['ioFileCache_directory'] = ($cache_path == '') ? APPPATH .'cache/' : $cache_path;
		
		$this->client = new Google_Client();
		$this->client->setApplicationName($CI->config->item('application_name', 'googleplus'));
		$this->client->setClientId($CI->config->item('client_id', 'googleplus'));
		$this->client->setClientSecret($CI->config->item('client_secret', 'googleplus'));
		$this->client->setRedirectUri($CI->config->item('redirect_uri', 'googleplus'));
		$this->client->setDeveloperKey($CI->config->item('api_key', 'googleplus'));
		$this->client->setScopes($CI->config->item('scopes', 'googleplus'));
		$this->client->setRequestVisibleActions($CI->config->item('actions', 'googleplus'));	
		
		$this->plus = new Google_Service_Plus($this->client);
        $this->plusItemScope = new Google_Service_Plus_ItemScope();
        $this->moment = new Google_Service_Plus_Moment();
	}
	
	public function __get($name) {
		
		if(isset($this->plus->$name)) {
			return $this->plus->$name;
		}
		return false;
		
	}
	
	public function __call($name, $arguments) {
		
		if(method_exists($this->plus, $name)) {
			return call_user_func(array($this->plus, $name), $arguments);
		}
		return false;
		
	}
	 private $_gp_client;
    private $_gp_plus;
    private $_gp_moment;
    private $_gp_plusItemScope;

}
?>

