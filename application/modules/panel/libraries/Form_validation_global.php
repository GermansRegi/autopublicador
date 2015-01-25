<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Form_validation_global 
{
	public function __construct()
	{
		$this->CI =& get_instance();
	}
	public function ErrorsPublicar($arrayPost)
	{
		if($this->CI->input->post('anuncis') && $this->CI->input->post('bbdd'))
          {
          	
             if(($this->CI->input->post('anuncis_link') || $this->CI->input->post('anuncis_sentence') || $this->CI->input->post('anuncis_img')) && ($this->CI->input->post('bbdd_img') || $this->CI->input->post('bbdd_sentence') || $this->CI->input->post('bbdd_link')) )
               {    
                       return array('msg_errors'=>array('pp'=>'No puede publicar contenido de anuncios y bases de datos a la vez'));
                       
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
               //si selecciona algun element d'anuncis i entra algun altre camp
               elseif(($this->CI->input->post('anuncis_sentence')!='' || $this->CI->input->post('anuncis_img')!='' || $this->CI->input->post('anuncis_link')!='') && ( $this->CI->input->post('texto_facebook')!='' || $this->CI->input->post('link')!='' || (isset($_FILES['imagen']['name']) && $_FILES['imagen']['name']!="")  ))
               {
                   return  array('msg_errors'=>array('pp'=>'No puede publicar contenido de anuncios con texto, enlace o imágen'));
                   
               }
               //si algun element d'anuncis es seleccionat
               elseif($this->CI->input->post('anuncis_sentence') || $this->CI->input->post('anuncis_link') || $this->CI->input->post('anuncis_img'))
               {
               	//si selecciona un element danuncis  que es text
                   if($this->CI->input->post('anuncis_sentence'))
                   {
                   		//si a mes de l'element danuncis de text, omplen el camp text
                       if($this->CI->input->post('texto_facebook') && $this->CI->input->post('anuncis_sentence') )
                       {
                           return array('msg_errors'=>array('pp'=>'No puede publicar 2 textos a la vez'));      
                          
                       }    
                       else
                       {
                       		return array('table'=>'anuncios','content'=>'sentence','idelement'=>$this->CI->input->post('anuncis_sentence'));
                        	
                       }
                   }
                   //si seleccionen un element danuncis que es imatge
                   else if($this->CI->input->post('anuncis_img'))      
                   {
                   		//si a mes de l'element d'anuncis imatge tambe seleccionen una imatge
                       if($_FILES['image']['name']!='' && $this->CI->input->post('anuncis_image'))
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
                       else
                       {
                           return array('table'=>'anuncios','content'=>'link','idelement'=>$this->CI->input->post('anuncis_link'));
                       }
                   }   
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
               elseif(($this->CI->input->post('bbdd_sentence')!='' || $this->CI->input->post('bbdd_image')!='') && ($this->CI->input->post('texto_facebook')!='' || $this->CI->input->post('link')!='' || (isset($_FILES['imagen']['name']) && $_FILES['imagen']['name']!="") ))
               {
                	return array('msg_errors'=>array('aa'=>'No puede publicar contenido de bases de datos con texto, enlace o imágen'));
              
               }
               //si seleccionen algun element de bbdd
               elseif($this->CI->input->post('bbdd_sentence') || $this->CI->input->post('bbdd_image') || $this->CI->input->post('bbdd_link'))
               {
                   // si seleccionen un element de bbdd que es frase
                   if($this->CI->input->post('bbdd_sentence'))
                   {
                   		//si seleccionen un element d bbdd que es frase, i omplen el camp text
                       if($this->CI->input->post('bbdd_sentence') && $this->CI->input->post('texto_facebook'))
                       {
                           return array('msg_errors'=>array('aa'=>'No puede publicar 2 textos a la vez'));      
                           
                      
                       }
                       else
                       {
                       		return array('table'=>'basesdedatos','content'=>'sentence','idelement'=>$this->CI->input->post('bbdd_sentence'));
                       }
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
                   else if($this->input->post('bbdd_link')) 
                   {
                   		//si seleccionen un element de bbdd que es link i omplen el camp link
                       if($this->CI->input->post('bbdd_link') && $this->CI->input->post('link'))
                       {
                           return array('msg_errors'=>array('aa'=>'No puede publicar 2 enlaces a la vez'));      
                           
                       }
                       else
                       {

                           return array('table'=>'basesdedatos','content'=>'link','idelement'=>$this->CI->input->post('bbdd_link'));
                       }
                   }   
                   
  

               
               }


           }
            elseif($this->CI->input->post('link') && $_FILES['imagen']['name']!='')
            {
                  return array('msg_errors'=>array('pp'=>'Facebook no permite poner en una misma publicación imágenes y enlaces'));      
                  
          
            }
            else
            {
            	return false;
            }

                                   
			 
	}
	

}

/* End of file MY_form_validation2.php */
/* Location: ./application/libraries/MY_form_validation2.php */
