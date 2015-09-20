$(function(){
	$("#find").click(function(){
		var keyword = encodeURI($("input[name=find]").val().trim());
		if(keyword == ''){
			return false;
		}
		var reg = new RegExp('%',"g");
		var key = keyword.replace(reg,"ppxy");
		window.location.href = $(this).attr('data-value')+'/'+key;
	});

	$("#search_find").on('click', function(){
		var keyword = encodeURI($("#input_keyword").val().trim());
		if(keyword == ''){
			return false;
		}
		var reg = new RegExp('%',"g");
		var key = keyword.replace(reg,"ppxy");
		window.location.href = $(this).attr('data-value')+'/'+key;
	});

	$("input[name=find]").focus(function(){
		$(document).keypress(function(e){
		    if(e.which == 13) {  
				var keyword = encodeURI($("input[name=find]").val().trim());
				if(keyword == ''){
					return false;
				}
				var reg = new RegExp('%',"g");
				var key = keyword.replace(reg,"ppxy");
				window.location.href = $("#find").attr('data-value')+'/'+key;
		    }
		}); 
	});
});


