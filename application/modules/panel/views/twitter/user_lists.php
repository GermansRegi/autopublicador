<!DOCTYPE html>
<head>

    <title>Socialsuites</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta charset="UTF-8" />
    <?php echo $this->load->view('includes2/head');?>




</head>

<body>
<?php $socialNamesAr=array('face'=>"Facebook","twt"=>"Twitter");$tradArray=array('sentence'=>"Texto",'image'=>'Imágenes','link'=>'Enlaces');
$arr=array("group","user","event","page")
?>
    <?php echo $this->load->view('includes2/header');

	?>
		<a class="btn btn-primary"  href="<?php echo base_url()?>panel/twitter/getLists/<?php echo $user_id ?>" data-toggle="ajaxModal"> <i  class="fa fa-plus"></i> Agregar listas  </a>
		<div class="savedlists clearfix">
			<?php foreach ($lists as $list) {

				?>
				<div data-id='<?php echo $list->list_id ?>' data-myid="<?php echo $list->id; ?>" class="savedlists__item">
					<div class="savedlists__item--header"> 
						<h1>
							 <?php echo $list->list_name. " <span class='atribution'> @".$list->username;?> </span>
								
					
						</h1>
						<a class="btn btn-default column-link-actions"><i class="fa fa-cog"></i></a>
							

					</div>
			
					<div class="savedlists__item--content clearfix">
						<div class="column-list-options hidden">
							<div class="btn-group btn-group-justified" role="group">
							<?php  if($list->is_subscriberlist==0){?>
								<div class="btn-group">
									<a class="btn btn-default" type="button" href="<?php echo base_url()?>panel/twitter/editlist/<?php echo $list->list_id?>" data-toggle="ajaxModal" role="group"><i class="fa fa-pencil"></i> Editar</a>
								</div>
								<?php }?>
								<div class="btn-group" role="group"><button type="button" class="btn btn-default clear-list-content"> <i class="glyphicon glyphicon-tint"></i> Limpiar</button>
								</div>
								<div class="btn-group" role="group"><button type="button" class="btn btn-default quit-list"><i class="fa fa-times"></i> Quitar</button></div>
								
							</div>
						</div>
						<div class="scrollable">

						</div>

						
					</div>
					
				</div>
				<?php	
			}
			?>
			
		</div>


	<script type="text/javascript">
	
	var current_url='<?php echo base_url().$this->uri->uri_string();?>';
</script>

<?php
    echo $this->load->view('includes2/footer');
?>
 <?php echo $this->load->view('includes2/scripts');?>
 <script id="entry-template" type="text/x-handlebars-template">
<article class="stream-item" data-id-tweet="{{id}}">

 <div class="js-stream-item-content item-box js-show-detail">   

 	<div class="js-tweet tweet">
 	
		<div class="tweet-header">
		
 			<time class="tweet-timestamp js-timestamp pull-right txt-mute" datetime="{{created_at}}" data-time="1430840833000">
 			
				<a class="txt-small" href="https://twitter.com/{{user.name}}/status/{{id}}" rel="url" target="_blank">{{time_past}}{{time_unit}}</a>  
				
			</time>    
			<a class="account-link link-complex block" href="https://twitter.com/{{user.screen_name}}" rel="user" target="_blank"> 
				
				<div class="obj-left item-img tweet-img">  
		
					<img class="tweet-avatar avatar pull-right" src="{{user.profile_image_url_https}}" alt="{{user.screen_name}}'s avatar" height="48" width="48"/> 
					
				</div> 
				
				<div class="nbfc "> 
						<span class="account-inline txt-ellipsis">
						<b class="fullname link-complex-target">{{user.name}}</b>   
						<span class="username txt-mute">{{user.screen_name}}</span>  
					</span> 
					
				</div> 
				
			</a>  
			
		</div> 
		<div class="tweet-body"> 
		
			<p class="js-tweet-text tweet-text with-linebreaks ">
					{{text}}
			</p>
			{{!--
			<div class="tweet-footer cf">  
				<ul class="js-tweet-actions tweet-actions "> 
					<li class="tweet-action-item"> 
						<a class="js-reply-action tweet-action position-rel" href="#" rel="reply"> <i class="icon icon-reply txt-right"></i> <span class="is-vishidden">Reply</span> <span class="reply-triangle"></span> 
						</a> 
					</li> 
					<li class="tweet-action-item"> 
						<a class="tweet-action" href="#" rel="retweet"> <i class="icon icon-retweet icon-retweet-toggle txt-right"></i> <span class="is-vishidden">Retweet</span> </a> 
					</li> 
					<li class="tweet-action-item"> 
						<a class="js-show-tip tweet-action" href="#" rel="favorite" title="  Favorite from eugeniregidev   "> <i class="icon icon-favorite icon-favorite-toggle txt-right"></i> <span class="is-vishidden">Favorite</span> </a> </li> 
					<li class="tweet-action-item position-rel"> 
						<a class="tweet-action" href="#" rel="actionsMenu" data-user-id="2357750269" data-chirp-id="595615743414263808" data-account-key="twitter:2954607795" data-actions-menu-position="" data-parent-chirp-id=""> <i class="icon icon-more txt-right"></i> <span class="is-vishidden">More options</span> </a> </li>  
					<li class="feature-customtimelines tweet-drag-handle tweet-action-item"> 
						<a class="tweet-action is-draggable" href="https://twitter.com/khalidrafiq122/status/595615743414263808" data-drag-type="tweet" data-tweet-id="595615743414263808"> <i class="icon icon-move txt-right txt-right"></i> <span class="is-vishidden">Drag to collection</span> </a> 
					</li> 
				</ul>      

				<a class="pull-left margin-txs txt-mute txt-small is-vishidden-narrow" href="#" rel="viewDetails">Details</a> 
				<a class="pull-left margin-txs txt-mute txt-small is-vishidden is-visshown-narrow" href="#" rel="viewDetails">Open</a>  
			</div>  
			--}}
		</div>
		
	</div>
	
