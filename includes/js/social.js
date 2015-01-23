

	$("body").on("click",".deleteaccount",function(e){
		e.preventDefault();
	var 	$this =$(this);
		$this.data("social")
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
								onClick:function()
								{
									$.ajax({url:deletecontent_url,
										async:false,
										data:{"is_folder":is_folder,"id":$this.data("id")},
										type:'get',
										dataType:"json",
										success:function(data){
											console.log(data);
											if(data.idFolder)
											notyfy({text:"Esta carpeta tiene contenido, que quiere hacer?",
												buttons:[{
													addClass:"btn btn-primary",
													text:"Ubicar el contenido fuera de la carpeta",
													onClick:function(){
													onClickNoty("quit",data.idFolder);
					//								document.location.href=current_url;			
													}
												}
												,
												{
													addClass:"btn btn-danger",
													text:"Eliminar el contenido",
													onClick:function(){
													onClickNoty("delete",data.idFolder);
					//								document.location.href=current_url;		
													}}]})	
											$this.parent().parent().remove()
											
										}
									})								
								}
							}
						]
				});
	
	

	})

	function onClickNoty(type,id)
	{
		$.ajax({
			url:base_url+"panel/facebook/deleteQuitFolderContent",
			data:{"type":type,"id":id},
			dataType:"json",
			type:"get",
			success:function(data){
				var res=showResults(data,',','.message');
/*				if(res!=false)
				{
					      $('body').delay(1500).queue(function( nxt ) {
//location.href=current_url;
                                nxt();
                            });  	
				}*/
			}
		});
	}
/*	$("body").on("click",".deletefbfolder",function(){
	var 	$this =$(this);
		if(confirm("Seguro que quiere eliminar la carpeta?"))
		$.ajax({url:deletecontent_url,
			data:{"id":$this.data("id")},
			type:'get',
			success:function(data){
				//var res=showResults(data,',','.message');
				/*if(res!=false)
				{
					      $('body').delay(1500).queue(function( nxt ) {
                                location.href=current_url;
                                nxt();
                            });  	
				}    
			}})/
				$this.parent().parent().remove()
			}

	})
})
*/