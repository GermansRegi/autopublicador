<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Form_validation_global 
{
	public function __construct()
	{
		$this->CI =& get_instance();
	}
	public function ErrorsPublicar($arrayPost, $isfb=false)
	{
		if($this->CI->input->post('anuncis') && $this->CI->input->post('bbdd'))
          {
          	
             if(($this->CI->input->post('anuncis_link') || $this->CI->input->post('anuncis_sentence') || $this->CI->input->post('anuncis_image')) && ($this->CI->input->post('bbdd_image') || $this->CI->input->post('bbdd_sentence') || $this->CI->input->post('bbdd_link')) )
               {    
                       return array('msg_errors'=>array('pp'=>'No puede publicar contenido de anuncios y bases de datos a la vez'));
                       
               }
               else
               {
               	return array('msg_errors'=>array('aa'=>'Debe seleccionar un elemento de bases de datos o un elemento de anuncios'));
               }
          }
          //si nomes seleccionen algun element d'anuncis
          elseif($this->CI->input->post('anuncis'))
          {
          	
          	
          	//si no seleccionen cap element d'anuncis pero si un anunci
          	if($this->CI->input->post('anuncis_sentence')=='' && $this->CI->input->post('anuncis_link')=='' && $this->CI->input->post('anuncis_image')=='' && $this->CI->input->post('texto_facebook')=='' && $this->CI->input->post('link')=='' && $_FILES['imagen']['name']=="" )
               
               {
                   return array('msg_errors'=>array('pp'=>'Debe introducir un texto, imagen , enlace o seleccionar un elemento de una base de datos o anuncio para publicar'));
                  

               } 
               //elseif(($this->CI->input->post('bbdd_sentence')!='' || $this->CI->input->post('bbdd_image')!='' || $this->CI->input->post('bbdd_link')) && ($this->CI->input->post('texto_facebook')!='' || $this->CI->input->post('link')!='' || (isset($_FILES['imagen']['name']) && $_FILES['imagen']['name']!="") ))
               //si selecciona algun element d'anuncis i entra algun altre camp
               elseif((/*$this->CI->input->post('anuncis_sentence')!='' ||*/ $this->CI->input->post('anuncis_image')!='' || $this->CI->input->post('anuncis_link')!='') && ($this->CI->input->post('link')!='' || (isset($_FILES['imagen']['name']) && $_FILES['imagen']['name']!="")  ))
               {
                   return  array('msg_errors'=>array('pp'=>'No puede publicar contenido de anuncios con enlace o imagen'));
                   
               }
               //si algun element d'anuncis es seleccionat
               elseif($this->CI->input->post('anuncis_sentence') || $this->CI->input->post('anuncis_link') || $this->CI->input->post('anuncis_image'))
               {
               	//si selecciona un element danuncis  que es text
                   if($this->CI->input->post('anuncis_sentence'))
                   {
                   		//si a mes de l'element danuncis de text, omplen el camp text
                       
                       
                       		return array('table'=>'anuncios','content'=>'sentence','idelement'=>$this->CI->input->post('anuncis_sentence'));
                        	
                       
                   }
                   //si seleccionen un element danuncis que es imatge
                   else if($this->CI->input->post('anuncis_image'))      
                   {
                   		//si a mes de l'element d'anuncis imatge tambe seleccionen una imatge
                       if($_FILES['imagen']['name']!='' && $this->CI->input->post('anuncis_image'))
                       {
                           return array('msg_errors'=>array('pp'=>'No puede publicar 2 imágenes a la vez'));      
                           
                       }
                       else
                       {
                           return array('table'=>'anuncios','content'=>'image','idelement'=>$this->CI->input->post('anuncis_image'));
                       }
                   }    
                   //si seleccionenn un element d'anuncis k es link
                   else if($this->CI->input->post('anuncis_link')) 
                   {
                   	   // si  a més de seleccionar un element danuncis link, omplen el camp link
                       if($this->CI->input->post('anuncis_link') && $this->CI->input->post('link'))
                       {
                           return array('msg_errors'=>array('pp'=>'No puede publicar 2 enlaces a la vez'));      
                         
                       }
                       else if($_FILES['imagen']['name']!='' && $this->CI->input->post('anuncis_link'))
                       {
                       	return array('msg_errors'=>array('aa'=>'No puede publicar una imagen y un link'));      
                           
                       }
                       else
                       {
                           return array('table'=>'anuncios','content'=>'link','idelement'=>$this->CI->input->post('anuncis_link'));
                       }
                   }   
               }
               else
               {
               	return array('msg_errors'=>array('aa'=>'Debe seleccionar un elemento de anuncios'));
               }
           }
           //si seleccionen una bbdd
           elseif($this->CI->input->post('bbdd'))
           {
           
           	//si no seleccionen cap element de bbdd ni omplen cap altre camp
               if($this->CI->input->post('bbdd_sentence')=='' && $this->CI->input->post('bbdd_image')=='' && $this->CI->input->post('bbdd_link')=='' && $this->CI->input->post('texto_facebook')=='' && $this->CI->input->post('link')=='' && $_FILES['imagen']['name']=="" )
               {
                   return array('msg_errors'=>array('pp'=>'Debe introducir un texto, imagen , enlace o seleccionar un elemento de una base de datos o anuncio para publicar'));          
                   
               }
               // si seleccionen algun element de bbdd i omplen algun altre camp
               elseif((/*($this->CI->input->post('bbdd_sentence')!='' ||*/ $this->CI->input->post('bbdd_image')!='') && ( $this->CI->input->post('link')!='' || (isset($_FILES['imagen']['name']) && $_FILES['imagen']['name']!="") ))
               {
                	return array('msg_errors'=>array('aa'=>'No puede publicar contenido de bases de datos con enlace o imágen'));
              
               }
               //si seleccionen algun element de bbdd
               elseif($this->CI->input->post('bbdd_sentence') || $this->CI->input->post('bbdd_image') || $this->CI->input->post('bbdd_link'))
               {
                   // si seleccionen un element de bbdd que es frase
                   if($this->CI->input->post('bbdd_sentence'))
                   {
                   		
                       
                       return array('table'=>'basesdedatos','content'=>'sentence','idelement'=>$this->CI->input->post('bbdd_sentence'));
                       
                   }
                   // si seleccionen un element de bbdd que es imatge
                   elseif($this->CI->input->post('bbdd_image'))
                   {
                   		// si seleccionen un element de bbdd que es imatge i omplen el camp imatge
                       if($_FILES['imagen']['name']!='' && $this->CI->input->post('bbdd_image'))
                       {
                           return array('msg_errors'=>array('aa'=>'No puede publicar 2 imágenes a la vez'));      
                           
                       }
                       else
                       {
                           return array('table'=>'basesdedatos','content'=>'image','idelement'=>$this->CI->input->post('bbdd_image'));
                       }
                   }
                   // si seleccionen un element  d bbdd que es link
                   else if($this->CI->input->post('bbdd_link')) 
                   {
                   		//si seleccionen un element de bbdd que es link i omplen el camp link
                       if($this->CI->input->post('bbdd_link') && $this->CI->input->post('link'))
                       {
                           return array('msg_errors'=>array('aa'=>'No puede publicar 2 enlaces a la vez'));      
                           
                       }
                       else if($_FILES['imagen']['name']!='' && $this->CI->input->post('bbdd_link'))
                       {
                       	return array('msg_errors'=>array('aa'=>'No puede publicar una imagen y un link'));      
                           
                       }
                       else
                       {
                       	return array('table'=>'basesdedatos','content'=>'link','idelement'=>$this->CI->input->post('bbdd_link'));
                       }
                   }   
                   
  

               
               }
               else
               {
               	return array('msg_errors'=>array('aa'=>'Debe seleccionar un elemento de bases de datos'));
               }


           }
            elseif($this->CI->input->post('link') && $_FILES['imagen']['name']!='' && $isfb==true)
            {
                  return array('msg_errors'=>array('pp'=>'Facebook no permite poner en una misma publicación imágenes y enlaces'));      
                  
          
            }
            else
            {
            	return false;
            }

                                   
			 
	}
  public function validateSaveAutoProg($bdid,$var_name,$user_app)
  {

      if($var_name=='anuncios')
      {
          $this->CI->load->model('anuncios_model');
            $bbdd=$this->CI->anuncios_model->getById($bdid);
          // si es de tipus sentences
          if($bbdd[0]->content=='sentence')
          {
            // agafo els elements de la base de dades seleccionada
            $elementsText=$this->CI->anuncios_model->getElements($bbdd[0]->content,array('bbdd_id'=>$bbdd[0]->id,'user_app'=>$user_app));
            // si nomès hi ha un element mostro  error
            if(count($elementsText)==1)
               {
                     echo json_encode(array('msg_errors'=>array('pp'=>"Ha seleccionado una base de datos de texto que contiene un elemento no se permite publicar repetidas veces el mismo elemento")));
                     exit;
               }
            }
      }
      else
      {
          $this->CI->load->model('bases_datos_model');
          $numbdtext=0;
          foreach ($bdid as $value){
            # code...
          
            $bbdd=$this->CI->bases_datos_model->getById($value);
            if($bbdd[0]->content=='sentence')
            {
              $numbdtext++;
               $bdtext=$bbdd;
            }
          }
          //si hnhi hauna 
          if($numbdtext==1)
          {
            //agafo els elements de la  base de dades
            $elementsText=$this->CI->bases_datos_model->getElements('sentence',array('bbdd_id'=>$bdtext[0]->id,'user_app'=>$user_app));
            //si nomes hi ha un ellement
            if(count($elementsText)==1)
            {
                        //mostro error
                           echo json_encode(array('msg_errors'=>array('pp'=>"Ha seleccionado una base de datos de texto que contiene un elemento no se permite publicar repetidas veces el mismo elemento")));        
                           exit;
            }


          }

      }


  }
  public function getAccountsByFolderFB()
  {
    
    $this->CI->load->model("social_user_accounts");
    $this->CI->load->model("folders");
    $this->CI->load->model("social_users");
    $data['user_accounts']=$this->CI->social_user_accounts->getUserAppAccounts(
      array(
        'user_app'=>$this->CI->flexi_auth->get_user_id()
        )
      );
    $data['user_accounts']=array_merge($data['user_accounts'],$this->CI->social_users->getUserAppUsers(array('user_app'=>$this->CI->flexi_auth->get_user_id(),'social_network'=>'fb')));
    
    $data['folders']=$this->CI->folders->get_many_by(array('user_app'=>$this->CI->flexi_auth->get_user_id(),'social_network'=>"fb"));
    $data['user_accounts_view']=null;
    $arraydata=array(
          'page'=>array(
            'folders'=>array(),
            'count'=>0,
            'nofolder'=>array()
            ),
          'group'=>array(
            'folders'=>array(),
            'count'=>0,
            'nofolder'=>array()
            ),
          'event'=>array(
            'folders'=>array(),
            'count'=>0,
            'nofolder'=>array()
            ),
          'user'=>array(
            'folders'=>array(),
            'count'=>0,
            'nofolder'=>array()
            )
      );
    $n=0;
    foreach ($data['folders'] as $key) {

      $arraydata[$key->type]['folders'][]=array('data'=>$key,'rows'=>array());
    }

    foreach ($data['user_accounts'] as $key) 
    {

      if(is_null($key->folder_id))
      {
        if(!isset($key->type_account))
        { 
         $arraydata['user']['nofolder'][]=$key;
         $arraydata['user']['count']++;
        }
        else
        {
          $arraydata[$key->type_account]['nofolder'][]=$key;
          $arraydata[$key->type_account]['count']++;
        }
        
      }
      else
      { 
        if(!isset($key->type_account)){
          if(count($arraydata['user']['folders'])!=0)
          for($m=0;$m<count($arraydata['user']['folders']);$m++)
          {
            //var_dump($arraydata['user']['folders'][1]);
            if($arraydata['user']['folders'][$m]['data']->id==$key->folder_id)
            $arraydata['user']['folders'][$m]['rows'][]=$key;       


          }
          $arraydata['user']['count']++;
        }
        else
        {
          if(count($arraydata[$key->type_account]['folders'])!=0)
          for($m=0;$m<count($arraydata[$key->type_account]['folders']);$m++)
          {
            //var_dump($arraydata[$key->type_account]['folders'][1]);
            if($arraydata[$key->type_account]['folders'][$m]['data']->id==$key->folder_id)
            $arraydata[$key->type_account]['folders'][$m]['rows'][]=$key;       
          }
          $arraydata[$key->type_account]['count']++;
        }
      }
    }
    $numTotal=0;
    foreach ($arraydata as $type) {
     $numTotal+=$type['count'];
    }
    $arraydata['numTotal']=$numTotal;
    return $arraydata;
  }
  public function getAutoProgByFolder($type,$social_network)
  {
      $array=array('bbdd'=>'basededatos','anunci'=>'anuncios');
      $this->CI->load->model('folders_autoprog');
      $model_autoprog_content='autoprog_'.$array[$type];

      $this->CI->load->model($model_autoprog_content);
      $data['folders']=$this->CI->folders_autoprog->get_many_by(array('user_app'=>$this->CI->flexi_auth->get_user_id(),'social_network'=>$social_network,'type'=>$type));
      $autoprogramaciones=$this->CI->$model_autoprog_content->get_many_by(array('socialnetwork'=>$social_network,'user_app'=>$this->CI->flexi_auth->get_user_id()));
      foreach ($autoprogramaciones as $prog) {

        if($prog->type=='account')
        {
          $acc=$this->CI->social_user_accounts->getUserAppAccounts(
            array(
              'idaccount'=>$prog->accountid,
              'user_app'=>$this->CI->flexi_auth->get_user_id()
              ),1);
          $prog->name=$acc[0]->name;
        }
        else
        {
          $user=$this->CI->social_users->getUserAppUsers(
            array(
              'user_id'=>$prog->accountid,
              'user_app'=>$this->CI->flexi_auth->get_user_id()
              ),1); 
          $prog->name=$user[0]->username;
        }
      
      }
      $arraydata=array('folders'=>array(),'nofolder'=>array());
      //per cada carpeta creo un subarray amb les dades de la carpeta i preparo un array per les programacions de dins la carpeta
      foreach ($data['folders'] as $key) {
        
        $arraydata['folders'][]=array('data'=>$key,'rows'=>array());

        
        

      }
      $num=0;
      foreach ($autoprogramaciones as $prog) {
      if(is_null($prog->folder_id))
      {
        $arraydata['nofolder'][]=$prog;
      }
      else
      {
        if(count($arraydata['folders'])!=0)
          for($m=0;$m<count($arraydata['folders']);$m++)
          {
            //var_dump($arraydata[$key->type_account]['folders'][1]);
            if($arraydata['folders'][$m]['data']->id==$prog->folder_id)
            $arraydata['folders'][$m]['rows'][]=$prog;        
          }
      }
      $num++;
    }
    $arraydata['numTotal']=$num;
    return $arraydata;
      
  


      
  }
  public function getProgramationsByFolder($social_network)
  {
    $this->CI->load->model("folders_programations"); 
    $this->CI->load->model("programations");
    //agafo les carpettes
    $data['folders']=$this->CI->folders_programations->get_many_by(array('user_app'=>$this->CI->flexi_auth->get_user_id(),'social_network'=>$social_network));
    //agafo les programacions
      $programaciones=$this->CI->programations->get_many_by(array('user_app'=>$this->CI->flexi_auth->get_user_id(),'social_network'=>$social_network));
      foreach ($programaciones as $prog) {

        if($prog->type_socialaccount=='account')
        {
          $acc=$this->CI->social_user_accounts->getUserAppAccounts(
            array(
              'idaccount'=>$prog->socialaccount,
              'user_app'=>$this->CI->flexi_auth->get_user_id()
              ),1);
          $prog->name=$acc[0]->name;
        }
        else
        {
          $user=$this->CI->social_users->getUserAppUsers(
            array(
              'user_id'=>$prog->socialaccount,
              'user_app'=>$this->CI->flexi_auth->get_user_id()
              ),1); 
          $prog->name=$user[0]->username;
        }
      
      }
      //preparo array d dades
      $arraydata=array('folders'=>array(),'nofolder'=>array());
      //per cada carpeta creo un subarray amb les dades de la carpeta i preparo un array per les programacions de dins la carpeta
      foreach ($data['folders'] as $key) {
        
        $arraydata['folders'][]=array('data'=>$key,'rows'=>array());

        
        

      }
      $num=0;
    foreach ($programaciones as $prog) {
      if(is_null($prog->folder_id))
      {
        $arraydata['nofolder'][]=$prog;
      }
      else
      {
        if(count($arraydata['folders'])!=0)
          for($m=0;$m<count($arraydata['folders']);$m++)
          {
            //var_dump($arraydata[$key->type_account]['folders'][1]);
            if($arraydata['folders'][$m]['data']->id==$prog->folder_id)
            $arraydata['folders'][$m]['rows'][]=$prog;        
          }
      }
      $num++;
    }
    $arraydata['numTotal']=$num;
    return $arraydata;
      


  }
  public function getAccountsByFolderTwT()
  {
    $this->CI->load->model("folders");
    $this->CI->load->model("social_users");
      $users=$this->CI->social_users->getUserappUsers(array('user_app'=>$this->CI->flexi_auth->get_user_id(),'social_network'=>'tw'));
    $this->CI->load->model('folders');
    $data['folders']=$this->CI->folders->get_many_by(array('user_app'=>$this->CI->flexi_auth->get_user_id(),'social_network'=>"tw"));
    $arraydata=array('folders'=>array(),'nofolder'=>array());

    foreach ($data['folders'] as $key) {
      
      $arraydata['folders'][]=array('data'=>$key,'rows'=>array());
      
      
    }
    $num=0;
    foreach ($users as $user) {
      if(is_null($user->folder_id))
      {
        $arraydata['nofolder'][]=$user;
      }
      else
      {
        if(count($arraydata['folders'])!=0)
          for($m=0;$m<count($arraydata['folders']);$m++)
          {
            //var_dump($arraydata[$key->type_account]['folders'][1]);
            if($arraydata['folders'][$m]['data']->id==$user->folder_id)
            $arraydata['folders'][$m]['rows'][]=$user;        
          }
      }
      $num++;
    }
    $arraydata['numTotal']=$num;
    return $arraydata;
  }
}

/* End of file MY_form_validation2.php */
/* Location: ./application/libraries/MY_form_validation2.php */
