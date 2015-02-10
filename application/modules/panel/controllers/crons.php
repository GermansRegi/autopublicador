<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Crons extends CI_Controller {
	
	public function __construct()
	{
			parent::__construct();
		$this->load->library('session');
	}

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
            //date_default_timezone_set('London/Madrid');
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

	public function cronRssFeed()
	{
		$this->load->model('rss_model');

		$this->load->model('social_user_accounts');
		$this->load->model('social_users');
		$rsss=$this->rss_model->get_all();
		  //agafo totes les confguracions per publicar cada x tempsdel la bd
		foreach ($rsss as $rss)
		{
			
			
			$rawFeed = file_get_contents($rss->url_rss);


		                     //   var_dump($xml->channel->lastBuildDate[0]);
			$md5Updaterssfeed=md5($rawFeed);

			if(isset($rss->md5lastupdate) && $rss->md5lastupdate!="")
			{

				if($rss->md5lastupdate!=$md5Updaterssfeed)
				{
					try{
						$xml = new SimpleXmlElement($rawFeed);
					}catch(Exception $e)
					{
						continue;
					}
					$timeUpdateitem=strtotime($xml->channel->item->pubDate[0]);
					$itemTopublish=$xml->channel->item;
					foreach ($xml->channel->item  as $item) {

						if(strtotime($item->pubDate[0])>$timeUpdateitem)
						{
							$timeUpdateitem=strtotime($item->pubDate[0]);
							$itemTopublish=$item;
						}
					}
					if($rss->perm_sentences!="")
					{
						$arrayPerm=explode(";",$rss->perm_sentences);
						do{

							$sentenceperm=array_rand($arrayPerm);
						}while($arrayPerm[$sentenceperm]=='');

					} 

					log_message('info','publicador rss'.$timeUpdateitem.$itemTopublish->pubDate[0]);

					log_message('info','link: '.$itemTopublish->link. " , ".$itemTopublish->link[0] );
					$fbaccesstoken=array();
					$arrayFb=json_decode($rss->ids_fb);
					$arrayTw=json_decode($rss->ids_twt);
					var_dump($arrayTw);
					if(isset($sentenceperm))
					{
							$params['message']=$arrayPerm[$sentenceperm];
					}
					if(isset($arrayFb->user))
					{
						$this->load->library('Facebooklib','','fblib');
						

			
						foreach ($arrayFb->user as $id) {
							$user=$this->social_users->getUserappUsers(array('user_id'=>$id),1);
							$fbaccesstoken[]=$user[0]->access_token;
							$this->fblib->setSessionFromToken($user[0]->access_token);
							var_dump($user[0]->access_token);
							$params['link']=(string)$itemTopublish->link[0];
							$resfb=$this->fblib->api_post('/'.$id."/feed",$params);
							var_dump($resfb);

						}

					}

					if(isset($arrayFb->account))
					{
						$this->load->library('Facebooklib','','fblib');
						foreach ($arrayFb->account as $id) {
							$user=$this->social_user_accounts->getUserappAccounts(array('idaccount'=>$id),1);
							$this->fblib->setSessionFromToken($user[0]->access_token);
							var_dump($user[0]->access_token);
							$params['link']=(string)$itemTopublish->link[0];
							$resfb=$this->fblib->api_post('/'.$id."/feed",$params);
							var_dump($resfb);
						}
					}
					
					if(count($arrayTw)>0)
					{

						$this->load->library('Twitterlib','','twtlib');
						foreach ($arrayTw as $id ) {
								$user=$this->social_users->getUserappUsers(array('user_id'=>$id),1);
							$fbaccesstoken[]=$user[0]->access_token;
							$this->twtlib->setAccessToken(json_decode($user[0]->access_token));
							var_dump($user[0]->access_token);
							if(isset($params['message']))
								$paramstw['status']=$params['message'].(string)$itemTopublish->link[0];
							else
								$paramstw['status']=(string)$itemTopublish->link[0];
							$restw=$this->twtlib->post('statuses/update',$paramstw);
							var_dump($restw);
						}
							
					}
				

						/*		if($config->socialnet=='face')
								{

									$this->load->library('facebooklib','','fblib');
						
									if(isset($sentenceperm))
									{
										$publicacio=$this->publicarTextoFacebook(array('message'=>$arrayPerm[$sentenceperm],'link'=>(string)$itemTopublish->link[0],'access_token'=>$page[0]['access_token']), $page[0]['page_id'],$config->user_app);
									}
									else
									{
										$publicacio=$this->publicarTextoFacebook(array('link'=>(string)$itemTopublish->link[0],'access_token'=>$page[0]['access_token']), $page[0]['page_id'],$config->user_app);  
									}


								}
								else
								{
									$usertw = $this->socialusers_model->getUsers(array('type' => 2, 'user_id' => $config->accountid), $config->user_app);
									$this->session->set_userdata(array('tw_access_token'=>array(
										'oauth_token'=>$usertw[0]['token']
										,'oauth_token_secret'=>$usertw[0]['token_secret'])));
									$this->session->set_userdata('tw_status','verified');
		                                      //carrego la llibreria    
									$this->load->library('twconnect');
									if(isset($sentenceperm))
									{
										$this->publicarTextoTwitter(array('status'=>$arrayPerm[$sentenceperm].'  '.(string)$itemTopublish->link[0],'user_id'=>$usertw[0]['user_id']));                                                                                                
									}
									else
									{
										$this->publicarTextoTwitter(array('status'=>(string)$itemTopublish->link[0],'user_id'=>$usertw[0]['user_id']));                                                                                                
									}
								}*/
							}
					
						}
				$this->rss_model->update_by(array('md5lastupdate'=>$md5Updaterssfeed),
							array('id'=>$rss->id,'user_app'=>$rss->user_app));
				


					}
				}

		


    

}

/* End of file crons.php */
/* Location: ./application/modules/panel/controllers/crons.php */