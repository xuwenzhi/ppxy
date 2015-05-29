@foreach($goods as $good)
  <div id="goods_block" class="col-md-3 col-xs-12 item" width="100%">
    <div class="thumbnail">
    @if($good->img_thumb_path!='')
      	<img src="{{asset('/').$good->img_thumb_path}}" class="img-responsive img-rounded" width="75%" alt="">
    @endif
      <div class="caption">
        <h3>{{$good->title}}</h3>
        <ul class="list-group">
        	<li class="list-group-item"><span class="label label-danger">¥{{$good->price}}</span>&nbsp;&nbsp;<span class="label label-danger">{{$good->type_name}}</span></li>                	
        	<li class="list-group-item">{{$good->trans_time}}</li>
        	<li class="list-group-item">{{$good->school_name}}</li>
        </ul>
        <p>
          <a href="{{ url('/goods/detail/'.$good->id) }}" class="btn btn-primary" role="button">查看详情</a>
          <a href="{{ url('/order/'.$good->id.'/precheck/') }}" class="btn btn-primary" role="button">立即下单</a>
        </p>
      </div>
    </div>
  </div><!--/.item  -->
@endforeach
