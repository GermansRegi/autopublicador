$(function(){
	$('body').on('submit',"#addrss",function(e){
		e.preventDefault()
		 var formdata =new FormData($(this)[0]);
		var url=$(this).attr('action');
			 
			 $.ajax({
		 	url:url,
		 	dataType:'json',
		 	type:'post',
		 	data:formdata,
		 	async:false,
		 	processData:false,
			async:false,
			cache:false,
			contentType:false,
			success:function(data)
			{
				var res=showResults(data,',','.message');
				if(res){
						$('body').delay(2000).queue(function( nxt ) {
							document.location.href=base_url+'panel/rss';
							nxt();
	                      }); 	
					}
			}
		 })
	})
	$('body').on('submit',"#herramfb",function(e)
	{
		e.preventDefault()
		 var formdata =new FormData($(this)[0]);
		var url=$(this).attr('action');
			 
			 $.ajax({
		 	url:url,
		 	dataType:'json',
		 	type:'post',
		 	data:formdata,
		 	async:false,
		 	processData:false,
			cache:false,
			contentType:false,
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
		 })	
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