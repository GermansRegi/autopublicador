$(function(){

	$('body').on('submit',"#addbbdd",function(e)
	{
		e.preventDefault();
	
		
		var url=$(this).attr('action');
		
		 var formdata =new FormData($(this)[0]);
		$.ajax({url:url,
			type:'POST',
			data:formdata,
			
			dataType:'json',
			success:function(data){

				var res=showResults(data,',','#message');
				console.log(res);
				if(res!=false)
				setTimeout(function(){location.href=base_url+'admin/basesdedatos/editar/'+data.idcreated},1500)

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
					
				}

			} ,
			processData:false,
			async:false,
			cache:false,
			contentType:false
		})

	})

})