</div> 

</article>
</script>
 <script id="entry-member-template" type="text/x-handlebars-template">
 	<li class="list-listmember cf" data-usersearchid="{{id}}"> 
 		<img src="{{profile_image_url_https}}" alt="@{{name}}" class="avatar"> 
 		{{#if ismember}}
 			<button class="js-add-remove btn btn-square s-checked"> 
 		{{else}}
 			<button class="js-add-remove btn btn-square s-nonmember"> 
 		{{/if}}
 			<div class="working action-btn"> 
 				<span> 
 					<img src="https://ton.twimg.com/tweetdeck-web/web/assets/global/backgrounds/spinner_small_trans.c401042ab9.gif" alt="Loading…"> </span> 
 			</div> 
 			<div class="member action-btn"><i class="fa fa-trash-o"></i></div> 
 			<div class="checked action-btn"><i class="fa fa-check icon-small"></i></div> 
 			<div class="nonmember action-btn"><i class="fa fa-plus icon-small"></i></div> 
 		</button> 
 		<div class="content"> 
 			<strong class="fullname">{{name}}</strong> 
 			<span class="username">{{screen_name}}</span>  
 			<p class="bio">{{description}}
 			</p> 
 		</div> 
 	</li>

 </script>
	<script type="text/javascript">
	$(document).on('ready',function()
	{
		// primera crida
		loadTweets()
	})
	function loadTweets () {
		// per cada llista k tinc a html faig 
		$('.savedlists').children().each(function(i,m){
			//agafo id d la llista
			var listid=$(m).data('id')	;
			//agafo elks tweets k es mostren  a html per poder saber a partir d quin id d tweet he d fer la crida a tweetero x no agafar tweets repètits
			// ho has entes? si, i agafes l'ultim id, aquest id es el twit mes nou o el mes vell?
			// agafo el primer twet  digues ok
			var Posts=$(m).find('.savedlists__item--content').find('article');
		//	console.log(Posts);
		

			if(Posts.length==0)
					lastPostid=1;
				else
					lastPostid=Posts.first().data('id-tweet');
				//aqui obtens els twits ultims
			$.ajax({url:base_url+'panel/twitter/getDataList',
				type:'get',
				chache:false,
				dataType:'json',
				data:{listid:listid,'since_id':lastPostid},
				success:function (data) {
					
					//vaig a la funcio
					render_list_tweets(data,listid);
				}})


			

		})
	}

setInterval(function(){
	//les seguents crides
	loadTweets();
		
	},60000);
	
	var source   = $("#entry-template").html();
	
	var template = Handlebars.compile(source);

	function render_list_tweets(data,listid)
	{
		//si l criida em retorna algun tweet o ja i han tweets a html
		//
		$("div[data-id='"+listid+"'] > div > div.scrollable > *:first").slideDown(20000);
		 if($("div[data-id='"+listid+"'] > div > div.scrollable").children().length==0 && data.length>0)
		 {
		 	console.log('te tweets1',data[0],listid,$("div[data-id='"+listid+"'] > div > div.scrollable").children().length);
		 	//ja se k pasa
		 	//peret
		 
		 	for(var i=data.length-1;i>=0;i--)
		 	{
		 	var html=render_tweet(data[i],listid);

		 		$(html).prependTo($("div[data-id='"+listid+"'] > div > div.scrollable"));
				
		 	}
		 	
		 }//sino  mostro text ,n ocrec  k l'eror es aqui, mira, en el cas de la llista on no hi ha twits nouski, aquesta llista ja la tenies ordenada a l'agafarla de l'html i aqui la ordenes de nou en ordre invers
		 //no on? 
		else if($("div[data-id='"+listid+"'] > div > div.scrollable").children().length==0 && data.length==0)
		{
			var dtable = document.createElement('div');
			$(dtable).css({'display':'table'})
			var d =document.createElement('div')
			//$("div[data-id='"+listid+"'] > div > div.scrollable").children().remove();
			$(d).css({'display':'table-cell','vertical-align':'middle'}).text('No hay Tweets recientes').appendTo("div[data-id='"+listid+"'] > div > div.scrollable")	
		}
		else if($("div[data-id='"+listid+"'] > div > div.scrollable").children().length>0 && data.length>0)
		{
			console.log('te tweets2',data[0],listid);
			
			for(var i=0;i<data.length;i++)
			{
				var html=render_tweet(data[i],listid);
				$(html).prependTo($("div[data-id='"+listid+"'] > div > div.scrollable > article:first"))

			}
		}
		console.log($("div[data-id='"+listid+"'] > div > div.scrollable > article:first"));
	
	}
	
		// //ara  quann trobi tweets els mostrara xo kuan 
	// el k hem de fer es:
	
	// hi ha algun twit a html? -> no -> fem la crida, torna algun twit? -> si akiaket->ordenem en ordre invers de com venen amb la crida
 //                                                                      -> no -> mostrem missatge de no hi ha twits		
 //                             -> si -> fem la crida, torna algun twit? -> si -> l'afegim a l inpici aki tambe pk el prepend afegeix el twit a inici , si pero aki no s'ha d crridar en tota la llista pk llavors torna a reordenar tota la llista, s'ha de fer prepend dels nous twits i un cop fer afegir la llista dels nous twits a dalt  exemple
 //                                                                     -> no   -> no fem res
 

	function render_tweet(item,listid)
	{
		
		<?php $fecha=new DateTime('now',new DatetimeZone($this->session->userdata('timezone')));
		?>
		
var now=new Date('<?php echo $fecha->format("D M d H:i:s O Y");?>');
	
		var then=item.created_at;
		
//la hora actual i la d la publicacio en format hh:mm:Ss
var ms = moment(now).diff(moment(then));
//aki  afegeixo una propietat al objecte json k es per mostrar el temps k fa k sa publicat el twit
ms=Math.abs(ms);
if(ms==0)
{
	item.time_past="now";
	item.time_unit="";
}
else{
	var s=ms/1000;

	if(s<60){
		item.time_unit="s";
			item.time_past=moment.duration(s,'seconds').format('s');
	}
	else
	{

		var m=s/60;
	
		if(m<60)
		{
			item.time_unit="m"; 
						item.time_past=moment.duration(m,'minutes').format('m');
		}	
		else
		{
			var h=m/60;
		
			if(h<24)
			{
				item.time_unit="h";
			
				item.time_past=moment.duration(h,'hours').format('h');

			}
			else
			{
				var d=h/24;
				if(d<365)
				{
					item.time_unit="d";
					item.time_past=moment.duration(d,'days').format('d');
				}
				else
				{
					var w=d/7;
					if(w<7)
					{
					item.time_unit="w";
					item.time_past=moment.duration(w,'weeks').format('w');
					}
					else{
						var mon=w/4;
						if(mon>4)
						{
							item.time_unit="m";
							item.time_past=moment.duration(mon,'months').format('M');
						}
						else
						{
							var y=mon/12;
							if(y>12){
								item.time_unit="y";
							item.time_past=moment.duration(y,'years').format('y');		
							}
						}
					}
				}

			}
		}
	}
}
//aki esta l'error, s0ha d cridar nomes uan es pinti la llista en el primer cas
 
///n enenyam el codi
			//item.time_past=moment.duration(d,'hours').format('h:mm');
var html    = template(item);

return html;	

//	$("div[data-id='"+listid+"'] > div > div.scrollable article:first").prepend(html);

	}
// aok peret k poso mes temps entre crida i crida	tu fas el prepend als elements que tornen de la crida pero els elements k no s'actualizen pk son de la crida anterior tb? 
</script>


</body>
</html>
	