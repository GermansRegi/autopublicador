$(function(){
	$('body').on('click','.deletecontent',function(){
		var id=$(this).data('id');
		$.ajax({url:deletecontent_url+"/"+id,
			type:'get',dataType:'json',
			success:function(data)
			{
		         var res=showResults(data,',','#message');
				if(res!=false)
				{
					      $('body').delay(1500).queue(function( nxt ) {
                                location.href=current_url;
                                nxt();
                            });  	
				}    
			}})
	})
	$('body').on('click','.delete',function(){
		
		var id=$(this).data('id')
		$.ajax({url:delete_url+'/'+id,
			type:'get',dataType:'json',
			success:function(data)
			{
		         var res=showResults(data,',','#message');
				if(res!=false)
				{
					$('body').delay(1000).queue(function( nxt ) {
						$('#line'+id).hide();
					nxt();
                            }); 
				 }    
			}})	
	})
	$('body').on('click','.deletemulti',function(){
		var contentlist=$("input[name='hk_group_bf[]']:checked").serializeArray();

		$.ajax({url:deletecontent_url,
			data:{delco:contentlist},
			type:'post',dataType:'json',
			success:function(data)
			{
				var res=showResults(data,',','#message');
				if(res!=false)
				{
					      $('body').delay(1500).queue(function( nxt ) {
                                location.href=current_url;
                                nxt();
                            });  	
				}
                      
			}})
	})
	$('body').on('submit',"#addbbdd",function(e)
	{
		e.preventDefault();
	
		
		var url=$(this).attr('action');
		var editUrl=url.replace('crear','editar');
		 var formdata =new FormData($(this)[0]);
		$.ajax({url:url,
			type:'POST',
			data:formdata,
			
			dataType:'json',
			success:function(data){

				var res=showResults(data,',','#message');
				console.log(res);
				if(res!=false)
				setTimeout(function(){location.href=editUrl+'/'+data.idcreated},1500)

			} ,
			processData:false,
			async:false,
			cache:false,
			contentType:false
		})

	})
	$('body').on('submit','#addcontent',function(e){
		e.preventDefault();
	
		
		var url=$(this).attr('action');
		
		 var formdata =new FormData($(this)[0]);
		$.ajax({url:url,
			type:'POST',
			data:formdata,
			
			dataType:'json',
			success:function(data){

				var res=showResults(data,',','#message');
				
				if(res!=false)
				{
					      $('body').delay(1500).queue(function( nxt ) {
                                location.href=url;
                                nxt();
                            });  	
				}

			} ,
			processData:false,
			async:false,
			cache:false,
			contentType:false
		})

	})
	console.log($("#toogle"));
	$("body").on('click','#toggle',function()
	{
		console.log("ssssss0");
		var checkboxes = document.getElementsByName('hk_group_bf[]');
        var button = document.getElementById('toggle');
        if(button.value == 'Marcar todos'){
            for (var i in checkboxes){
                checkboxes[i].checked = 'FALSE';
            }
            button.value = 'Desmarcar todos';
        }else{
            for (var i in checkboxes){
                checkboxes[i].checked = '';
            }
            button.value = 'Marcar todos';
        }	
	})
})