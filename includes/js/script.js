$(function(){

  $('body').magnificPopup({type:'image'     ,
  	     closeOnContentClick: true,
  	     delegate:'a.image-link',
          closeBtnInside: false,
          fixedContentPos: true,
          mainClass: 'mfp-no-margins mfp-with-zoom', // class to remove default margin from left and right side
          image: {
            verticalFit: true
          },
          zoom: {
            enabled: true,
            duration: 300 // don't foget to change the duration also in CSS
          }});

$("body").on('click','#clearFile',function(e){
	  e.preventDefault();
	$("#filetoup").filestyle()
	/*
	  $("#filetoup").replaceWith();
	*/
	  $("#filetoup").val('');
	  $("#filetoup").next().find('input').val('')

});

 $('#time').timepicker({
                minuteStep: 1,
                showInputs: false,
                disableFocus: true,
                showMeridian:false,
               defaultTime:$('#time').find('input').val()
            });
 $('#time').timepicker().on('changeTime.timepicker', function(e) {
 		$('#time').find('input').val(e.time.value);
    
    });
 
 $(".date").datepicker({ language: 'es',
		todayBtn: true,
		todayHighlight: false,
		format: 'dd-mm-yyyy',

		});
 $(document).on('click','.nav-tabs li a',function(e){
		e.preventDefault();
	    $(this).tab("show");
	});
$(document).on('click', '[data-toggle="ajaxModal"]',function(e){
       e.preventDefault();
      var $this = $(this);
          var $remote = $this.data('remote') || $this.attr('href')
         
          
          var $modal = $('<div class="modal fade" id="ajaxModal"><div class="modal-dialog" id="myModal"><div class="modal-content"></div></div></div>');
       	 
     
        $.ajax({
        	url:$remote,
        	type:'get',
        	dataType:'html',
        	success:function(data){
        		console.log(data);
        			if(data=="{\"req_auth\":1}")
        			{
        				window.location.href=base_url+"panel";
        			}
        			else
        			{
        				if($("#ajaxModal").length!=0)
				          {

						    	$("#ajaxModal").remove();          	
				          }
        				$modal.find(".modal-content").html(data); 	
		        		$modal.modal()	
        			}
		        	
        	}

        

        })
       
       

 	})
$('body').on('hidden.bs.modal',"#ajaxModal", function () {
    $(this).remove();
});

$("body").on('click','#premiumnormal',function(){
		                    	//$("body").on('click','#premiumnormal',function() {
		                    		console.log('pp');
		                            $("#pagoplanp").show();
		                            $(".box-plan").hide();
		                        });
	
$("body").on('click','.closeplan',function(){
		                    	//$("body").on('click','#premiumnormal',function() {
		                    		console.log('pp');
		                            $("#pagoplanp").hide();
		                            $(".box-plan").show();
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
                            $(".message").noty({
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
    		console.log(seg);
	    	if(elem==null)
	    	{

	    		var notyp=noty({text:text,type:type	,layout:position,dismissQueue:true,timeout:seg,maxVisible:1});
	    	}
	    	else
		{
	    		console.log(elem,$(elem));
	    		$(elem).noty({
	  		text:text,type:type	,dismissQueue:false,timeout:seg,maxVisible:1
			});
	    }
	 
	    
    }
	function showResults(data,form,id)
	{
		
		//$.notyfy.closeAll();
		if(data.req_auth==1)
		{
	
			window.location.href=base_url+"panel";
		}
	   	if(data.msg_errors)
		{	
		     //$(id).html(showErrorsForm(data.msg_errors));
		     generateNotify(id,"top",showErrorsForm(data.msg_errors),"error",3000);
			return false
		}
		else if(data.msg_success)
		{      
			
		     //console.log($(id),showSuccessForm(data.msg_success));
		     generateNotify(id,"top",showSuccessForm(data.msg_success),"success",3000);
		     if(data.idcreated)
			{
		  		return data.idcreated
       		}  
	          return true;
	     }
	}
