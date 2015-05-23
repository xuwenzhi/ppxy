<div class="panel panel-success">
<div class="panel-heading">
	<h5>同类货</h5><span class="label label-danger"></span>
</div>
<div class="panel-body">
<ul class="list-group">
@if(count($same_goods)!=0)
@foreach($same_goods as $goods)
<a href="{{ url('/goods/detail').'/'.$goods['id'] }}">
  	<li class="list-group-item">
    {{$goods['title']}}
 	</li>
 </a>
@endforeach
@else
<div class="alert" role="alert">
	暂无同类货。
</div>
@endif
</ul>
</div>
</div>
