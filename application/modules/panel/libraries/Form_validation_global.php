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
          	
             if(($this->CI->input->post('anuncis_link') || $this->CI->input->post('anuncis_sentence') || $this->CI->input->post('anuncis_img')) && ($this->CI->input->post('bbdd_img') || $this->CI->input->post('bbdd_sentence') || $this->CI->input->post('bbdd_link')) )
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
          	if($this->CI->input->post('anuncis_sentence')=='' && $this->CI->input->post('anuncis_link')=='' && $this->CI->input->post('anuncis_img')=='' && $this->CI->input->post('texto_facebook')=='' && $this->CI->input->post('link')=='' && $_FILES['imagen']['name']=="" )
               
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

}

/* End of file MY_form_validation2.php */
/* Location: ./application/libraries/MY_form_validation2.php */
