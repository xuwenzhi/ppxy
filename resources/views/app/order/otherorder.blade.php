<div class="panel panel-success">
<div class="panel-heading">
	<h5>{{$recommend_widget_title}}</h5><span class="label label-danger"></span>
</div>
<div class="panel-body">
<ul class="list-group">
@if(count($recommend_widget_body)!=0)
@foreach($recommend_widget_body as $list)
<a href="{{ url('/goods/detail').'/'.$list['id'] }}">
  	<li class="list-group-item">
    	{{$list['goods_title']}}
 	</li>
 </a>
@endforeach
@else
<div class="alert" role="alert">
	暂无。
</div>
@endif
</ul>
</div>
</div>
