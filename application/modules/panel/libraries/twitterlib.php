<?php
/**
 * Twitter OAuth library.
 * Sample controller.
 * Requirements: enabled Session library, enabled URL helper
 * Please note that this sample controller is just an example of how you can use the library.
 */
defined('BASEPATH') OR exit('No direct script access allowed');
require_once( APPPATH . 'modules/panel/libraries/Twitter/Twitteroauth.php' );
class Twitterlib
{
	/**
	 * TwitterOauth class instance.
	 */
	private $connection;
	private $ci;
	
	/**
	 * Controller constructor
	 */
	function __construct()
	{
		//parent::__construct();
		// Loading TwitterOauth library. Delete this line if you choose autoload method.
		//$this->load->library('Twitter/twitteroauth');
		// Loading twitter configuration.
		$this->ci =& get_instance();
		$this->ci->config->load('twitter');
		$this->connection=new TwitterOauth();
		if($this->ci->session->userdata('access_token') && $this->ci->session->userdata('access_token_secret'))
		{
			// If user already logged in
			$this->connection=$this->connection->create($this->ci->config->item('twitter_consumer_token'), $this->ci->config->item('twitter_consumer_secret'), $this->ci->session->userdata('access_token'),  $this->ci->session->userdata('access_token_secret'));
		}
		elseif($this->ci->session->userdata('request_token') && $this->ci->session->userdata('request_token_secret'))
		{
			// If user in process of authentication
			$this->connection=$this->connection->create($this->ci->config->item('twitter_consumer_token'), $this->ci->config->item('twitter_consumer_secret'), $this->ci->session->userdata('request_token'), $this->ci->session->userdata('request_token_secret'));
		}
		else
		{
			// Unknown user
			$this->connection=$this->connection->create($this->ci->config->item('twitter_consumer_token'), $this->ci->config->item('twitter_consumer_secret'));
		}
	}
	public function getSession()
	{
		if($this->ci->session->userdata('access_token') && $this->ci->session->userdata('access_token_secret'))
		{
			// If user already logged in
				$content = $this->connection->get('account/verify_credentials');
				if(isset($content->errors))
				{
					// Most probably, authentication problems. Begin authentication process again.
					$this->reset_session();
					return false;
				}
				else
				{
					return $content;
				}
		}
		return false;
	}
	/**
	 * Here comes authentication process begin.
	 * @access	public
	 * @return	void
	 */
	public function auth($redirect_url)
	{
		if($this->ci->session->userdata('access_token') && $this->ci->session->userdata('access_token_secret'))
		{
			// User is already authenticated. Add your user notification code here.
			return true;
		}
		else
		{
			// Making a request for request_token
			$request_token = $this->connection->getRequestToken(base_url($redirect_url));
			$this->ci->session->set_userdata('request_token', $request_token['oauth_token']);
			$this->ci->session->set_userdata('request_token_secret', $request_token['oauth_token_secret']);
			
			if($this->connection->http_code == 200)
			{
				$url = $this->connection->getAuthorizeURL($request_token);
				return $url;
			}
			else
			{
				// An error occured. Make sure to put your error notification code here.
				return false;
			}
		}
	}
	
	/**
	 * Callback function, landing page for twitter.
	 * @access	public
	 * @return	void
	 */
	public function checkcallback()
	{
		if($this->ci->input->get('oauth_token') && $this->ci->session->userdata('request_token') !== $this->ci->input->get('oauth_token'))
		{
			return false;
		}
		else
		{
			$access_token = $this->connection->getAccessToken($this->ci->input->get('oauth_verifier'));
		
			if ($this->connection->http_code == 200)
			{
				$this->ci->session->set_userdata('access_token', $access_token['oauth_token']);
				$this->ci->session->set_userdata('access_token_secret', $access_token['oauth_token_secret']);
				$this->ci->session->set_userdata('twitter_user_id', $access_token['user_id']);
				$this->ci->session->set_userdata('twitter_screen_name', $access_token['screen_name']);

				$this->ci->session->unset_userdata('request_token');
				$this->ci->session->unset_userdata('request_token_secret');
				
				return true;
			}
			else
			{
				// An error occured. Add your notification code here.
				return false;
			}
		}
	}
	
	public function post($in_reply_to)
	{
		$message = $this->input->post('message');
		if(!$message || mb_strlen($message) > 140 || mb_strlen($message) < 1)
		{
			// Restrictions error. Notification here.
			redirect(base_url('/'));
		}
		else
		{
			if($this->ci->session->userdata('access_token') && $this->ci->session->userdata('access_token_secret'))
			{
				$content = $this->connection->get('account/verify_credentials');
				if(isset($content->errors))
				{
					// Most probably, authentication problems. Begin authentication process again.
					$this->reset_session();
					redirect(base_url('/twitter/auth'));
				}
				else
				{
					$data = array(
						'status' => $message,
						'in_reply_to_status_id' => $in_reply_to
					);
					$result = $this->connection->post('statuses/update', $data);

					if(!isset($result->errors))
					{
						// Everything is OK
						redirect(base_url('/'));
					}
					else
					{
						// Error, message hasn't been published
						redirect(base_url('/'));
					}
				}
			}
			else
			{
				// User is not authenticated.
				redirect(base_url('/twitter/auth'));
			}
		}
	}
	
	/**
	 * Reset session data
	 * @access	private
	 * @return	void
	 */
	private function reset_session()
	{
		$this->ci->session->unset_userdata('access_token');
		$this->ci->session->unset_userdata('access_token_secret');
		$this->ci->session->unset_userdata('request_token');
		$this->ci->session->unset_userdata('request_token_secret');
		$this->ci->session->unset_userdata('twitter_user_id');
		$this->ci->session->unset_userdata('twitter_screen_name');
	}
}

/* End of file twitter.php */
/* Location: ./application/controllers/twitter.php */