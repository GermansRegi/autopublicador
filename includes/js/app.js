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
					//		document.location.href=base_url+'panel/herramientas';
							nxt();
	                      }); 	
					}
			}
		 },$btn)	
	})
	$('body').on('submit','#herramtw',function(e){
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
			{	if(data.req_auth==1)
				{
			
					window.location.href=base_url+"panel";
				}
				if(data.users)
				{
					var str='';
					$("#resultsearch .users").children().remove();
                    
					for(var p=0;p<data.users.length;p++)
					{
						str+='<div class="col-lg-2">'							
                        console.log(data.users[p].length);
						for(var i=0;i<data.users[p].length;i++)
						{

							str+="<div class='checkbox'><input type='checkbox' name='usernames[]' value='"+data.users[p][i].id+"'><span>"+data.users[p][i].screen_name+"</span></div>";
						}
						str+="</div>";
					}

					$(str).appendTo('#resultsearch .users');
					$("#resultsearch").removeClass('hidden')
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
				if(data.req_auth==1)
				{
			
					window.location.href=base_url+"panel";
				}
			
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
		 		success:function(data)
				{
					if(data.req_auth==1)
					{
				
						window.location.href=base_url+"panel";
					}
				},
				complete:function(data)
			 	{
			 		$('#line'+id).remove();
			 	}
			})
	})	
	$('body').on('click','ul.js-list-container a',function(){
		if($(this).hasClass("active")==false)
		{
			$(this).addClass('active');
			$('.addtwtlists').removeAttr('disabled');
		}
	})
	$('body').on('click','.addtwtlists',function(){
		var $this=$(this);
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
			beforeSend:function () {
				$this.attr('disabled',true);
			},
			success:function(data)
				{
					if(data.req_auth==1)
					{
				
						window.location.href=base_url+"panel";
					}
				},
			complete:function(data){
				//$("#ajaxModal").modal('hide');
				document.location.href=current_url+'?userlist='+userid;
			}
		})


	})
	$('body').on('click','.column-link-actions',function(){
		var content=$(this).parent().parent();
		if(content.find('.column-list-options').hasClass('hidden'))
		{
			$(content).find('.scrollable').css('top','34px');
			$(this).css('background-color','#fff');
			$(content).find('.column-list-options').slideUp(300).removeClass('hidden');
			

		}
		else
		{
			$(content).find('.scrollable').css('top','0px');
			$(this).css('background-color','#e6e6e6');
			$(content).find('.column-list-options').slideDown().addClass('hidden');
			
		}

	})
	// edicion de listas de twiiter


	$('body').on('click','.clear-list-content',function () {
		$(this).parent().parent().parent().next().children().remove();
		console.log($(this).parent().parent().parent().next());
	})
	$('body').on('click','.quit-list',function(){
		var $this=$(this);
		var idlist=$(this).parent().parent().parent().parent().parent().data('id');
			$.ajax({url:base_url+'panel/twitter/quitList/'+idlist,
				type:'get',
				dataType:'json',
				success:function(data)
				{
					if(data.req_auth==1)
					{
				
						window.location.href=base_url+"panel";
					}
				},
				complete:function(data)
				{
					
					$this.parent().parent().parent().parent().parent().remove();
				}

			})
	})

	var sourcelistmember   = $("#entry-member-template").html();
	
	var templatelistmember = Handlebars.compile(sourcelistmember);
	$('body').on('keypress','#user-search',function (event) {
		 var keyCode = (event.keyCode ? event.keyCode : event.which); 
		if (keyCode == 13) {
        	$('#user-search').trigger('click');
    	}
	})
	$('body').on('click','#user-search',function(){
		var text=$(this).val();
		var listid=$('.edit-list').data('listid');

		$.ajax({url:base_url+'panel/twitter/listsearchusers',
		type:'get',
		data:{q:text,listid:listid},
		dataType:'json',
		success:function(data){
				if(data.req_auth==1)
				{
			
					window.location.href=base_url+"panel";
				}
			
$('.list-search > .list-container').empty();
				for (var i=0;i<data.length;i++)
				{
					console.log(data[i]);
					var html2    = templatelistmember(data[i]);
			
					$('.list-search > .list-container').append(html2);
				}
			
		}})
	})
})

