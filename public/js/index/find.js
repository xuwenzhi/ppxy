$(function(){
	$("#find").click(function(){
		var keyword = encodeURI($("input[name=find]").val());
		var reg = new RegExp('%',"g");
		var key = keyword.replace(reg,"ppxy");
		window.location.href = $(this).attr('data-value')+'/'+key;
	});
});