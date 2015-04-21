$(function(){
	$('body').on('submit',"#addrss",function(e){
		e.preventDefault();
	var $btn=$(this).find('input[data-loading]');
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
	{
		var $btn=$(this).find('input[data-loading]');
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
	$('body').on('submit',"#herramfbimages",function(e)
	{var pthis=$(this);
		var $btn=$(this).find('input[data-loading]');
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
				if(data.pages)
				{
					$("#selectpage").children().remove('option[value!=""]');
					for (var o=0;o<data.pages.length;o++)
					{
						$("<option value='"+data.pages[o].id+"'>"+data.pages[o].name+"</option>").appendTo($("#selectpage"));
					}
					$("#pagelist").removeClass('hidden');
				}
				else if(data.data)
				{
					$("#albums").children().remove();
					$("#selectbd").children().remove('option[value!=""]');
					for(var i=0;i<data.data.length;i++)
					{
						$('<input title="'+data.data[i].name+'" type="radio" name="albumid" value="'+data.data[i].id+'"/>').appendTo($("#albums"))
			
						$('<img title="'+data.data[i].name+'" width="50" height="50" src="https://graph.facebook.com/v2.2/'+data.data[i].id+'/picture?type=album&access_token='+data.accesstoken+'"/>').appendTo($("#albums"))
					}
					for (var o=0;o<data.bd.length;o++)
					{
						$("<option value='"+data.bd[o].id+"'>"+data.bd[o].name+"</option>").appendTo($("#selectbd"));
					}
					$("#findpageresp").removeClass('hidden');
					pthis.find('input[type=submit]').val('Guardar');
				}
				else
				{
					var res=showResults(data,',','.message');
					if(res){
							$('body').delay(2000).queue(function( nxt ) {
							document.location.href=base_url+'panel/herramientas';
							nxt();
	                      }); 	
					}
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
	$('body').on('click','ul.js-list-container a',function(){
		if($(this).hasClass("active")==false)
			$(this).addClass('active');
	})
	$('body').on('click','.addtwtlists',function(){
		var ownlistsids=Array();
		$(".ownlists ul.js-list-container a.active").each(function(i,m){
			ownlistsids.push($(m).data('id'));
		});
		var subslistsids=Array();
		$(".subslists ul.js-list-container a.active").each(function(i,m){
			subslistsids.push($(m).data('id'));
		});
		var userid=$('.listsToAdd').data('user-id');
		$.ajax({url:base_url+'panel/twitter/addLists',
			type:'post',
			dataType:'json',
			data:{ownlistsids:ownlistsids,subslistsids:subslistsids,userid:userid},
			success:function(data){

			}
		})


	})


})
