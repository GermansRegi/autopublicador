$(function(){
	$('body').on('submit',"#addrss",function(e){
		e.preventDefault()
			var $btn//=Ladda.create($(this).find('input:submit')[0])
		 var formdata =new FormData($(this)[0]);
		var url=$(this).attr('action');
			 
			 makeajax({
		 	url:url,
		 	dataType:'json',
		 	type:'post',
		 	data:formdata,
		 	
			success:function(data)
			{
			//	$btn.stop();
				var res=showResults(data,',','.message');
				if(res){
						$('body').delay(2000).queue(function( nxt ) {
							document.location.href=base_url+'panel/rss';
							nxt();
	                      }); 	
					}
			}
		 },$btn)
	})
	$('body').on('submit',"#herramfb",function(e)
	{		var $btn=$(this).find('input:submit');
		e.preventDefault()
		 var formdata =new FormData($(this)[0]);
		var url=$(this).attr('action');
			 
			makeajax({
		 	url:url,
		 	dataType:'json',
		 	type:'post',
		 	data:formdata,
		 	success:function(data)
			{
				var res=showResults(data,',','.message');
				if(res){
						$('body').delay(2000).queue(function( nxt ) {
							document.location.href=base_url+'panel/herramientas';
							nxt();
	                      }); 	
					}
			}
		 },$btn)	
	})
	$('body').on('click',".deleterss",function(e){
		e.preventDefault()
		 
		var id=$(this).data('id')
			 
			 $.ajax({
		 	url:base_url+'panel/rss/delete',
		 	data:{id:id},
		 	dataType:'json',
		 	type:'post',
		 		async:false,
		 	complete:function(data)
			 	{
			 		$('#line'+id).remove();
			 	}
			})
	})	



})