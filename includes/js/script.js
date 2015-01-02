	
		
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
	        else
	            {
	                
	            $(id).html(showSuccessForm(data.msg_success))
	            if(data.idcreated)
	            {
	            	return data.idcreated
	            }  
	            return true;
	      }
	    
	    
	   
	}

