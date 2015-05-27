$(document).ready(function(){
	var $container = $('.masonry-container');
	$container.imagesLoaded( function () {
		$container.masonry({
			columnWidth: '.item',
			itemSelector: '.item'
		});
	});
	
	//Reinitialize masonry inside each panel after the relative tab link is clicked - 
	$('a[data-toggle=tab]').each(function () {
		var $this = $(this);
		$this.on('shown.bs.tab', function () {
		
			$container.imagesLoaded( function () {
				$container.masonry({
					columnWidth: '.item',
					itemSelector: '.item'
				});
			});

		}); //end shown
	});  //end each

	$("#single").on('click', function(){
		$.ajax({
			url:APP+"/single",
			type :'post',
			dataType:'json',
			data :{'_token':$('meta[name="_token"]').attr('content')},
			success:function(data){
				console.log(data);
				if(data.status == 'success'){
					var list = data.data;
					for(var one in list) {
						var str = '<div class="col-md-4 col-sm-6 item">';
						str += '<div class="thumbnail">';
						if(list[one]['img_thumb_path'] != ''){
	            			str += '<img src="'+PUBLIC+''+list[one]['img_thumb_path']+'" alt="">';
	            		}
	              		str += '<div class="caption"><h3>'+list[one]['title']+'</h3>';
	              		str += '<p>'+list[one]['content']+'</p>';
	                	str += '<p><a href="'+APP+'/goods/detail/'+list[one]['id']+'" class="btn btn-primary" role="button">查看详情</a> </p></div></div></div>';
						$("#panel-single-masonry").append(str);
					}
				}else if(data.status == 'failed'){
					
				}else if(data.status == 'error'){
					
				}else{
					
				}
			},beforeSend:function(){
				
			}
		});
	});

});
