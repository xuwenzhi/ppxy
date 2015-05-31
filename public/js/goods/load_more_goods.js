$(document).ready(function(){
	var $container = $('.masonry-container');
	$container.imagesLoaded( function () {
		$container.masonry({
			columnWidth: '.item',
			itemSelector: '.item',
			gutterWidth : 2,
			isAnimated: true
		});
	});
	var page = 1;
	//滚动
	$(window).scroll(function(){
	    // 当滚动到最底部以上100像素时， 加载新内容
	    if ($(document).height() - $(this).scrollTop() - $(this).height()<100) {
	       	var $type = $("#big_type").attr("data-type");
	       	var $page = parseInt($("#page").attr("data-type"));
	       	load_more_goods($type, $page);
	    }
	});
});
function load_more_goods($type, $page){
	$.ajax({
		url:APP+"/loadmore",
		type :'post',
		dataType:'json',
		data :{'type':$type, 'page':$page,'_token':$('meta[name="_token"]').attr('content')},
		success:function(data){
			if(data.status == 'success'){
				var list = data.data;
				if(list.length != 0) {
					for(var one in list) {
						var $boxes = '<div class="col-md-3 col-xs-12 item"><div class="thumbnail" id="goods_block">';
						if(list[one]['img_thumb_path'] != ''){
		            		$boxes += '<img src="'+PUBLIC+''+list[one]['img_thumb_path']+'" width="100%" alt="">';
						}
						$boxes += '<div class="caption"><h3>'+list[one]['title']+'</h3>';
						$boxes += '<ul class="list-group">';
	                    $boxes += '<li class="list-group-item"><span class="label label-danger">'+list[one]['price']+'</span>&nbsp;&nbsp;<span class="label label-danger">'+list[one]['type_name']+'</span></li>';
	                    $boxes += '<li class="list-group-item">'+list[one]['trans_time']+'</li>';
	                    $boxes += '<li class="list-group-item">'+list[one]['school_name']+'</li></ul>';
		                $boxes += '<p><a href="'+APP+'/goods/detail/'+list[one]['id']+'" class="btn btn-primary" role="button">查看详情</a> </p></div></div></div>';
						//$(".masonry-container").append($boxes).masonry('appended', $boxes, true);
						var el = jQuery($boxes);
	            		jQuery(".masonry-container").append(el).masonry( 'appended', el, true );
					}
				}
				$("#page").attr("data-type", $page+1);
			} else if(data.status == 'error'){
				alert('数据加载失败,请重试！');
				return false;
			}
		}
	});
}
