
	// event per eliminar contes i carpetes de xarxes socials
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
														notyfy.close()
														onClickNoty("quit",data.idFolder,isUser);
														
														
														
														}
													}
													,
													{
														addClass:"btn btn-danger",
														text:"Eliminar el contenido",
														onClick:function(notyfy){
														notyfy.close()		
														onClickNoty("delete",data.idFolder,isUser);
														//document.location.href=current_url;
														
														}
													}]
												})	
			
											}
											else
											{

											
													var res=showResults(data,',',null);
																			
											
												
												//document.location.href=current_url;									
											}
											
											notyfyparent.close()			
										}
									})									
								}
							}
						]
				});
	
	

	})
	//
	function onClickNoty(type,id,isUser)
	{
		$.ajax({
			url:base_url+"panel/facebook/deleteQuitFolderContent",
			data:{"type":type,"id":id,"is_user":isUser},
			dataType:"json",
			type:"get",
			success:function(data){
				
						var res=showResults(data,',',null);
												
				
									
			}
		});
	}
	// event per mostrar i amagar el formulari 
	$("body").on("click",".showHide",function(){
		console.log($(this).parent().next().is(":hidden"),$(this).next().is(":visible"))
	console.log($(this).next());
		if($(this).parent().next().is(":hidden"))
			$(this).parent().next().removeClass("hidden");

		else
			$(this).parent().next().addClass("hidden");
	})
	// event per crear carpetes per a contenir cuentas
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
	// events per obrir tabs en cuentas  d facebook
	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		var target = $(e.target).attr("href") // activated currTab
		$.cookie("currTab",target);
	});
	$(document).on("ready",function(){
		$("a[href="+$.cookie("currTab")+"]").tab("show")
	})
	// events per generar elements d base d dades al publicar o programmar
	$("BODY").on("change",".generate-select",function(){
		$this=$(this);
		var typeselect=$this.data('typeselect');
		var id=$this.val();
		$.ajax({
			url:base_url+"panel/facebook/get_"+typeselect+"Elements",
			type:'post',
			dataType:"json",		
			data:{"id":id},
			async:false,
			success:function(data){
				generate("generate-"+typeselect,data)
			},
		});
	});
	$("body").on("click","#generate-bbdd > div > ul.pagination a",function(e){
		e.preventDefault();
		$.ajax({
			url:$(this).attr('href'),
			type:'post',
			dataType:"json",		
			data:{"id":$('#select-bbdd').val()},
			async:false,
			success:function(data){
				generate("generate-bbdd",data)
			},
		});

	})

	$("body").on("click","#generate-anuncis > div > ul.pagination a",function(e){
		e.preventDefault();
		$.ajax({
			url:$(this).attr('href'),
			type:'post',
			dataType:"json",		
			data:{"id":$('#select-anuncis').val()},
			async:false,
			success:function(data){
				generate("generate-anuncis",data)
			},
		});

	})

	
//generar elements de base d daddes per publicar i prohgramar
	function generate(container,data)
	{
	
		$("#"+container).html("");
		if(data.data.length==0){
			$("<p>Debe añadir contenido a la base de datos seleccionada.</p>").appendTo("#"+container)
		}
		else 
		{
			for(i=0;i<data.data.length;i++)
			{
				$('<input type="checkbox" name="bbdd_'+data.content+'" value="'+data.data[i].id+'"/>').appendTo($("#"+container))
				if(data.content=="sentence"){	
					$('<span>'+data.data[i].sentence+'</span>').appendTo($("#"+container))}
				else if(data.content=="image")
					$('<img width="60" src=">'+base_url+data.data[i].url+'"/>').appendTo($("#"+container))
				else
					$('<span>'+data.data[i].text+'</span>').appendTo($("#"+container))
			}	
			if(data.pager!='')
			{
				$(data.pager).appendTo($("#"+container))
			}
		}	
	}

	$('body').on('submit',"#publicarahora",function(e){
		e.preventDefault();
		 var formdata =new FormData($(this)[0]);
		 var url=$(this).attr('action');
		 $.ajax({
		 	url:url,
		 	type:'post',
		 	data:formdata,
		 	async:false,
		 	processData:false,
			async:false,
			cache:false,
			contentType:false,
			success:function(data)
			{

			}
		 })
	})
	  console.log($("table.accounts tr"));
           $(".accounts tbody tr","body").draggable({
            handle:'td.name',
            revert:'invalid',
            cursor:'move',
            appendTo:'body',
            opacity:0.7
           })

           $("div.panel-accounts-nofolder").droppable({
             activeClass: "ui-state-default",
                hoverClass: "ui-state-hover",
                accept:'tr.folderrow',
                drop:function(event,ui){
                    var idpage=$(ui.draggable).find('.deleteaccount').data('id');
                    var p=$(this)
                    var isuser=p.find('.deleteaccount').data('user')
                    $.ajax(
                        {
                            url:base_url+'panel/facebook/changeAccountFolder',
                            data:{page:idpage,folder:'null',isuser:isuser},
                            type:'post',
                            dataType:'json',
                            complete:function(data){
                                
                            document.location.href=current_url;    
                            }
                        }
                    );
                    ui.draggable.remove();
            
                }
           })
           
           $("div.panel-accounts-folder").droppable({
             activeClass: "ui-state-default",
                hoverClass: "ui-state-hover",
                drop:function(event,ui){
                    var p=$(this)
                  
                    var idfolder=$(this).find('.panel-collapse').data('idfolder')
                    var isuser=$(this).find('.deleteaccount').data('user');
                    var idpage=$(ui.draggable).find('.deleteaccount').data('id');
                    console.log(idfolder,idpage,isuser);
                    
                    $.ajax(
                        {
                            url:base_url+'panel/facebook/changeAccountFolder',
                            data:{page:idpage,folder:idfolder,isuser:isuser},
                            type:'post',
                            dataType:'json',
                            complete:function(data){
                                
                                      document.location.href=current_url;
                            }
                        }
                    );
                    ui.draggable.remove();

                }
           })
    