$('body').on("click",".js-add-remove",function(e){
	var screen_name=$(this).next().find('.username').text();
	var listid=$('.edit-list').data('listid');
	var $this=$(this);
	if($(this).hasClass('s-nonmember'))
	{
		
		$.ajax({url:base_url+'panel/twitter/addmemberlist',type:'post',dataType:'json',
			data:{screen_name:screen_name,listid:listid},
			beforeSend:function()
			{
				$this.find('.nonmember').hide()
				$this.find('.working').show()
				
			},
			success:function(data)
			{
				if(data.req_auth==1)
				{
			
					window.location.href=base_url+"panel";
				}
			   	
			}
			, 
			complete:function () {
				var li=$this.parent('li').clone()
				//li.find('.js-add-remove').find('.member *').show();
				li.find('.js-add-remove').find('.working').hide();
				li.find('.js-add-remove').removeClass('s-nonmember').addClass('s-member');
				$this.removeClass('s-nonmember').addClass('s-checked');
		
				li.find('.js-add-remove').find('.member').show();
				$this.find('.working').hide()
				$this.find('.checked').show();
								$('.list-members .list-container').append(li)
			}})
			

	}
	else if($this.hasClass("s-member"))
	{
		$.ajax({url:base_url+'panel/twitter/removeMemberlist',type:'post',dataType:'json',
			data:{screen_name:screen_name,listid:listid},
			beforeSend:function()
			{
				$this.find('.member').hide()
				$this.find('.working').show()
				$this.find('.checked').hide();
			},
			success:function(data)
			{
				if(data.req_auth==1)
				{
			
					window.location.href=base_url+"panel";
				}
			   	
			}
			, 
			complete:function () {
				
				$this.find('.working').hide();
	
				
				var li=$this.parent('li');
				li.find('.js-add-remove').removeClass('s-member').addClass('s-checked');
			//	console.log($('.list-search .list-container').find(li));
			//	
			//	
				var id=li.data("usersearchid");

				console.log(id);
				$('.list-search .list-container').find("[data-usersearchid='" + id + "']").find('.js-add-remove').removeClass('s-checked').addClass('s-nonmember').find('.nonmember').show();
				$('.list-search .list-container').find("[data-usersearchid='" + id + "']").find('.js-add-remove').find('.checked').hide();
					
				li.remove()

			}})	
	}
	else if($this.hasClass("s-checked"))
	{
				$.ajax({url:base_url+'panel/twitter/removeMemberlist',type:'post',
			data:{screen_name:screen_name,listid:listid},
			beforeSend:function()
			{
				$this.find('.member').hide()
				$this.find('.working').show()
				$this.find('.checked').hide();
			}, 
			success:function(data)
			{
				if(data.req_auth==1)
				{
			
					window.location.href=base_url+"panel";
				}
			   	
			},
			complete:function () {
				
				$this.find('.working').hide();
				$this.find('.nonmember').show();
				
				var li=$this.parent('li');
			//	li.find('.js-add-remove').removeClass('s-member').addClass('s-checked');
			//	console.log($('.list-search .list-container').find(li));
			//	
				var id=li.data("usersearchid");

				console.log(id);
				$('.list-members .list-container').find("[data-usersearchid='" + id + "']").remove()
					
				li.find('.js-add-remove').removeClass('s-checked').addClass('s-nonmember').find('.nonmember').show();

			}})	
	}


})

	$('body').on('submit','#update-list',function(e){
		e.preventDefault()
		var listid=$(this).find('.edit-detail-list').data('listid');
		var userid=$(this).find('.edit-detail-list').data('userid');
		$.ajax({url:base_url+'panel/twitter/editdetailslist/'+listid,
			type:'post',
			data:$(this).serialize(),
			dataType:'json',
			success:function (data){
				if(data.req_auth==1)
				{
			
					window.location.href=base_url+"panel";
				}
			   		
			},
			complete:function(){
				
				$("#ajaxModal").modal('hide');
				document.location.href=current_url+'?userlist='+userid;								
			}})

	})

	$('body').on('submit','#create-list',function(e){
		e.preventDefault()
			
	var $this= $(this);
		
		var userid=$(this).find('.create-list').data('userid');
		$.ajax({url:base_url+'panel/twitter/crearlista',
			type:'post',
			data:$this.serialize(),
			dataType:'json',
			success:function (data){
				if(data.req_auth==1)
				{
			
					window.location.href=base_url+"panel";
				}
				else
				{
					var res=showResults(data,'','.messagemodal');
					if(res){
					$("#ajaxModal").modal('hide');	
					document.location.href=base_url+'panel/twitter/gestion_listas?userlist='+userid;								
					}
					
					
				}
			   		
			}})

	})
	$('body').on('change','.changecontent',function(){
		if($(this).val()=='image')
		{
			$('.watermark').removeClass('hidden');
		}
		else
		{
			$('.watermark').addClass('hidden');	
		}
	})