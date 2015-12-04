<?php
class GoogleplusLib {
	
 
    private $_gp_client;
    private $_gp_plus;
    private $_gp_moment;
    private $_gp_plusItemScope;
    private $CI;
    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->library('session');
        $this->CI->load->helper('url');
        $this->CI->load->library('GooglePlus','','googleplus');
        

        $this->_gp_client = $this->CI->googleplus->client;
        $this->_gp_plus = $this->CI->googleplus->plus;
        $this->_gp_moment = $this->CI->googleplus->moment;
        $this->_gp_plusItemScope = $this->CI->googleplus->plusItemScope;
        if($this->getSession()!=null)
        {
            $this->setSessionFromToken($this->CI->session->userdata('gpsesion'));
        }
        else
        {
            try {

                $this->_gp_client->authenticate($this->CI->input->get_post('code'));
                $this->_gp_client->setAccessType("offline");
                $access_token = $this->_gp_client->getAccessToken();
                $this->CI->session->set_userdata('gpsesion', $access_token);
            } catch (Google_Auth_Exception $e) {
                print_r($e);
            }
            
        }
    }
    public function getSession()
    {
    	return ($this->CI->session->userdata('gpsesion')==null?null:$this->CI->session->userdata('gpsesion'));
    }
    public function setSessionFromToken($token)
    {
    	$this->_gp_client->setAccessToken($token);
    }
    public function getLoginUrl()
    {

    	return $this->_gp_client->createAuthUrl();
        
    }
    public function auth()
    {
    	 try {

                $this->_gp_client->authenticate($this->CI->input->get_post('code'));
                $access_token = $this->_gp_client->getAccessToken();
                $this->CI->session->set_userdata('gpsesion', $access_token);
            } catch (Google_Auth_Exception $e) {
                print_r($e);
            }
    }
}