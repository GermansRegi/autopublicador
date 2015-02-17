<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Crons extends CI_Controller {
	
	public function __construct()
	{
			parent::__construct();
		$this->load->library('session');
				$this->load->database();
		$this->load->library('session');
 		$this->load->helper('url');
 		$this->load->helper('form');
 		$this->load->helper('language');

  		// IMPORTANT! This global must be defined BEFORE the flexi auth library is loaded!
 		// It is used as a global that is accessible via both models and both libraries, without it, flexi auth will not work.
		$this->auth = new stdClass;

		// Load 'standard' flexi auth library by default.
		$this->load->library('flexi_auth');
		$this->data=null;
     	// Redirect users logged in via password (However, not 'Remember me' users, as they may wish to login properly).
		if ($this->flexi_auth->is_logged_in_via_password() && uri_string() != 'panel/logout')
		{
			// Preserve any flashdata messages so they are passed to the redirect page.
			if ($this->session->flashdata('message')) { $this->session->keep_flashdata('message'); }

			// Redirect logged in admins (For security, admin users should always sign in via Password rather than 'Remember me'.
			if ($this->flexi_auth->is_admin())
			{
				redirect(base_url().'admin');
			}
			else if( uri_string()=='panel')
			{

				redirect(base_url().'panel/index');

			}
			
			$this->load->vars('section_app','panel');
			$guest=$this->flexi_auth->get_user_by_id_query($this->flexi_auth->get_user_id(),array("guestPremium","uacc_group_fk"))->result();	

			if ($this->flexi_auth->is_privileged('acces user free'))
			{
				if($guest[0]->guestPremium=="1")
				$this->load->vars('privilege_user_app','prem');
				else
				$this->load->vars('privilege_user_app','free');
			}
			else if ($this->flexi_auth->is_privileged('acces user prem') ) 
			{
				$this->load->vars('privilege_user_app','prem');
			}
//			$this->data['username']=$this->flexi_auth->get_user_by_id_query($this->flexi_auth->get_user_id(),array("upro_first_name"))->result();	
		}

	}

	public function index()
	{
		
	}
	public function checkguestsUsuers()
    {

    		$usersSendGuestNoty=$this->flexi_auth->get_users_query(array('uacc_email','upro_first_name'),array('guestPremium'=>1,'date_add(date(uacc_date_added),interval 5 day)='=>date('Y-m-d')))->result();
  		
  		//var_dump($usersSendGuestNoty);
    		foreach ($usersSendGuestNoty as $user) {
    				

    				$email_to = $user->{$this->auth->database_config['user_acc']['columns']['email']};
    				$data=array('user'=>$user,'daysleft'=>2,'type_plan'=>' premium gratuita ');
				$email_title = ' - Aviso de caducidad de peridodo premium gratuito';
				
    				$this->flexi_auth_model->send_email($email_to, $email_title,$data,'NotifyPlan.tpl.php');

       	}


		$usersFinsishGuest=$this->flexi_auth->get_users_query(array('user_app','uacc_email','upro_first_name'),array('guestPremium'=>1,'date_add(date(uacc_date_added),interval 7 day)='=>date('Y-m-d')))->result();
		var_dump($usersFinsishGuest);
		foreach ($usersFinsishGuest as $user) 
		{
    				
    				$email_to = $user->{$this->auth->database_config['user_acc']['columns']['email']};
    				$data=array('user'=>$user,'type_plan'=>' premium gratuito ');
				$email_title = ' - Aviso de caducidad de peridodo premium gratuito';
    				$this->flexi_auth_model->send_email($email_to, $email_title,$data,'finishplan.tpl.php');
    				$this->flexi_auth->update_user($user->user_app,array('guestPremium'=>0));

       	}


    	}
    	    	public function checkPremuiumUsers()
    	    	{
    			$usersSendPremiumNoty=$this->flexi_auth->get_users_query(array('uacc_email','user_app','upro_first_name'),array('guestPremium'=>0,'uacc_group_fk'=>2))->result();
    			$this->load->model('payments');
    	  		
    	  		//var_dump($usersSendGuestNoty);
    	    		foreach ($usersSendPremiumNoty as $user) {
    	    				$days=0;
    	    				
    	    				$lastPayemnt=$this->payments->getLastPaymentFinish(array('user_app'=>(int)$user->user_app,'finished'=>0));
    	    				if(count($lastPayemnt)==1)
    	    				{
	    	    				$datenow=new Datetime('now');
	    	     			$datepayment=new Datetime($lastPayemnt[0]->last);
	    	     			echo $datepayment->format('Y-m-d');
	    	                    echo $datenow->format('Y-m-d');
	    	     			$datediff=$datepayment->diff($datenow);
	    	     			echo $datediff->days."<br>";
	    	     			if($datediff->days==5)
	    	     			{
	    	     				$email_to = $user->{$this->auth->database_config['user_acc']['columns']['email']};
	    		    				$data=array('user'=>$user,'daysleft'=>5,'type_plan'=>' premium '.$lastPayemnt[0]->type_prempay);
	    						$email_title = ' - Aviso de caducidad de peridodo premium';
	    						
	    		    				$this->flexi_auth_model->send_email($email_to, $email_title,$data,'NotifyPlan.tpl.php');
	    	     			}
	    	     			else if($datediff->days==0)
	    	     			{
	    	     				$email_to = $user->{$this->auth->database_config['user_acc']['columns']['email']};
	    		    				$data=array('user'=>$user,'type_plan'=>' premium '.$lastPayemnt[0]->type_prempay);
	    						$email_title = ' - Aviso de caducidad de peridodo premium';
	    		    				$this->flexi_auth_model->send_email($email_to, $email_title,$data,'finishplan.tpl.php');
	    		    				$this->payments->update_by(array('finished'=>1),array('id'=>$lastPayemnt[0]->id));
	    		    				$res=$this->db->query('update user_accounts set uacc_group_fk=1 where user_app='.$user->user_app);
	    	     			}
					}    	     			
    	    				
    	    				

    	       	}



    	    	}

	public function cronPublishProgramations()
	{
		  $this->load->model("programations");
            $this->load->library('session');
            $this->load->model('social_users');
            $this->load->model('social_user_accounts');
            
            //date_default_timezone_set('London/Madrid');
            //querey programaciones vto publish  by time
              $programaciones=$this->programations->getProgramationsNow(array('state'=>'process'));

          	
            foreach ($programaciones as $prog)
            {
            	$guest=$this->flexi_auth->get_user_by_id_query($prog->user_app,array('upro_timezone_offset'))->result();	
			$timezones=$this->config->item('timezones');
			
			$datenow=new Datetime('now', new Datetimezone($timezones[$guest[0]->upro_timezone_offset]));
			$fecha=DateTime::createFromFormat('Y-m-d H:i:s',date('Y-m-d H:i:s',$prog->fecha),new DateTimezone($timezones[$guest[0]->upro_timezone_offset]));
			echo "id: ".$prog->id."<br>";
			echo "date now: ".$datenow->format('Y-m-d H:i:s')."<br>";
			echo "dateprog: ".$fecha->format('Y-m-d H:i:s')."<br>";
			
			$timnow=$datenow->format('U');
			$timeprog=$fecha->format('U');
			echo (floor($timnow/60)==floor($timeprog/60));
            	if(floor($timnow/60)==floor($timeprog/60))
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
	                    			echo $publicaciofb['error'];
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
	               				echo $publicaciotw['error'];
	               			$state='nocomplete';
	               		}
	                    

	                    }
	                   	if($prog->fechaBorrado!=0 && $state=="finished")
	                   	{
	                 
	                   		$state="toerase";
	                   		
	                   	}
	                            var_dump($publicaciofb);
	               	$id_publish='';
	               	
	               	echo (is_array($publicaciofb) && $state!="nocomplete");
	                    if(is_array($publicaciofb) && $state!="nocomplete")
	                    {
	                    	echo "ppppppppppp";
	                    	$id_publish=$publicaciofb['id'];
	                    	echo "resultat d publicciio: 	".$state."publicj".$id_publish;
	                        
	                    }
	                    else if(is_object($publicaciotw) && isset($publicaciotw->id_str) && $state!="nocomplete")
	                    {

	                    	$id_publish=$publicaciotw->id_str;
	                    	echo "resultat d publicciiotw: 	".$state."public tw".$id_publish;

	                    }
	                    echo "resultat d publicciio: 	".$state."publicj".$id_publish;
	                    $this->programations->update_by(array('id_publish'=>$id_publish,'state'=>$state	),array('id'=>$prog->id));
	                    log_message("error","Programcion".$id_publish);
	               }
              	}
           }
            
         
	
	public function cronEraseProgramations()
	{
				  $this->load->model("programations");
            $this->load->library('session');
            $this->load->model('social_users');
            $this->load->model('social_user_accounts');
            //querey programaciones vto publish  by time
             $programaciones=$this->programations->getProgramationsNow(array('state'=>'toerase'));
              
            foreach ($programaciones as $prog)
            {
            	$guest=$this->flexi_auth->get_user_by_id_query($prog->user_app,array('upro_timezone_offset'))->result();	
			$timezones=$this->config->item('timezones');
			
			$datenow=new Datetime('now', new Datetimezone($timezones[$guest[0]->upro_timezone_offset]));
			$fecha=DateTime::createFromFormat('Y-m-d H:i:s',date('Y-m-d H:i:s',$prog->fechaBorrado),new DateTimezone($timezones[$guest[0]->upro_timezone_offset]));
			echo "id: ".$prog->id."<br>";
			echo "date now: ".$datenow->format('Y-m-d H:i:s')."<br>";
			echo "dateprog: ".$fecha->format('Y-m-d H:i:s')."<br>";
			
			$timnow=$datenow->format('U');
			$timeprog=$fecha->format('U');
			echo (floor($timnow/60)==floor($timeprog/60));
            	if(floor($timnow/60)==floor($timeprog/60))
            	{
            		  $responsefb=null;
	                $responsetw=null;
	                // si es facebook
	                	if($prog->type_socialaccount=='user')
	                    //query the page to publish de programation
	                    	$account=$this->social_users->getUserappUsers(array('user_id'=>$prog->socialaccount,'user_app'=>$prog->user_app),1);
	               	else
	               		$account=$this->social_user_accounts->getUserappAccounts(array('idaccount'=>$prog->socialaccount,'user_app'=>$prog->user_app),1);
	               	 if($prog->social_network=='fb')
	                    {
	                    	$this->load->library('Facebooklib','','fblib');
	                    	$this->fblib->setSessionfromToken($account[0]->access_token);
	                    		//echo "url: ".$url."<br>";
	                    		//var_dump($params);
	                    		$publicaciofb=$this->fblib->api('/'.$prog->id_publish,null,'DELETE');
	                    }
	                    else
	                    {
	                    	$this->load->library('Twitterlib','','twtlib');
						$this->twtlib->setAccessToken(json_decode($account[0]->access_token));
							$publicaciotw=$this->twtlib->post("/statuses/destroy/".$prog->id_publish,array());
							
						
	                    }
	                    if(is_array($publicaciofb) && isset($publicaciofb['success']))
	                    {
	                    	$this->programations->update_by(array('state'=>'finisherase'),array('id'=>$prog->id));	
	                    }
	                    else if(is_object($publicaciotw) && isset($publicaciotw->id_str))
	                    
	                    $this->programations->update_by(array('state'=>'finisherase'),array('id'=>$prog->id));
            	}
            	
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

					log_message('error','publicador rss'.$timeUpdateitem.$itemTopublish->pubDate[0]);

					log_message('error','link: '.$itemTopublish->link. " , ".$itemTopublish->link[0] );
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

		


    public function cronAutoProgAnuncis()
    {
    	 $array=array('Monday'=>'lunes',
                'Tuesday'=>'martes',
                'Wednesday'=>'miércoles',
                'Thursday'=>'jueves',
                'Friday'=>'viernes',
                'Saturday'=>'sábado',
                'Sunday'=>'domingo');

    		$this->load->model('autoprog_anuncios');
    		$autoprogs=$this->autoprog_anuncios->get_all();
    		if(count($autoprogs)>0)
    		{
    			foreach ($autoprogs as $prog) 
    			{
    				$horaactual=date('H');
            		if($horaactual=='00')
            			$horaactual=24;
            		if ($horaactual >= $prog->time_start && $horaactual <= $prog->time_end) 
            		{
            			if (in_array($array[date('l')], json_decode($prog->weekdays))) 
            			{
            				if ($prog->estic_dins == 0) 
            				{
            					$this->autoprog_anuncios->update_by(array('date' => time(), 'estic_dins' => 1), array('accountid' => $prog->accountid, 'id' => $prog->id));
            				}
            				else
            				{
            					$freq = (float) $prog->frequency;
            					if (isset($freq) && $freq != 0.0)
            						{
            							if ($freq < 1) {
            								$freq = $freq * 100;
///                                                $resta=(date('i')-date('i',$config->fecha));
            								echo "min<br/>";
            							} else {
            								$freq = $freq * 60;
            								
            								echo "horas <br/>";
            							}
            							$resta=(time()-$prog->date)/60;                                         
            							log_message('error', $prog->accountid."accountid abans de mirar si puc publicar");
            							log_message('error', "miro minuts i intervals, estic dins val 1, la frequencia ara val ".$freq. " i la resta val ".round($resta)." minuts fecha ".date('i',$prog->date)."minuts ara". date('i'));
                                            //aixro surt refresca lla pag de xivatos
            							echo date('H:i:s') . "<br>";
            							echo "frequencia: ".$freq."<br>";;
            							echo "hora de inici de les publicacions ( a la k sha guardat el formulari config )".date(' Y-m-d H:i:s', $prog->date) . "<br>";
            							
            							echo $prog->accountid."<br/>";
            							echo "resta  minuts que han passat desde k sha guardat el formulari: ".round($resta)."<br/>";
                                            //faig la resta dels minuts dara amb els k hi han a bd
                                            //ii faig el modul amb la frequencia 

                                            //si son les 12:13, 
                                            //a bd tinc les 10:13
                                           //vol dir k tinc un 0 %15 E=0ugie fes una cosa, posa xivatoss a tots els if
            							
            							if (round($resta)%$freq==0)
            							{
            								log_message('error',"puc publicar!");
            								if(isset($prog->ids))
            								{
            									$this->load->model('social_user_accounts');
            									$this->load->model('social_users');
            									if($prog->type=='account')
            									{
            										$acc=$this->social_user_accounts->getUserAppAccounts(array('idaccount'=>$prog->accountid),1);
											
											}
											else
											{
												$acc=$this->social_users->getUserAppUsers(array('user_id'=>$prog->accountid),1);	
											
											}
											var_dump($acc);
											$this->load->model('anuncios_model');
											$this->load->model("autoprog_publicadas");
											$array=array('fb'=>'face',"tw"=>'twt');
											$anunci=$this->anuncios_model->getAll(array('socialnetwork'=>$array[$prog->socialnetwork],'id'=>$prog->ids));
											var_dump($anunci);
											$sentenceperm=false;
											if($prog->perm_sentences!="")
			                                            {

			                                              $arrayPerm=explode(";",$prog->perm_sentences);
			                                                do{
			                                                
			                                                $sentenceperm=array_rand($arrayPerm);
			                                              }while($arrayPerm[$sentenceperm]=='');
			                                                
			                                            }
											$elements=$this->anuncios_model->getElements($anunci[0]->content,array('bbdd_id'=>$anunci[0]->id));
											if($prog->repeat==0){
												do{
													$numRandom=array_rand($elements);
													$trobat=$this->autoprog_publicadas->findOne(array('user_app'=>$prog->user_app,"bd_id"=>$anunci[0]->id,"element_id"=>$elements[$numRandom]->id,"account_id"=>$prog->accountid,"type_bd"=>'anuncio',"content"=>$anunci[0]->content));
												}while($trobat==true);
											}
											else
												$numRandom=array_rand($elements);

											var_dump($elements[$numRandom]);
											var_dump($prog->repeat);
											if($prog->socialnetwork=='fb')
											{

												if($anunci[0]->content=='image')
												{

												}
												else if($anunci[0]->content=='link')
												{

												}
												else
												{

												}	
											}
											else
											{
												$file=false;
												if($anunci[0]->content=='image')
												{
													$file=true;
													$params['media']= $elements[$numRandom]->path;
			
												}
												else if($anunci[0]->content=='link')
												{
													$link=$elements[$numRandom]->link;
													
												}
												else
												{
													$text=$elements[$numRandom]->sentence;
												}	
												if($sentenceperm)
												{
													$params['status']=$arrayPerm[$sentenceperm].(isset($text)?$text:'').(isset($link)?$link:'');
												}
												else
												{
													$params['status']=(isset($text)?$text:'').(isset($link)?$link:'');
												}
												$this->load->library("twitterlib",'','twtlib');

												$this->twtlib->setAccessToken(json_decode($acc[0]->access_token));
												if($file)
												{
													$res=$this->twtlib->upload($params);
												}
												else
												{
													$res=$this->twtlib->post('statuses/update',$params);
												}	
												   $this->autoprog_publicadas->insert(array('content'=>$anunci[0]->content,'type_bd'=>'anuncio','account_id'=>$prog->accountid,'bd_id'=>$prog->ids,
                                                    'element_id'=>$elements[$numRandom]->id,'user_app'=>$prog->user_app));
											}



            								}
            							}
            						}
            				}
            			}
            		}
	    		}

    		}
    	}	

}

/* End of file crons.php */
/* Location: ./application/modules/panel/controllers/crons.php */