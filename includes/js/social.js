(function(){
	$("body").on("click",".delete",function(){
	var 	$this =$(this);
		$this.data("social")
		var is_folder=(boolean)$this.data("type");
		console.log(is_folder);
		if(confirm("Seguro que quiere eliminar la cuenta?"))
		$.ajax({url:deletecontent_url,
			data:{"id":,$this.data("id")},
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
			}})*/
				$this.parent().parent().remove()
			}

	})
})
	$("body").on("click",".deletefbfolder",function(){
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
			}})*/
				$this.parent().parent().remove()
			}

	})
})

}())