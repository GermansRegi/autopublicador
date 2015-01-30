<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Crons extends CI_Controller {

	public function index()
	{
		
	}
	public function cronPublishProgramations()
	{
		  $this->load->model("programations");
            $this->load->library('session');
            $this->load->model('social_users');
            $this->load->model('social_user_accounts');
            //querey programaciones vto publish  by time
              $programaciones=$this->programations->getProgramationsNow(array('state'=>'process'));
              
            foreach ($programaciones as $prog)
            {
                $responsefb=null;
                $responsetw=null;
                // si es facebook
                	if($prog->type_socialaccount=='user')
                    //query the page to publish de programation
                    	$account=$this->social_users->getUserappUsers(array('user_id'=>$prog->socialaccount,'user_app'=>$prog->user_app),1);
               	else
               		$account=$this->social_user_accounts->getUserappAccounts(array('idaccount'=>$prog->socialaccount,'user_app'=>$prog->user_app),1);


                    $params=array();
                    //si hi ha path
                    if(isset($prog->path) && $prog->path!="")
                    {
                    	if($prog->social_network=='tw')
                    	{
                    	    $params['media[]'] = "@{$prog->path}";
                    	    $url='statuses/update_with_media';
                    
                    	}
                    	else
                    	{
	                        $params['source']="@".$prog->path;
	                        $url="/".$prog->socialaccount."/photos";
	                   	}
                    }
                    else 
                    {
                    	if($prog->social_network=='tw')
                    	{
                    		$url='statuses/update';
                    		$params['status']=$prog->text;
                    	}
                    	else
                    	{
                    		$url="/".$prog->socialaccount."/feed";	
                    		$params['message']=$prog->text;
                    	}
                        
                    }
                    if(isset($prog->link) && $prog->link!="")
                   {
                       $params['link']=$prog->link;
                   }
                    
            	        
                    if($prog->social_network=='fb')
                    {
                    	$this->load->library('Facebooklib','','fblib');
                    	$this->fblib->setSessionfromToken($account[0]->access_token);
                    	try
                    	{
                    		echo "url: ".$url."<br>";
                    		var_dump($params);
                    		$publicaciofb=$this->fblib->api_post($url,$params);
                    		$state='finished';

                    	}
                    	catch(Exception $e)
                    	{

                    		$state='nocomplete';
                    	}

                    }
                   
                            
               	$id_publish='';
                    if(isset($publicaciofb) && $state=="finished")
                    {
                    	$id_publish=$responsefb['id'];
                        
                    }
                    else if(isset($responsetw) && $state=="finished")
                    {
                    	$id_publish=$responsetw->id_str;

                    }
                    $this->programations->update_by(array('id_publish'=>$id_publish,'state'=>$state),array('id'=>$prog->id));
                }
            
         
	}

}

/* End of file crons.php */
/* Location: ./application/modules/panel/controllers/crons.php */