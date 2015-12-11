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
			
			$datenow=new Datetime('now');
			$datenow->setTimezone(new Datetimezone($timezones[$guest[0]->upro_timezone_offset]));
			$fecha=new DateTime("@".$prog->fecha);
			$fecha->setTimezone(new DateTimezone($timezones[$guest[0]->upro_timezone_offset]));
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
            	if($prog->social_network=='tw')
            	{
            		if(isset($prog->path) &&  $prog->path!="")
            		{
            			$file=true;
            			$params['media'] = $prog->path;	
            		}
            		if(isset($prog->link)  && $prog->link!='')
            		{
            			$link=$prog->link;
            		}
            		$params['status']=$prog->text." ".(isset($link)?$link:'');
            		$url='statuses/update';
            	}
            	else
            	{
            		$url="/".$prog->socialaccount."/feed";
            		if(isset($prog->link)  && $prog->link!='')
            		{
            			$params['link']=$prog->link;
            		}
            		$params['message']=$prog->text;
            		
            		if(isset($prog->path) && $prog->path!="")
            		{
    					if(filter_var($prog->path,FILTER_VALIDATE_URL))
							$params['url']=$prog->path;
						else
							$params['source']='@'.$prog->path;
						$url="/".$prog->socialaccount."/photos";
            		}	
            		
            		
				
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
						$this->programations->update_by(array('error'=>$publicaciofb['error']	),array('id'=>$prog->id));
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
						$this->programations->update_by(array('error'=>$publicaciotw['error']	),array('id'=>$prog->id));
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
			
			$datenow=new Datetime('now');
			$datenow->setTimezone(new Datetimezone($timezones[$guest[0]->upro_timezone_offset]));
			$fecha=new DateTime("@".$prog->fechaBorrado);
			$fecha->setTimezone(new DateTimezone($timezones[$guest[0]->upro_timezone_offset]));
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
				
				$response=$this->deletePublishFromSocial($prog->id_publish,$account[0],$prog->social_network);
				if(is_array($response) && isset($response['success']))
				{
					$this->programations->update_by(array('state'=>'finisherase'),array('id'=>$prog->id));	
				}
				else if(is_object($response) && isset($response->id_str))

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

			echo " md5  rss : ".$rss->md5lastupdate."<br>";
			echo " md5  bd : ".$md5Updaterssfeed."<br>";
			
				if($rss->md5lastupdate!=$md5Updaterssfeed)
				{
					try{
						$xml = new SimpleXmlElement($rawFeed);
					}catch(Exception $e)
					{
						continue;
					}
					if(isset($rss->last_date_publish))
                    {
                        $last_date=$rss->last_date_publish;
                    }
                    else
                    {
                    //aki recorro els items del feed
					   $last_date=strtotime($itemTopublish=$xml->channel->item[0]->pubDate[0]);
                    }
                    $itemsTopublish=array();
                    $LastsItems=array();
					foreach ($xml->channel->item  as $item) {
						echo "timerss public  ".date('d-m-Y H:i:s',strtotime($item->pubDate[0]))."<br>";
						echo date('d-m-Y H:i:s',$last_date)."<br>";
					   //per cada un miro si la data d publicacio es superior a la data actual  ok i aqui es on no entra i hauria d'entrar?
                        //no entra pk no hi ha cap publicacio k sigui posterior ok i dki k es el k no funciona?
                        //dons k en el feed hi ha unespublicacions amb unes dates  
                        //si ?
                        //i com k nomes agafo les lpublicacions k tenen data més gran k la data actual  pero no te 
                        if(strtotime($item->pubDate[0])>$last_date)
						{
							$LastsItems[]=$item;
                            				$this->rss_model->update_by(array('last_date_publish'=>strtotime($item->pubDate[0])),
                                                                        array('id'=>$rss->id,'user_app'=>$rss->user_app));

                            
						}
					}
                    if(count($LastsItems)>0)
                    {
                        $itemsTopublish=$LastsItems;
                    }
                    var_dump($LastsItems);
					var_dump($itemsTopublish);
					if($rss->perm_sentences!="")
					{
						$arrayPerm=explode(";",$rss->perm_sentences);
						do{

							$sentenceperm=array_rand($arrayPerm);
						}while($arrayPerm[$sentenceperm]=='');

					} 

					//log_message('error','publicador rss'.$itemTopublish->pubDate[0]);

					//log_message('error','link: '.$itemTopublish->link. " , ".$itemTopublish->link[0] );
					$fbaccesstoken=array();
					$arrayFb=json_decode($rss->ids_fb);
					$arrayTw=json_decode($rss->ids_twt);
                    echo "arraytw:<br>";
					var_dump($arrayTw);
					if(isset($sentenceperm))
					{
						$params['message']=$arrayPerm[$sentenceperm];
					}
					if(isset($arrayFb->user))
					{
						$this->load->library('Facebooklib','','fblib');
						


						foreach ($arrayFb->user as $id) {
							$user=$this->social_users->getUserappUsers(array('user_id'=>$id,'user_app'=>$rss->user_app),1);
							$fbaccesstoken[]=$user[0]->access_token;
							$this->fblib->setSessionFromToken($user[0]->access_token);
							var_dump($user[0]->access_token);
							foreach ($itemsTopublish as $itemTopublish) {
								$params['link']=(string)$itemTopublish->link[0];
								$resfb=$this->fblib->api_post('/'.$id."/feed",$params);
							}
							var_dump($resfb);

						}

					}

					if(isset($arrayFb->account))
					{
						$this->load->library('Facebooklib','','fblib');
						foreach ($arrayFb->account as $id) {
							$user=$this->social_user_accounts->getUserappAccounts(array('idaccount'=>$id,'user_app'=>$rss->user_app),1);
							$this->fblib->setSessionFromToken($user[0]->access_token);
							var_dump($user[0]->access_token);
							foreach ($itemsTopublish as $itemTopublish) {
								$params['link']=(string)$itemTopublish->link[0];
								$resfb=$this->fblib->api_post('/'.$id."/feed",$params);
							}
							var_dump($resfb);
						}
					}
					
					if(count($arrayTw)>0)
					{

						$this->load->library('Twitterlib','','twtlib');
						foreach ($arrayTw as $id ) {
							$user=$this->social_users->getUserappUsers(array('user_id'=>$id,'user_app'=>$rss->user_app),1);
							
							$this->twtlib->setAccessToken(json_decode($user[0]->access_token));
							var_dump($user[0]->access_token);
							foreach ($itemsTopublish as $itemTopublish) {
								if(isset($params['message']))
									$paramstw['status']=$params['message']." ".(string)$itemTopublish->link[0];
								else
									$paramstw['status']=(string)$itemTopublish->link[0];
								$restw=$this->twtlib->post('statuses/update',$paramstw);	
							}
							
							var_dump($restw);
						}

					}
				}
				$this->rss_model->update_by(array('md5lastupdate'=>$md5Updaterssfeed),
					array('id'=>$rss->id,'user_app'=>$rss->user_app));
				

			
		}
	}



	public function esticdins($prog)
	{
		$array=array('Monday'=>'lunes',
			'Tuesday'=>'martes',
			'Wednesday'=>'miércoles',
			'Thursday'=>'jueves',
			'Friday'=>'viernes',
			'Saturday'=>'sábado',
			'Sunday'=>'domingo');
		$guest=$this->flexi_auth->get_user_by_id_query($prog->user_app,array('upro_timezone_offset'))->result();	
			$timezones=$this->config->item('timezones');
			
			$datenow=new Datetime('now');
			$datenow->setTimezone(new Datetimezone($timezones[$guest[0]->upro_timezone_offset]));
			
		$horaactual=$datenow->format('H');
		if($horaactual=='00')
			$horaactual=24;
		if ($horaactual >= $prog->time_start && $horaactual <= $prog->time_end) 
		{
			if (in_array($array[$datenow->format('l')], json_decode($prog->weekdays))) 
			{
				return true;
			}
			else
			{

				return false;
			}
		}
		else
		{

			return false;
		}

	}
	public function publicarFromTosocialnetwork($element,$socialnetwork,$content,$socialacc,$sentenceperm,$arrayPerm)
	{
		$publicaciotw=null;
		$publicaciofb=null;
		if($socialnetwork=='fb')
		{
			$urlfb="/feed";
			if($content=='image')
			{
				$urlfb="/photos";
				if(filter_var($element->path,FILTER_VALIDATE_URL))
					$params['url']=$element->path;
				else
					$params['source']="@".$element->path;

			}
			else if($content=='link')
			{
				$params['link']=$element->link;
			}
			else
			{
				$text=$element->sentence;
			}
			var_dump($sentenceperm);
			if($sentenceperm!=-1)
			{
				$params['message']=$arrayPerm[$sentenceperm]." ".(isset($text)?$text:'');	
			}
			else
			{
				$params['message']=(isset($text)?$text:'');
			}

			$this->load->library('Facebooklib','','fblib');
			$this->fblib->setSessionFromToken($socialacc->access_token);

			$publicaciofb=$this->fblib->api_post('/'.(isset($socialacc->idaccount)?$socialacc->idaccount:$socialacc->user_id).$urlfb,$params);

			



			if(is_array($publicaciofb) && isset($publicaciofb['id']))
			{
				echo "ppppppppppp";
				$id_publish=$publicaciofb['id'];
				echo "resultat d publicciio: 	publicj".$id_publish;

			}
		}
		else
		{
			$file=false;
			if($content=='image')
			{
				$file=true;
				$params['media']= $element->path;

			}
			else if($content=='link')
			{
				$link=$element->link;
				
			}
			else
			{
				$text=$element->sentence;
			}

			if($sentenceperm!=-1)
			{
				$params['status']=$arrayPerm[$sentenceperm]." ".(isset($text)?$text:'')." ".(isset($link)?$link:'');
			}
			else
			{
				$params['status']=(isset($text)?$text:'')." ".(isset($link)?$link:'');
			}
			$this->load->library("twitterlib",'','twtlib');

			$this->twtlib->setAccessToken(json_decode($socialacc->access_token));
			if($file)
			{
				$publicaciotw=$this->twtlib->upload($params);
			}
			else
			{
				$publicaciotw=$this->twtlib->post('statuses/update',$params);
			}	


			if(is_object($publicaciotw) && isset($publicaciotw->id_str))
			{

				$id_publish=$publicaciotw->id_str;
				echo "resultat d publicciiotw:"	.$id_publish;

			}

		}

		return $id_publish;
	}
	public function autoProgComu($var_name)
	{
		if($var_name=="anuncios")
		$comuAutoprog="autoprog_".$var_name;
		else
		$comuAutoprog="autoprog_basede".$var_name;
		echo $comuAutoprog;
		$this->load->model($comuAutoprog);
		$autoprogs=$this->$comuAutoprog->get_all();
		if(count($autoprogs)>0)
		{
			foreach ($autoprogs as $prog) 
			{
				if($this->esticdins($prog))
				{
					if ($prog->estic_dins == 0) 
					{
						$this->$comuAutoprog->update_by(array('date' => time(), 'estic_dins' => 1), array('accountid' => $prog->accountid, 'id' => $prog->id));
					}
					else
					{
						$freq = (float) $prog->frequency;
						if (isset($freq) && $freq != 0.0)
						{
							if ($freq < 1)
							{
								$freq = $freq * 100;
								echo "min<br/>";
							}
							else
							{
								$freq = $feq * 60;
								echo "horas <br/>";
							}
							$guest=$this->flexi_auth->get_user_by_id_query($prog->user_app,array('upro_timezone_offset'))->result();	
							$timezones=$this->config->item('timezones');
							
							$datenow=new Datetime('now');
							$datenow->setTimezone(new Datetimezone($timezones[$guest[0]->upro_timezone_offset]));
							$dateProg=new Datetime("@".$prog->date);
							$dateProg->setTimezone(new Datetimezone($timezones[$guest[0]->upro_timezone_offset]));
							
							$resta=($datenow->format('U')-$dateProg->format('U'))/60;                                         

							log_message('error', $prog->accountid."accountid abans de mirar si puc publicar");
							log_message('error', "miro minuts i intervals, estic dins val 1, la frequencia ara val ".$freq. " i la resta val ".round($resta)." minuts fecha ".date('i',$prog->date)."minuts ara". date('i'));
                                  //aixro surt refresca lla pag de xivatos
							echo $datenow->format('d-m-Y H:i:s') . "<br>";
							echo "frequencia: ".$freq."<br>";;
							echo "hora de inici de les publicacions ( a la k sha guardat el formulari config )".$dateProg->format('Y-m-d H:i:s') . "<br>";
							echo $prog->accountid."<br/>";
							echo "resta  minuts que han passat desde k sha guardat el formulari: ".round($resta);
							if (round($resta)%$freq==0)
							{
								log_message('error',"puc publicar!");
								if(isset($prog->ids))
								{
									$this->load->model('social_user_accounts');
									$this->load->model('social_users');
									if($prog->type=='account')
									{
										$acctopublish=$this->social_user_accounts->getUserAppAccounts(array('idaccount'=>$prog->accountid,'user_app'=>$prog->user_app),1);
									}
									else
									{
										$acctopublish=$this->social_users->getUserAppUsers(array('user_id'=>$prog->accountid,'user_app'=>$prog->user_app),1);	
									}
									var_dump($acctopublish);
									if($var_name=="anuncios")
									$comuModel=	$var_name."_model";
									else
										$comuModel="bases_".$var_name."_model";
									$this->load->model($comuModel);
									$this->load->model("autoprog_publicadas");
									$array=array('fb'=>'face',"tw"=>'twt');
									if($var_name=="datos")
									{
										$arrayids=json_decode($prog->ids);
										do{
											$bdid=array_rand($arrayids);
										}while($arrayids[$bdid]=='');
										$bdid=$arrayids[$bdid];
									}
									else
									{
										$bdid=$prog->ids;
									}	
									$anunci=$this->$comuModel->getAll(array('socialnetwork'=>$array[$prog->socialnetwork],'id'=>$bdid));
//									var_dump($anunci);
									
									$arrayPerm=array(-1=>"");
									$sentenceperm=-1;

									if($prog->perm_sentences!="")
									{
										$arrayPerm=explode(";",$prog->perm_sentences);
										var_dump($arrayPerm);
										do{
											$sentenceperm=array_rand($arrayPerm);
										}while($arrayPerm[$sentenceperm]=='');
									}
//									echo $arrayPerm[$sentenceperm];;
									$elements=$this->$comuModel->getElements($anunci[0]->content,array('bbdd_id'=>$anunci[0]->id));
									$numelements=count($elements);
								//	var_dump($elements);
									$i=0;
									echo "reoet".$prog->repeat."<br>";
									if($prog->repeat==0)
									{
										$numelementsPublicats=$this->autoprog_publicadas->count_by(
											array(
												'user_app'=>$prog->user_app,
												"bd_id"=>$anunci[0]->id,
												"account_id"=>$prog->accountid,
												"type_bd"=>$var_name,
												"content"=>$anunci[0]->content,
												'autoprog_id'=>$prog->id
												)
										);
										echo $numelements."<br>";
										echo $numelementsPublicats."<br>";

										if($numelements>$numelementsPublicats)
										{
											do
											{
												$numRandom=array_rand($elements);
												$trobat=$this->autoprog_publicadas->findOne(array('user_app'=>$prog->user_app,"bd_id"=>$anunci[0]->id,"element_id"=>$elements[$numRandom]->id,
													"account_id"=>$prog->accountid,"type_bd"=>$var_name,"content"=>$anunci[0]->content,'autoprog_id'=>$prog->id));

											}while(count($trobat)>0);
										}
									}
									else
										$numRandom=array_rand($elements);
									if(isset($numRandom))
									{

										$id_publish=$this->publicarFromTosocialnetwork($elements[$numRandom],$prog->socialnetwork,$anunci[0]->content,$acctopublish[0],$sentenceperm,$arrayPerm);
										$this->autoprog_publicadas->insert(array('content'=>$anunci[0]->content,'type_bd'=>$var_name,'account_id'=>$prog->accountid,'bd_id'=>$anunci[0]->id,
											'element_id'=>$elements[$numRandom]->id,'user_app'=>$prog->user_app,'autoprog_id'=>$prog->id));
									}
									if($var_name=="anuncios")
									{
										$freq_erase = (float) $prog->frequency_erase;
										if (isset($freq_erase) && $freq_erase != 0.0) {
											if ($freq_erase < 1) {
												$freq_erase = $freq_erase * 100*60;
											} else {
												$freq_erase = $freq_erase * 3600;
											}
											if(isset($id_publish))
											{
												$arrayToErase=json_decode($prog->published_erase);
												if(!is_array($arrayToErase))
													$arrayToErase=array();
												$new=new  stdClass();
												$new->publish_id=$id_publish;
												$new->timetoErase=time()+$freq_erase+30;
												array_push($arrayToErase, $new);
	                                     //             var_dump(json_encode($arrayToErase));
												$this->$comuAutoprog->update_by(array('published_erase'=>  json_encode($arrayToErase)),array('accountid'=>$prog->accountid,'user_app'=>$prog->user_app));
											}
										}
									}
								}
							}
						}
					}
				}
				else
				{
					$this->$comuAutoprog->update_by(array('estic_dins' => 0), array('accountid' => $prog->accountid, 'user_app' => $prog->user_app));
				}
			}

		}
	}	
	public function cronAutoProgAnuncis()
	{
		$this->autoProgComu("anuncios");

	}
	public function cronAutoProgBBDD()
	{
		$this->autoProgComu("datos");
	}
	public function cronDeleteAutoProgAnuncios()
	{
		$this->load->model('autoprog_anuncios');
		

		$autoprogs=$this->autoprog_anuncios->get_all();
		foreach ($autoprogs as $prog) {
			if(isset($prog->published_erase))
			{
				if($prog->type=='account')
				{
					$this->load->model('social_user_accounts');
					$acctopublish=$this->social_user_accounts->getUserAppAccounts(array('idaccount'=>$prog->accountid,'user_app'=>$prog->user_app),1);
				}
				else
				{
					$this->load->model('social_users');
					$acctopublish=$this->social_users->getUserAppUsers(array('user_id'=>$prog->accountid,'user_app'=>$prog->user_app),1);	
				}
				$arrayToErase=json_decode($prog->published_erase);
				if(count($arrayToErase)>0)
				{
					foreach ($arrayToErase as $key=>$publicacio) {
						   $esborrat=false;
					     	if(floor(time()/60)==floor($publicacio->timetoErase/60))
                            {
                            	$response=$this->deletePublishFromSocial($publicacio->publish_id,$acctopublish[0],$prog->socialnetwork);
                            	var_dump($response);
                            	if(is_array($response) && isset($response['success']))
								{
									$esborrat=true;
									unset($arrayToErase[$key]);
								}
								else if(is_object($response) && isset($response->id_str))
								{	
									$esborrat=true;
									unset($arrayToErase[$key]);
								}
								
                            }
                         	if($esborrat)
                            {
                               $arrayToErase=  array_values($arrayToErase);
                            }
                            $this->autoprog_anuncios->update_by(array('published_erase'=>  json_encode($arrayToErase)),array('accountid'=>$prog->accountid,'user_app'=>$prog->user_app,'id'=>$prog->id));


					}
				}
			}
		}
	}
	public function deletePublishFromSocial($id_publish_erase,$socialaccount,$socialnetwork)
	{
		if($socialnetwork=='fb')
		{
							
			$this->load->library('Facebooklib','','fblib');
			$this->fblib->setSessionfromToken($socialaccount->access_token);
                		
			return $this->fblib->api('/'.$id_publish_erase,null,'DELETE');
		}
		else
		{
			$this->load->library('Twitterlib','','twtlib');
			$this->twtlib->setAccessToken(json_decode($socialaccount->access_token));
			return $this->twtlib->post("/statuses/destroy/".$id_publish_erase,array());
		}
	}
	/**
	 * [limpiar_fotos_facebook esborra totes les  publicacions que son foto de facebook  en un id de compte]
	 * @param  [type] $token     [accestoken del compte de facebook]
	 * @param  [type] $accountid identificador del compte de faceboook
	 * @return [type]            [description]
	 */
	public function limpiar_fotos_facebook($token,$accountid)
	{
		$this->load->library('Facebooklib','','fblib');
		$this->fblib->setSessionFromToken($token);
		  $photos_data = array();
	    $offset=0;
	    $limit=200;	
	    $photos_data=$this->fblib->api("/".$accountid."/photos/uploaded",array('limit'=>$limit,'offset'=>$offset));
	    
	   	//$until=$data['data'][count($data['data'])]->
	   	
	    $numerased=0;
	    //si hi ha fotos les esborro
	    if(isset($photos_data['data']) && count($photos_data['data'])>0)
	    {
		    
		    foreach ($photos_data['data'] as $photo) {
		    	try{
		    		//var_dump($photo->id);
		    		$res=$this->fblib->api('/'.$photo->id,null,'DELETE');	
		    		$numerased++;
		    		var_dump($res);

		    	}catch(Exception $E)
		    	{
		    		
		    		continue;
		    	}
		    	
		    	
		    }
		    echo "numerased photos: ".$numerased;
		    if($numerased==0)
		    {
		    	return 0;
		    }
		    else
		    {
		    	return 1;
			}
		}
		else
		{
			return 0;
		}
	}
	/**
	 * [limpiar_links_facebook esborrar els li]
	 * @param  [type] $token     [description]
	 * @param  [type] $accountid [description]
	 * @return [type]            [description]
	 */
	public function limpiar_links_facebook($token,$accountid)
	{
		$this->load->library('Facebooklib','','fblib');
		$this->fblib->setSessionFromToken($token);
		$links_data = array();
	    $offset=0;
	    $limit=200;	
	    $links_data=$this->fblib->api("/".$accountid."/links",array('limit'=>$limit,'offset'=>$offset));
	    
	   	//$until=$data['data'][count($data['data'])]->
	//var_dump($links_data);
	$numerased=0;
	    //si hi ha  links esborro els que no apunten a www.facebook.com
    	if(isset($links_data['data']) && count($links_data['data'])>0)
	    {
		    echo "links";
		    
		    foreach ($links_data['data'] as $linkobj) {
		    	//var_dump($linkobj);
		    	$parts=parse_url($linkobj->link);
		    	
		    	if($parts['host']!='www.facebook.com')
		    	{
		    		//echo "pp";
			    	try{
			    		//var_dump($linkobj);
			    		$res=$this->fblib->api_delete("/".$linkobj->id);	
			    		$numerased++;
			    		var_dump($res);

			    	}catch(Exception $E)
			    	{
			    		
			    		continue;
			    	}
		    	}
			    
		    }
			echo "numerased links: ".$numerased;
		    if($numerased==0)
		    {
		    	return 0;
		    }
		    else
		    {
		    	return 1;
			}   
		}
		else
		{
			return 0;
		}
	
	}
	public function cronCleanAccounts()
	{
		$this->load->model('req_clean_account');
		$this->load->model('social_users');		

		$this->load->model('social_user_accounts');

		$array=$this->req_clean_account->get_all();
		foreach ($array as $clean_row) 
		{			
			if($clean_row->type_socialaccount=='user')
			{
				$userRow=$this->social_users->getUserAppUsers(array('user_id'=>$clean_row->accountid,'user_app'=>$clean_row->user_app),1);		 	
				$account=$userRow[0]->user_id;
				$name=$userRow[0]->username;

			}
			else
			{
				 	$userRow=$this->social_user_accounts->getUserAppAccounts(array('idaccount'=>$clean_row->accountid,'user_app'=>$clean_row->user_app),1);
				 	$account=$userRow[0]->idaccount;
				 	$name=$userRow[0]->name;
			}
			$resultati=1;
			$resultatl=1;
			if($clean_row->social_network=='fb')
			{

				if($clean_row->type_clean=='spam')
					$resultatl=$this->limpiar_links_facebook($userRow[0]->access_token,$account);
				elseif($clean_row->type_clean=='photos')
				{
					$resultati=$this->limpiar_fotos_facebook($userRow[0]->access_token,$account);
				}	
				else{
					$resultati=$this->limpiar_fotos_facebook($userRow[0]->access_token,$account);
					$resultatl=$this->limpiar_links_facebook($userRow[0]->access_token,$account);
				}
				if(($resultatl==0 && $resultati==0 && $clean_row->type_clean=='all') || ($resultatl==0 && $clean_row->type_clean=='spam') || ($resultati==0 && $clean_row->type_clean=='photos'))
				{
					$this->req_clean_account->delete_by(array('id'=>$clean_row->id));
							$this->req_clean_account->delete_by(array('id'=>$clean_row->id));
					$user=$this->flexi_auth->get_user_by_id_query($clean_row->user_app,array("uacc_email",'upro_first_name'))->result();	
					//var_dump($user);
					$email_to = $user[0]->{$this->auth->database_config['user_acc']['columns']['email']};
					$data=array('user'=>$user[0],'nameaccount'=>$name);
					$email_title = ' - Operación de limpieza de facebook';

					$this->flexi_auth_model->send_email($email_to, $email_title,$data,'cleanNoty.tpl.php');

				}
			}
			else
			{
					$resultat=$this->deleteTwits($userRow[0]->access_token,$account);
					if($resultat==0)
					{
						$this->req_clean_account->delete_by(array('id'=>$clean_row->id));
						$user=$this->flexi_auth->get_user_by_id_query($clean_row->user_app,array("uacc_email",'upro_first_name'))->result();	
						$email_to = $user[0]->{$this->auth->database_config['user_acc']['columns']['email']};
						$data=array('user'=>$user[0],'nameaccount'=>$name);
						$email_title = ' - Operación de limpieza de twitter';

						$this->flexi_auth_model->send_email($email_to, $email_title,$data,'cleanNoty.tpl.php');



					}

			}
		}	
		
	}
	/**
	 * [deleteTwits funcio que permet a  un usuari de twitter deixr de seguir a tots els seus seguidors]
	 * @param  [type] $token   [acccestoken]
	 * @param  [type] $user_id id de usuari de twittr
	 * @return [type]          [description]
	 */
	public function deleteTwits($token,$user_id)
	{
		$this->load->library('Twitterlib','','twtlib');
		
		$this->twtlib->setAccessToken(json_decode($token));
		
		$count = 200;
		
		
		$statuses = $this->twtlib->get("statuses/user_timeline",array('count'=>$count,'user_id'=>$user_id));
		  	var_dump($statuses);
		 //var_dump($statuses);
		 if(count($statuses)>0)
		 {
		  foreach ($statuses as $friend) {

			$follows = $this->twtlib->post("statuses/destroy",array('id'=>$friend->id));		  	
			var_dump($follows);
			
		  }
		  return 1;
		}
		else
		{
			return 0;
		}
	}
	
	
}

/* End of file crons.php */
/* Location: ./application/modules/panel/controllers/crons.php */