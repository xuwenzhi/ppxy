var page = 1;
var temp_page = 1;
var needle = new Array();
var time = Date.parse(new Date());
var canLoad = true;
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

	//滚动
	$(window).scroll(function(){
	    // 当滚动到最底部以上100像素时， 加载新内容
	    var scrollTop = $(this).scrollTop();
        var scrollHeight = $(document).height();
        var windowHeight = $(this).height();
	    var minus_tmp = $(document).height() - $(this).scrollTop() - $(this).height();
	    console.log(minus_tmp);
	    if (minus_tmp < 200 ) {
	       	var $type = $("#big_type").attr("data-type");
	       	var $page = parseInt($("#page").attr("data-type"));
	       	if(canLoad && Date.parse(new Date()) - time > 500){
	       		load_more_goods($type, $page);
	       		time = Date.parse(new Date());
	       	}
	    }
	});
});
function load_more_goods($type, $page){
	$("div[id='load']").show(10);
	$.ajax({
		url:APP+"/loadmore",
		type :'post',
		dataType:'json',
		async : false,
		data :{'type':$type, 'page':$page,'_token':$('meta[name="_token"]').attr('content')},
		success:function(data){
			if(data.status == 'success'){
				var list = data.data;
				if(list.length != 0 && !in_array($page,needle)) {
					var $boxes = '';
					for(var one in list) {
						$boxes += '<a href="'+APP+'/goods/detail/'+list[one]['id']+'" class="goods_block_a"><div class="col-md-3 col-xs-12 item"><div class="thumbnail" id="goods_block">';
						if(list[one]['img_thumb_path'] != ''){
		            		$boxes += '<img src="'+PUBLIC+''+list[one]['img_thumb_path']+'" class="img-responsive img-rounded" width="100%" alt="">';
						}
						$boxes += '<div class="caption"><h3>'+list[one]['title']+'</h3>';
						$boxes += '<ul class="list-group">';
	                    $boxes += '<li class="list-group-item"><span class="glyphicon glyphicon-tag" aria-hidden="true"></span>&nbsp;<span class="label label-danger">¥'+list[one]['price']+'</span>&nbsp;<span class="label label-danger">'+list[one]['type_name']+'</span>&nbsp;<span class="label label-danger">'+list[one]['new_level']+'</span></li>';
	                    $boxes += '<li class="list-group-item"><span class="glyphicon glyphicon-time" aria-hidden="true"></span>&nbsp;'+list[one]['trans_time']+'</li>';
	                    $boxes += '<li class="list-group-item"><span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span>&nbsp;'+list[one]['school_name']+'&nbsp;'+list[one]['deal_place_ext']+'</li></ul>';
	                    $boxes += '<p><button class="btn btn-primary" onclick="window.location.href='+APP+'/goods/detail/'+list[one]['id']+'">查看详情</button> </p></div></div></div></a>';
					}
					var el = jQuery($boxes);
	            	jQuery(".masonry-container").append(el).masonry( 'appended', el, true );
	            	needle.push($page, $page);
	            	$("#page").attr("data-type", $page+1);
	            	var t = $(window).scrollTop();
					$('body').animate({'scrollTop':t+200},700);
				}else{
					canLoad = false;
					$("#load_res_txt").show();
					var t = $(window).scrollTop();
					$('body').animate({'scrollTop':t+200},700);
				}
				$("div[id='load']").hide();
			} else if(data.status == 'error'){
				alert('数据加载失败,请重试！');
				return false;
			}
		}
	});
}
function in_array(search,array){
    for(var i in array){
        if(array[i]==search){
            return true;
        }
    }
    return false;
}
