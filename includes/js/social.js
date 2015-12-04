	    //Contador de caracteres
	    
if($('#tweet_txt').length>0)
{
    
    function init_contadorTa(idtextarea, idcontador,max)
    {
        $('body').on('keyup',"#"+idtextarea,function()
        {
            updateContadorTa(idtextarea, idcontador,max);
        });
        $('body').on('change',"#"+idtextarea,function()

        {
            updateContadorTa(idtextarea, idcontador,max);
        });
        $('body').on('input',"input[name='link']",function()
        {
        	updateContadorlink($(this),idtextarea,idcontador,max)
        });
    }
    function updateContadorlink(idlink,idtextarea,idcontador,max)
    {
    	    var contador = $("#"+idcontador);
	        var ta =     $("#"+idtextarea);
	        console.log('pp');
        contador.html("0/"+max+' car&aacute;cteres disponibles');
        contador.html((ta.val().length+idlink.val().length+6)+"/"+max +' car&aacute;cteres disponibles');
    if(parseInt(ta.val().length+idlink.val().length+6)>max)
        {
            ta.val(ta.val().substring(0,max-1));
            contador.html(max+"/"+max+' car&aacute;cteres disponibles');
        }
    }
    function updateContadorTa(idtextarea, idcontador,max)
    {
        var contador = $("#"+idcontador);
        var ta =     $("#"+idtextarea);
        contador.html("0/"+max+' car&aacute;cteres disponibles');
        contador.html(ta.val().length+"/"+max +' car&aacute;cteres disponibles');
        if(parseInt(ta.val().length)>max)
        {
            ta.val(ta.val().substring(0,max-1));
            contador.html(max+"/"+max+' car&aacute;cteres disponibles');
        }
    }
    init_contadorTa("tweet_txt","contadorTaComentario", 140);
}

	// serveix per eliminar una carpeta de programacions puntuals i una carpeta de programacions periodiques
	$('body').on('click','.deleteprogfolder',function  (e) {
			e.preventDefault()
			$this=$(this)
			var isAutoProg=($this.hasClass('autoprog'))
			var progFolderId=$this.data('id')
			var np=noty({	text:"Seguro que quiere eliminar la carpeta de programaciones?",

					buttons:
						[	
							{
								addClass:"btn btn-primary",
								text:"Cancelar",
								onClick:function(notyfy){
									notyfy.close()
								}
							},
							{
								text:"Acceptar",
								addClass:"btn btn-danger",
								onClick:function(notyfy)
								{
									notyfy.close();
									$.ajax({
										type:'post',
										url:base_url+'panel/commonsocial/deleteFolderProg',
										data:{'askHaveProg':true,'idFolder':progFolderId,isAutoProg:isAutoProg},
										dataType:'json',
										success:function(data){
											var res=showResults(data,',','.message');
											console.log('pasa',res);
											if(res){
												$('body').delay(1000).queue(function( nxt ) {
													document.location.href=current_url;
													nxt();
										                      }); 	
											}else{console.log('pasa');
											 $("html, body").animate({ scrollTop: 0 }, "slow");}
										}
									});
								}
						
								}
				]})

	})
	// event per eliminar contes i carpetes de xarxes socials
	$("body").on("click",".deleteaccount",function(e){
		e.preventDefault();
	var 	$this =$(this);
		$this.data("social")
		var isUser=Boolean($this.data("user"));
		var is_folder=Boolean($this.data("type"));
	
		var np=noty(
				{
					text:"Seguro que quiere eliminar la "+((is_folder===true)?"carpeta":"cuenta")+"?",

					buttons:
						[	
							{
								addClass:"btn btn-primary",
								text:"Cancelar",
								onClick:function(notyfy){
									notyfy.close()
								}
							},
							{
								text:"Acceptar",
								addClass:"btn btn-danger",
								onClick:function(notyfyparent)
								{
									$.ajax({url:deletecontent_url,
										async:false,
										data:{"is_folder":is_folder,"id":$this.data("id"),"is_user":isUser,'askHaveProg':1},
										type:'get',
										dataType:"json",
										success:function(data){
																				
											if(data.idFolder){
												var n=noty({

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
											else if(data.haveProg)
											{
													NotyHaveProgAccount($this.data("id"),isUser);
											
												
											
												
												//document.location.href=current_url;									
											}
											else
											{
													var res=showResults(data,',',null);
													if(res){
														$('body').delay(1000).queue(function( nxt ) {
															document.location.href=current_url;
															nxt();
									                      }); 	
													}						
											}
											
											notyfyparent.close()			
										}
									})									
								}
							}
						]
				});
	
	

	})
	//serveix per eliminar una programacio periodica
$("body").on("click",".deleteautoprog",function(){
	var $this=$(this);
	var prog=$this.data("prog-id")
	var account=$this.data("account-id");
	var type=$this.data("type-prog");
	if(confirm("Seguro que quiere eliminar la programación periódica?"))
	{
		$.ajax({
			type:'post',
			dataType:"json",
			url:base_url+"panel/commonsocial/deleteAutoProg",
			data:{prog:prog,type:type,account:account},
			success:function(data){
				
								$('body').delay(1000).queue(function( nxt ) {
									document.location.href=current_url;
									nxt();
			                      }); 	
							

			}

		})
	}
})
	function NotyHaveProgAccount(id,isUser)
	{
		var npp=noty({

						text:'Si elimina esta cuenta se eliminaran las programaciones pendientes en ella, desea coninuar?',
						buttons:[{
							addClass:"btn btn-primary",
							text:"Si",
							onClick:function(notyfy){
							notyfy.close()
							onClicHaveProgAccount(id,isUser);
							
							
							
							}
						}
						,
						{
							addClass:"btn btn-danger",
							text:"No",
							onClick:function(notyfy){
							notyfy.close()		
							
							
							
							}
						}]
									})	
			
	}
	function onClicHaveProgAccount(id,isUser)
	{
		$.ajax({url:deletecontent_url,
				async:false,
				data:{"is_folder":false,"id":id,"is_user":isUser},
				type:'get',
				dataType:"json",
				success:function(data){
					var res=showResults(data,',',null);
					if(res){
						$('body').delay(1000).queue(function( nxt ) {
							document.location.href=current_url;
							nxt();
	                      }); 	
					}						
			
			}})
	}
	function onClickNoty(type,id,isUser)
	{
		$.ajax({
			url:base_url+"panel/commonsocial/deleteQuitFolderContent",
			data:{"type":type,"id":id,"is_user":isUser,'askHaveProg':1},
			dataType:"json",
			type:"get",
			success:function(data){
				if(data.haveProg && type=="delete")
				{
					var npp=noty({

						text:'Si elimina esta carpeta se eliminaran las programaciones pendientes en las cuentas que contiene, desea coninuar?',
						buttons:[{
							addClass:"btn btn-primary",
							text:"Si",
							onClick:function(notyfy){
							notyfy.close()
							OnclickHaveProgInFolder(type,id,isUser);
							
							
							
							}
						}
						,
						{
							addClass:"btn btn-danger",
							text:"No",
							onClick:function(notyfy){
							notyfy.close()		
							
							
							
							}
						}]
									})	
							
				}
				else
				{
						var res=showResults(data,',',null);
						if(res){
							$('body').delay(1000).queue(function( nxt ) {
								document.location.href=current_url;
								nxt();
		                      }); 	
						}
				}					
			}
		});
	}
	function OnclickHaveProgInFolder(type,id,isUser)
	{
		$.ajax({
			url:base_url+"panel/commonsocial/deleteQuitFolderContent",
			data:{"type":type,"id":id,"is_user":isUser},
			dataType:"json",
			type:"get",
			success:function(data){
				
						var res=showResults(data,',',null);
						if(res){
							$('body').delay(1000).queue(function( nxt ) {
								document.location.href=current_url;
								nxt();
		                      }); 	
						}
			}
		});
	}
	// event per mostrar i amagar el formulari 
	$("body").on("click",".showHide",function(){
		
	
		if($(this).parent().parent().find('.divCreateFolder').is(":hidden"))
			$(this).parent().parent().find('.divCreateFolder').removeClass("hidden");

		else
			$(this).parent().parent().find('.divCreateFolder').addClass("hidden");
	})
	$("body").on("click",".showHideAddGroup",function(){
		
	
		if($(this).parent().parent().find('.divAddGroup').is(":hidden"))
			$(this).parent().parent().find('.divAddGroup').removeClass("hidden");

		else
			$(this).parent().parent().find('.divAddGroup').addClass("hidden");
	})
	// event per crear carpetes per a contenir cuentas
	$("body").on("submit","#createFolder",function(e){
		e.preventDefault();
	
		$.ajax(
			{
				url:createfolder_url,
				data:
					$(this).serialize()
					,
				type:"post",
				dataType:"json",
				success:function(data){
					var res=showResults(data,',','.message');
					if(res){
							$('body').delay(1000).queue(function( nxt ) {
								document.location.href=current_url;
								nxt();
		                      }); 	
						}
				},

			});	
		return false;
	});
	$("body").on("submit","#createFolderProg",function(e){
		e.preventDefault();
		var url=$(this).attr('action')
		var $this=$(this);
		console.log(url);
		$.ajax(
			{
				url:url,
				data:
					$this.serialize()
					,
				type:"post",
				dataType:"json",
				success:function(data){
					var res=showResults(data,',','.messagemodal');
					if(res){
							$('body').delay(1000).queue(function( nxt ) {
								document.location.href=current_url;
								nxt();
		                      }); 	
						}
				},

			});	
		return false;
	});

	$("body").on("submit","#addGroup",function(e){
		e.preventDefault();
	
		$.ajax(
			{
				url:addgroup_url,
				data:
					$(this).serialize()
					,
				type:"post",
				dataType:"json",
				success:function(data){
					var res=showResults(data,',','.message2');
					if(res){
							$('body').delay(1000).queue(function( nxt ) {
								document.location.href=current_url;
								nxt();
		                      }); 	
						}
				},

			});	
		return false;
	});
	
	$(document).on('click','.nav-tabs a',function(e){
		e.preventDefault();
	    $(this).tab("show");
	});
	// events per obrir tabs en cuentas  d facebook
	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		console.log($(e.target).attr("href"));
		var target = $(e.target).attr("href") // activated currTab
		$.cookie("currTab",target);
	});
	$(document).ready(function(){
		console.log($.cookie("currTab"));
		$(".nav-tabs a[href="+$.cookie("currTab")+"]").tab("show")
	})
	// events per generar elements d base d dades al publicar o programmar
	$("BODY").on("change",".generate-select",function(){
		$this=$(this);
		var typeselect=$this.data('typeselect');
		var id=$this.val();           
		$.ajax({
			url:base_url+"panel/commonsocial/get_"+typeselect+"Elements",
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

	function isUrl(s) {
   var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
   return regexp.test(s);
}
//generar elements de base d daddes per publicar i prohgramar
	function generate(container,data)
	{
		var container_sub=container.substr(9,container.length);

		$("#"+container).html('');

	//	console.log($("#"+container));

		if(data.data && data.data.length==0){
			$("<p>Debe añadir contenido a la base de datos seleccionada.</p>").appendTo("#"+container)
		}
		else 
		{
			for(i=0;i<data.data.length;i++)
			{
				$('<input  class="chb" type="checkbox" name="'+container_sub+'_'+data.content+'" value="'+data.data[i].id+'"/>').appendTo($("#"+container))
				if(data.content=="sentence"){	
					$('<span>'+data.data[i].sentence+'</span><br>').appendTo($("#"+container))}
				else if(data.content=="image")
				{
					if(isUrl(data.data[i].path))
						$('<img width="60" height="60" class="image-link" src="'+data.data[i].path+'"/>').appendTo($("#"+container))
					else
						$('<img width="60" height="60" class="image-link" src="'+base_url+'upload/'+((data.folder)?data.folder+'/':'/')+data.data[i].filename+'"/>').appendTo($("#"+container))
				}
				else
					$('<span><a href="'+data.data[i].link+'">'+data.data[i].text+'</a></span><br>').appendTo($("#"+container))

			}	
			
			$("#"+container).on('click',"input[name='"+container_sub+"_"+data.content+"']",function() {
					
					  var  $uniqe=$(this).siblings('input')
					//var $unique=$("input[name='bbdd_img'],input[name='bbdd_sentence']",'#content-user');s
					    $uniqe.removeAttr('checked');
					    $(this).attr('checked', true);
					});
			if(data.pager!='')
			{
				$(data.pager).appendTo($("#"+container))

			}
		}	

	}
	// serveix per eliminar una programacio puntual
	$('body').on('click','.deleteprog',function()
	{
		if(confirm("Seguro que quiere eliminar la programación?"))
	{
	
		$this=$(this);
		$this.data('id');
          $.ajax(
              {
                  url:base_url+'panel/commonsocial/delete_programation',
                  data:{id:$this.data('id')},
                  type:'get',
                  dataType:'json',
                  success:function(data){
                      
             		  	var res=showResults(data,',','.message');
					if(res){
							$('body').delay(1000).queue(function( nxt ) {
								document.location.href=current_url;
								nxt();
		                      }); 	
						}
                  }
              }
          );
    	}      

	})
	$('body').on('submit',"#periodicasmultiple",function(e){
		  var my_button = $(this).find("input[type='submit']");
		  console.log(my_button);
		  my_button.button('loading');
		e.preventDefault();
			var $btn=$(this).find('input[type=submit]');
		 var formdata =new FormData($(this)[0]);
		 var url=$(this).attr('action');
		 makeajax({
		 	url:url,
		 	dataType:'json',
		 	type:'post',
		 	data:formdata,
		 	
			success:function(data)
			{
				my_button.button('reset');
				var res=showResults(data,',','.message');
				if(res){
						$('body').delay(2000).queue(function( nxt ) {
								document.location.href=current_url;
							nxt();
	                      }); 	
					}
			}
		 },$btn)
	})

	$('body').on('submit',"#periodicas",function(e){
		e.preventDefault();
			var $btn=$(this).find('input[type=submit]');
		 var formdata =new FormData($(this)[0]);
		 var url=$(this).attr('action');
		 makeajax({
		 	url:url,
		 	dataType:'json',
		 	type:'post',
		 	data:formdata,
		 	success:function(data)
			{
				
				var res=showResults(data,',','.messagemodal');
				console.log(res);
				if(res){
						$('body').delay(2000).queue(function( nxt ) {
							$("#ajaxModal").modal('hide');
								nxt();
	                      }); 	
					}
			}
		 },$btn)
	})

	$('body').on('submit',"#programar",function(e){
		e.preventDefault();
		var $btn=$(this).find('input[type=submit]');
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
							document.location.href=current_url;
							nxt();
	                      }); 	
					}
						/*$('#generate-bbdd').html('');
						$("#generate-anuncis").html('');
						$(".generate-select").val('');	*/
					
			}
		 },$btn)
	})
	$.fn.state = function(state) {
  var d = 'disabled'
  return this.each(function () {
    var $this = $(this);
    console.log($this[0].className,state);
    $this[0].className = $this[0].className.replace(/\bstate-.*?\b/g, '');
    console.log($this[0].className,state);
    $this.html( $this.data(state) )
    state == 'loading' ? $this.addClass(d+' state-'+state).attr(d,d) : $this.removeClass(d).removeAttr(d).removeClass(state)
  })
}

	function makeajax(obj,btn)
	{
		objajax= $.extend({		 	
			async:false,
		 	processData:false,
			async:false,
			cache:false,
			contentType:false,
			beforeSend:function(e){
				$("body *").css("cursor","wait");
		console.log("comple2te");
		btn.state('loading')
		console.log(btn);
		//$("#container").addClass('waitcursor');
					},
			complete:function(e){
				//l.stop()
		///		$('#container').removeClass('waitcursor');
				console.log("complete");
				btn.state('active');
				console.log(btn);
				$("body *").css("cursor","");
			}},obj)
		$.ajax(objajax);
	}
	 /*$('input[data-loading-text]')
    .on('click', function () {
        var btn = $(this)
        
        setTimeout(function () {
            btn.button('reset')
        }, 5000)
    });*/
	$('body').on('submit',"#publicarahora",function(e){
		var $btn=$(this).find('input[data-loading]');
		e.preventDefault();
		 var formdata =new FormData($(this)[0]);
		

		 var url=$(this).attr('action');
		 makeajax({
		 	url:url,
		 	dataType:'json',
		 	type:'post',
		 	data:formdata,

			success:function(data)
			{
				if(data.errors)
				{	
					var str='<div class="errors"><a class=" btn btn-primary" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Mostrar los errores </a><div class="collapse" id="collapseExample"><div class="well">';
				
					str+='<ul class="list-group"><li class="list-group-item row"><span class="col-lg-4"><strong>Usuario, grupo, página o evento</strong></span><span class="col-lg-8"><strong>Error</strong></span></li>';
					for (p in data.errors['user'])
					{
						str+="<li class='list-group-item row'><span class='col-lg-4'>"+data.errors['user'][p]['name']+"</span> <span class='col-lg-8'>"+data.errors['user'][p]['error']['error']+"</span></li>";
					}

					for (p in data.errors['account'])
					{
						
						str+="<li class='list-group-item'><span class='col-lg-4'>"+data.errors['account'][p]['name']+" </span> <span class='col-lg-8'>"+data.errors['account'][p]['error']['error']+"</span></li>";
						
					}
					str+="</ul></div></div></div>";
					console.log(str);
					$('.message').find('.errors').remove();
					$('.message').append(str);
				}
				var res=showResults(data,',','.message')

				if(res){
						$('body').delay(2000).queue(function( nxt ) {
						///	document.location.href=current_url;
							nxt();
	                      }); 	
					}
					
					
				/*		$('#generate-bbdd').html('');
						$("#generate-anuncis").html('');
						$(".generate-select").val('');
				*/	
			}
			
		 },$btn)
		 
	})
	
	  
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
                    var isuser=$(ui.draggable).find('.deleteaccount').data('user')
                    $.ajax(
                        {
                            url:base_url+'panel/commonsocial/changeAccountFolder',
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
                    var isuser=$(ui.draggable).find('.deleteaccount').data('user');
                    var idpage=$(ui.draggable).find('.deleteaccount').data('id');
                 
                    
                    $.ajax(
                        {
                            url:base_url+'panel/commonsocial/changeAccountFolder',
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
		// faig dreggable els trde la taula 
        $(".programaciones tbody tr","body").draggable({
            handle:'td.name',
            revert:'invalid',
            cursor:'move',
            appendTo:'body',
            opacity:0.7
           })
        	//FAIG DRoppable el contenidor per a programacions sense carpetes 
        	//treu la programacio k sigui de la carpeta en k esta / posa anull el camp folder_id de la programacio
        	//
        	//
        	$("div.panel-prog-nofolder").droppable({
             activeClass: "ui-state-default",
                hoverClass: "ui-state-hover",
                accept:'tr.folderrow',
                drop:function(event,ui){
                	//agafo id de la programacio
                	//
                	var isAutoProg=null
                	var type=null
                	 isAutoProg=($(ui.draggable).find('.deleteautoprog').length>0);

                	if(isAutoProg)
                	{
                		var idprog=$(ui.draggable).find('.deleteautoprog').data('prog-id')
                		 type=$(ui.draggable).find('.deleteautoprog').data('type-prog');

                	}
                	else
                	{
						var idprog=$(ui.draggable).find('.deleteprog').data('id');
                	}

                    //faig peticio a servidor per posar a null en camp id_folder de la programacio 
                    $.ajax(
                        {
                            url:base_url+'panel/commonsocial/changeProgFolder',
                            data:{prog:idprog,folder:'null',isAutoProg:isAutoProg,type:type},
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
        	//faig droppable els contenidors per a programacions amb carpetes
        	$("div.panel-prog-folder").droppable({
             activeClass: "ui-state-default",
                hoverClass: "ui-state-hover",
                drop:function(event,ui){
                    var p=$(this)
                    var isAutoProg=null
                	var type=null
                	 isAutoProg=($(ui.draggable).find('.deleteautoprog').length>0);

                	if(isAutoProg)
                	{
                		var idprog=$(ui.draggable).find('.deleteautoprog').data('prog-id')
                		 type=$(ui.draggable).find('.deleteautoprog').data('type-prog');

                	}
                	else
                	{

						var idprog=$(ui.draggable).find('.deleteprog').data('id');
                	}

                  //agafo id de la carpeta en que he deixat la programacio
					var idfolder=$(this).find('.panel-collapse').data('idfolder')
                   
                    
                 
                    // faig peticio al servidor per fer efectiu el canvi
                    $.ajax(
                        {
                            url:base_url+'panel/commonsocial/changeProgFolder',
                           data:{'prog':idprog,
                    				'folder':idfolder,
                    				'isAutoProg':isAutoProg,
                    				'type':type},
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

   