var page = 1;
var temp_page = 1;
var needle = new Array();
var time = Date.parse(new Date());
var canLoad = true;
$(document).ready(function(){
	var $container = $('.masonry-container');
	$container.imagesLoaded( function () {
		$container.masonry({
			itemSelector: '.item',
			columnWidth: 4,
            isAnimated:true,
            animationOptions: {
                duration: 800,
                easing:'linear',
                queue :false
           }
		});
	});

	//滚动
	$(window).scroll(function(){
	    // 当滚动到最底部以上100像素时， 加载新内容
	    var scrollTop = $(this).scrollTop();
        var scrollHeight = $(document).height();
        var windowHeight = $(this).height();
        var minus_tmp = $(document).height() - $(this).scrollTop() - $(this).height();
	    if (minus_tmp < 100 ) {
	       	var $page = parseInt($("#page").attr("data-type"));
	       	if(canLoad && Date.parse(new Date()) - time > 1000){
	       		load_more_goods($page);
	       		time = Date.parse(new Date());
	       	}
	    }
	});

});
function load_more_goods($page){
	$("div[id='load']").show(10);
	$.ajax({
		url:APP+"/goods/ajaxmine",
		type :'post',
		dataType:'json',
		async : false,
		data :{'page':$page,'_token':$('meta[name="_token"]').attr('content')},
		success:function(data){
			if(data.status == 'success'){
				var list = data.data;
				if(list.length != 0 && !in_array($page,needle)) {
					var $boxes = '';
					for(var one in list) {
						$boxes = '';
						$boxes += '<div class="col-md-3 col-xs-12 item"><div class="thumbnail" id="goods_block">';
						if(list[one]['img_thumb_path'] != ''){
		            		$boxes += '<img src="'+PUBLIC+''+list[one]['img_thumb_path']+'" class="img-responsive img-rounded" width="100%" alt="">';
						}
						$boxes += '<div class="caption"><h3>'+list[one]['title']+'</h3>';
						$boxes += '<ul class="list-group">';
						$boxes += '<li class="list-group-item"><span class="glyphicon glyphicon-flag" aria-hidden="true"></span>&nbsp;';
						if(list[one]['status'] == 'sell'){
							$boxes += '<span class="label label-success">'+list[one]['status_txt']+'</span>';
						}else{
							$boxes += '<span class="label label-warning">'+list[one]['status_txt']+'</span>';
						}
						$boxes += '</li>';
	                    $boxes += '<li class="list-group-item"><span class="glyphicon glyphicon-tag" aria-hidden="true"></span>&nbsp;<span class="label label-danger">¥'+list[one]['price']+'</span>&nbsp;<span class="label label-danger">'+list[one]['type_name']+'</span>&nbsp;<span class="label label-danger">'+list[one]['new_level']+'</span></li>';
	                    $boxes += '<li class="list-group-item"><span class="glyphicon glyphicon-time" aria-hidden="true"></span>&nbsp;'+list[one]['trans_time']+'</li>';
	                    $boxes += '<li class="list-group-item"><span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span>&nbsp;'+list[one]['school_name']+'&nbsp;'+list[one]['deal_place_ext']+'</li></ul>';
	                    $boxes += '<p><button class="btn btn-primary" onclick="window.location.href='+APP+'/goods/modify/'+list[one]['id']+'">修改信息</button> ';
	                    if(list[one]['status'] == 'sell'){
	                    	$boxes += '<button class="btn btn-default"  onclick="startChangeStatus(this)" date-enId="'+list[one]['id']+'" data-value="hide">改为不出售</button>';
	                    }else if(list[one]['status'] == 'dealing'){
	                    	$boxes += '<button class="btn btn-warning"  onclick="startChangeStatus(this)" date-enId="'+list[one]['id']+'" data-value="sell">改为可出售</button>';
	                    }else if(list[one]['status'] == 'hide'){
	                    		$boxes += '<button class="btn btn-warning"  onclick="startChangeStatus(this)" date-enId="'+list[one]['id']+'" data-value="sell">改为可出售</button>';
	                    }
	                    $boxes += '</p></div></div></div>';
	                    var el = jQuery($boxes);
	                    //setTimeout('', 200);
		            	$(".masonry-container").append(el).masonry('appended', el, 'reloadItems');
					}
					needle.push($page, $page);
	            	$("#page").attr("data-type", $page+1);
	            	var t = $(window).scrollTop();
					$('body,html').animate({'scrollTop':t+250},1500);
				}else{
					canLoad = false;
					$("#load_res_txt").show();
					var t = $(window).scrollTop();
					$('body,html').animate({'scrollTop':t+200},700);
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
function startChangeStatus(obj){
	clearInterval(hideModal);
	$("#modify_goods_btn").attr('date-enId', obj.getAttribute("date-enId"));
	$("#modify_goods_btn").attr('data-value', obj.getAttribute("data-value"));
	$("#modify_goods_status_body").html("确认更改吗？");
	$("#modify_goods_status").modal({
		show: true
	});
}
function changeStatus(){
	var enId = $("#modify_goods_btn").attr("date-enId");
	var to_be_status = $("#modify_goods_btn").attr("data-value");
	if(enId == '' || to_be_status == ''){
		alert('修改失败，建议您刷新浏览器重试。');
		return false;
	}
	$.ajax({
		url:APP+"/goods/ajaxstatus",
		type:'post',
		dataType:'json',
		data:{'enId':enId, 'to_be_status':to_be_status,'_token':$('meta[name="_token"]').attr('content')},
		error:function(){
			alert('修改失败，建议您刷新浏览器重试。');
			return false;
		},
		success:function(data){
			if(data.status == 'success'){
				$("#modify_goods_status_body").html(data.message);
				setTimeout(hideModal, 2000);
			}else if (data.status == 'error'){
				$("#modify_goods_status_body").html(data.message);
				window.location.href = App+"/goods/mine";
			}else if(data.status == 'illegal'){
				$("#modify_goods_status_body").html(data.message);
				window.location.href = App+"/goods/mine";
			}else{
				$("#modify_goods_status_body").html('修改失败,建议您刷新浏览器重试');
				return false;
			}
		},beforeSend:function(){
			$("#modify_goods_status_body").html('玩命修改中...');
		}
	});
}
function hideModal(){
	$('#modify_goods_status').modal('hide');
}
