

$(function(){

console.log($('#premiumnormal'));
$("body").on('click','#premiumnormal',function(){
		                    	//$("body").on('click','#premiumnormal',function() {
		                    		console.log('pp');
		                            $("#pagoplanp").show();
		                            $(".box-plan").hide();
		                        });

	
})

    
if(idUploader){
	// Setup html5 version
        //pp
	$(idUploader).pluploadQueue({
		// General settings
		runtimes : 'html5,flash,silverlight,html4',
		url : url_plupload,
		chunk_size: '1mb',
		rename : true,
		dragdrop: true,
		file_data_name:'file',
		filters : {
			// Maximum file size
			max_file_size : '10mb',
			// Specify what files to browse for
			mime_types: [
				{title : "Archivos de imágen", extensions : "jpg,gif,png"},
				
			]
		},

		// Resize images on clientside if we can
	//	resize : {width : 320, height : 240, quality : 90},

		flash_swf_url : flash_swf_urlfile,
		silverlight_xap_url : silverlight_xap_urlfile,
                init:{
                    BeforeUpload:function(up,file)
                    {
                               

                          $.ajax({url:checkmaxelements_url,
                            dataType:'json',type:'get',  
                            async:false,  
                        success:function(data){
                         

                                  var res=showResults(data,'.',".message")
                         console.log(res);
                         
                          		if(res==false)
                                  {
                                    
                                    up.stop();    
                                   $('body').delay(1500).queue(function( nxt ) {
		                                location.href=url_plupload;
		                                nxt();
		                            });  
                                    
                                  }
                           

                       
                        }})
                        
                          
                    },
       
                    UploadComplete:function()
                    {
                            $(".message").notyfy({
	  				text:'Datos guardados con éxito',type:'success'	
					});
                        
                            
                             $('body').delay(1500).queue(function( nxt ) {
                                location.href=url_plupload;
                                nxt();
                            });
                  
                      
                     }
                }
	})
	}

		
	function showErrorsForm(p)
	{
	  
	    var str="<div title='Clicar para esconder'>";
	       	    for (i in p){
	           str+='<p>'+p[i]+'</p>';
	        }
	        
	        return str+"</div>";

	}

	function showSuccessForm(text)
	{
	   
	            return '<div title="Clicar para esconder"><p>'+text+'</p></div>';
	   //         return ''+text+'';
	}

    function generateNotify(elem,position,text,type,seg){
    		if(type=="error")
    		{
    			
    		}
	    	if(elem==null)
	    	{
	    		var noty=$.notyfy({text:text,type:type,dismissQueue:false});
	    	}
	    	else
		{
	    	//	console.log(elem,$(elem));
	    		$(elem).notyfy({
	  		text:text,type:type	,dismissQueue:true,timeout:seg
			});
	    }
	 
	    
    }
	function showResults(data,form,id)
	{
		
	    	if(data.msg_errors)
		{
		     //$(id).html(showErrorsForm(data.msg_errors));
		     generateNotify(id,"top",showErrorsForm(data.msg_errors),"error",3);
			return false
		}
		else if(data.msg_success)
		{      
			$(id).children('.notyfy_error').remove();
		     //$(id).html(showSuccessForm(data.msg_success))
		     generateNotify(id,"top",showSuccessForm(data.msg_success),"success",4);
		     if(data.idcreated)
			{
		  		return data.idcreated
       		}  
	          return true;
	     }
	}

	