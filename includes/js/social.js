
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


	// event per eliminar contes i carpetes de xarxes socials
	$("body").on("click",".deleteaccount",function(e){
		e.preventDefault();
	var 	$this =$(this);
		$this.data("social")
		var isUser=Boolean($this.data("user"));
		var is_folder=Boolean($this.data("type"));
	
		var n=noty(
				{
					text:"Seguro que quiere eliminar la "+((is_folder===true)?"carpeta":"cuenta")+"?",

					buttons:
						[	
							{
								addClass:"btn btn-primary",
								text:"Cancelar",
								onClick:function(notyfy){
									notyfy.closeAll()
								}
							},
							{
								text:"Acceptar",
								addClass:"btn-danger",
								onClick:function(notyfyparent)
								{
									$.ajax({url:deletecontent_url,
										async:false,
										data:{"is_folder":is_folder,"id":$this.data("id"),"is_user":isUser},
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
														notyfy.closeAll()
														onClickNoty("quit",data.idFolder,isUser);
														
														
														
														}
													}
													,
													{
														addClass:"btn btn-danger",
														text:"Eliminar el contenido",
														onClick:function(notyfy){
														notyfy.closeAll()		
														onClickNoty("delete",data.idFolder,isUser);
														//document.location.href=current_url;
														
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
											
												
												//document.location.href=current_url;									
											}
											
											notyfyparent.closeAll()			
										}
									})									
								}
							}
						]
				});
	
	

	})
	//
$("body").on("click",".deleteautoprog",function(){
	var $this=$(this);
	var prog=$this.data("prog-id")
	var account=$this.data("account-id");
	var type=$this.data("type-prog");
	if(confirm("Seguro que quiere eliminar a autoprogramación?"))
	{
		$.ajax({
			type:'post',
			dataType:"json",
			url:base_url+"panel/commonsocial/deleteAutoProg",
			data:{prog:prog,type:type,account:account},
			success:function(data){
				var res=showResults(data,',','.message');
						if(res){
								$('body').delay(1000).queue(function( nxt ) {
									document.location.href=current_url;
									nxt();
			                      }); 	
							}

			}

		})
	}
})
	function onClickNoty(type,id,isUser)
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
	$(document).on('click','.nav-tabs a',function(e){
		e.preventDefault();
	    $(this).tab("show");
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
					$('<span>'+data.data[i].sentence+'</span>').appendTo($("#"+container))}
				else if(data.content=="image")
					$('<img width="60" height="60" src="'+base_url+'upload/'+((data.folder)?data.folder+'/':'/')+data.data[i].filename+'"/>').appendTo($("#"+container))
				else
					$('<span><a href="'+data.data[i].link+'">'+data.data[i].text+'</a></span>').appendTo($("#"+container))

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

	$('body').on('click','.deleteprog',function()
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
          
	})
	$('body').on('submit',"#periodicasmultiple",function(e){
		e.preventDefault();
			var $btn=$(this).find('input:submit');
		 var formdata =new FormData($(this)[0]);
		 var url=$(this).attr('action');
		 makeajax({
		 	url:url,
		 	dataType:'json',
		 	type:'post',
		 	data:formdata,
		 	
			success:function(data)
			{
				$btn.button('reset');
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
			var $btn=$(this).find('input:submit');
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
		var $btn=$(this).find('input:submit');
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
						$('#generate-bbdd').html('');
						$("#generate-anuncis").html('');
						$(".generate-select").val('');	
					
			}
		 },$btn)
	})
	
	function makeajax(obj,l)
	{
		objajax= $.extend({		 	
			async:false,
		 	processData:false,
			async:false,
			cache:false,
			contentType:false,
			beforeSend:function(e){
		///		l.start()
			},
			complete:function(e){
				//l.stop()
			}},obj)
		$.ajax(objajax);
	}
	$('body').on('submit',"#publicarahora",function(e){
		var $btn=$(this).find('input:submit');
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
				$btn.button('reset');
				var res=showResults(data,',','.message');
				if(res){
						$('body').delay(2000).queue(function( nxt ) {
						///	document.location.href=current_url;
							nxt();
	                      }); 	
					}
					
					
						$('#generate-bbdd').html('');
						$("#generate-anuncis").html('');
						$(".generate-select").val('');
					
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
    