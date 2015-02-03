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
            echo "date now: " .date('d-m-Y H:i:s',time())."<br>";
            date_default_timezone_set('London/Madrid');
            //querey programaciones vto publish  by time
              $programaciones=$this->programations->getProgramationsNow(array('state'=>'process','truncate((fecha/60),0) '=>floor(time()/60)));

              
            foreach ($programaciones as $prog)
            {
            	echo "date prog ".$prog->id. " date publish: ".date('d-m-Y H:i:s',$prog->fecha)."<br>";

                $responsefb=null;
                $responsetw=null;
                // si es facebook
                	if($prog->type_socialaccount=='user')
                    //query the page to publish de programation
                    	$account=$this->social_users->getUserappUsers(array('user_id'=>$prog->socialaccount,'user_app'=>$prog->user_app),1);
               	else
               		$account=$this->social_user_accounts->getUserappAccounts(array('idaccount'=>$prog->socialaccount,'user_app'=>$prog->user_app),1);


                    $params=array();
                    $file=false;
                    //si hi ha path
                    if(isset($prog->path) && $prog->path!="")
                    {
                    	$file=true;
                    	if($prog->social_network=='tw')
                    	{
                    	    $params['media'] = $prog->path;
                    	 	                    
                    	}

                    	else
                    	{
	                        $params['source']=$prog->path;
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
                    $publicaciofb=null;
                    $publicaciotw=null;
            	        
                    if($prog->social_network=='fb')
                    {
                    	$this->load->library('Facebooklib','','fblib');
                    	$this->fblib->setSessionfromToken($account[0]->access_token);
                    		//echo "url: ".$url."<br>";
                    		//var_dump($params);
                    		$publicaciofb=$this->fblib->api_post($url,$params);
                    		$state='finished';

                    		if(is_array($publicaciofb) && isset($publicaciofb['error']))
                    		{
                    			log_message('error',"eorror ".$publicaciofb['error']);
                    			$state='nocomplete';
                    		}
                    
                    }
                    else
                    {
                    	$this->load->library('Twitterlib','','twtlib');
					$this->twtlib->setAccessToken(json_decode($account[0]->access_token));
					if($file)
					{
						$publicaciotw=$this->twtlib->upload($params);
					}
					else
					{
						$publicaciotw=$this->twtlib->post($url,$params);
					}	
					$state='finished';

					var_dump($publicaciotw);
					if(is_array($publicaciotw) && isset($publicaciotw['error']))
               		{
               				log_message('error',"eorror ".$publicaciotw['error']);
               			$state='nocomplete';
               		}
                    

                    }
                   	if(isset($conf->fechaBorrado) && $state=="finished")
                   	{
                   		$state="toerase";
                   		log_message('error'." data esborrat".date('d-m-Y H:i:s',$conf->fechaBorrado));
                   	}
                            
               	$id_publish='';
                    if(is_object($publicaciofb) && $state=="finished")
                    {
                    	$id_publish=$responsefb['id'];
                        
                    }
                    else if(isset($publicaciotw['id_str']) && $state=="finished")
                    {
                    	$id_publish=$publicaciotw->id_str;


                    }
                    echo "resultat d publicciio: 	".$state;
                    $this->programations->update_by(array('id_publish'=>$id_publish/*,'state'=>$state*/	),array('id'=>$prog->id));
                    log_message("error","Programcion".$id_publish);
              	}
           }
            
         
	
	public function cronEraseProgramations()
	{
				  $this->load->model("programations");
            $this->load->library('session');
            $this->load->model('social_users');
            $this->load->model('social_user_accounts');
            //querey programaciones vto publish  by time
             $programaciones=$this->programations->getProgramationsNow(array('state'=>'toerase','truncate((fechaBorrado/60),0) '=>floor(time()/60)));
              
            foreach ($programaciones as $prog)
            {
            	var_dump($prog);
            	// eliminar la publicacio de la xarxa social
            	// posar estat finished en la programacio
            }
	}

}

/* End of file crons.php */
/* Location: ./application/modules/panel/controllers/crons.php */