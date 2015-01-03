

    
if($(idUploader).length!=0){
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
                         

                                  var res=showResults(data,'.',"#message")
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
                            $("#message").html("<div class='greenbox'><p>Se ha creado correctamente</p></div>")
                        
                            
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
	  console.log(p);
	    var str="<div class='alert alert-danger'>";
	    for (i in p)
	        {
	            str+='<p>'+p[i]+'</p>';
	        }
	        
	        return str+"</div>";

	}

	function showSuccessForm(text)
	{
	   
	            return '<div class="alert alert-success"><p>'+text+'</p></div>';
	}
	function showResults(data,form,id)
	{
	    //console.log(data)
	              //form.find(id).text(data);
	//console.log(data,typeof data);
	  
		$(id).children().remove();
			            

	    	if(data.msg_errors)
	        {


	              $(id).html(showErrorsForm(data.msg_errors));
	            return false
	        }
	        else if(data.msg_success)
	            {
	                
	            $(id).html(showSuccessForm(data.msg_success))
	            if(data.idcreated)
	            {
	            	return data.idcreated
	            }  
	            return true;
	      }
	    
	    
	   
	}

