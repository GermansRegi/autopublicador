

	$("body").on("click",".deleteaccount",function(e){
		e.preventDefault();
	var 	$this =$(this);
		$this.data("social")
		var isUser=Boolean($this.data("user"));
		var is_folder=Boolean($this.data("type"));
		console.log(is_folder);
		var n=notyfy(
				{
					text:"Seguro que quiere eliminar la "+((is_folder===true)?"carpeta":"cuenta")+"?",
					buttons:
						[	
							{
								text:"Cancelar",
								onClick:function(notyfy){
									notyfy.close()
								}
							},
							{
								text:"Acceptar",
								onClick:function(notyfyparent)
								{
									$.ajax({url:deletecontent_url,
										async:false,
										data:{"is_folder":is_folder,"id":$this.data("id"),"is_user":isUser},
										type:'get',
										dataType:"json",
										success:function(data){
											console.log(data);
											if(data.idFolder){
												var n=notyfy({
													text:'Esta carpeta tiene contenido, que quiere hacer?',
													buttons:[{
														addClass:"btn btn-primary",
														text:"Ubicar el contenido fuera de la carpeta",
														onClick:function(notyfy){
														onClickNoty("quit",data.idFolder,isUser);
														notyfy.close()
														document.location.href=current_url;			
														}
													}
													,
													{
														addClass:"btn btn-danger",
														text:"Eliminar el contenido",
														onClick:function(notyfy){
														onClickNoty("delete",data.idFolder,isUser);
														document.location.href=current_url;
														notyfy.close()		
														}
													}]
												})	
												$this.parent().parent().parent().parent().remove()
											}
											else
											{
												$this.parent().parent().remove()
											}
											notyfyparent.close()			
										}
									})								
								}
							}
						]
				});
	
	

	})

	function onClickNoty(type,id,isUser)
	{
		$.ajax({
			url:base_url+"panel/facebook/deleteQuitFolderContent",
			data:{"type":type,"id":id,"is_user":isUser},
			dataType:"json",
			type:"get",
			success:function(data){
				var res=showResults(data,',','.message');
			}
		});
	}
	$("body").on("click",".showHide",function(){
		console.log($(this).parent().next().is(":hidden"),$(this).next().is(":visible"))
	console.log($(this).next());
		if($(this).parent().next().is(":hidden"))
			$(this).parent().next().removeClass("hidden");

		else
			$(this).parent().next().addClass("hidden");
	})
	$("body").on("submit","#createFolder",function(e){
		e.preventDefault();
	
		$.ajax(
			{
				url:base_url+"panel/facebook/createFolder",
				data:
					$(this).serialize()
					,
				type:"post",
				dataType:"json",
				success:function(data){
					var res=showResults(data,',','.message');
					document.location.href=current_url;
				},

			});	
		return false;
	});
	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		var target = $(e.target).attr("href") // activated currTab
		$.cookie("currTab",target);
	});
	$(document).on("ready",function(){
		$("a[href="+$.cookie("currTab")+"]").tab("show")
	})
		$("BODY").on("change","#select-bbdd",function(){
			$this=$(this);
			var id=$this.val();
			$.ajax({url:base_url+"panel/facebook/get_bbddElements",
			type:'post',
			dataType:"json",		
			data:{"id":id,"page":1},
			success:function(data){
								
    					generate("generate-bbdd",data)
				
				
			},
		});
		});
			$("#generate-bbdd").on("click",".links",function(){

			})
		$("BODY").on("change","#select-anuncis",function(){
			$this=$(this);
			var id=$this.val();
			$.ajax({url:base_url+"panel/facebook/get_anuncisElements",
			type:'post',
			dataType:"json",		
			data:{"id":id,"page":1},
			success:function(data){
								
    					generate("generate-anuncis",data)
				
				
			},
		});
		});
			$("#generate-bbdd").on("click",".links",function(){

			})
		
		function generate(container,data)
		{
			    	$("#"+container).html("");
			    	if(data.data.length==0){
			    		$("<p>Debe añadir contenido a la base de datos seleccionada.</p>").appendTo("#"+container)
			    	}
			    	else for(i=0;i<data.data.length;i++)
				    	{
				    		$('<input type="checkbox" name="bbdd_'+data.content+'" value="'+data.data[i].id+'"/>').appendTo($("#"+container))
				    		if(data.content=="sentence"){	
				    			console.log(data.data[i]);
				    			$('<span>'+data.data[i].sentence+'</span>').appendTo($("#"+container))}
				    		else if(data.content=="image")
				    			$('<img width="60" src=">'+base_url+data.data[i].url+'"/>').appendTo($("#"+container))
				    		else
				    			$('<span>'+data.data[i].text+'</span>').appendTo($("#generate-bbdd"))
				    	}	


		}

	