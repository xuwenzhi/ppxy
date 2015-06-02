@extends('app')
@section('title', '主页')
@section('content')
<div class="container main-container">

  <div role="tabpanel">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
    @if($active == 'index')
      <li role="presentation" class="active"><a href="{{url('/')}}">单品</a></li>
      <li role="presentation"><a href="{{url('/complex')}}">大杂烩</a></li>
      <li role="presentation"><a href="{{url('/big4')}}">大四专区</a></li>
    @elseif($active == 'complex')
      <li role="presentation"><a href="{{url('/')}}">单品</a></li>
      <li role="presentation" class="active"><a href="{{url('/complex')}}">大杂烩</a></li>
      <li role="presentation"><a href="{{url('/big4')}}">大四专区</a></li>
    @else
      <li role="presentation"><a href="{{url('/')}}">单品</a></li>
      <li role="presentation"><a href="{{url('/complex')}}">大杂烩</a></li>
      <li role="presentation" class="active"><a href="{{url('/big4')}}">大四专区</a></li>
    @endif
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
    <br/>
      <div role="tabpanel" class="tab-pane active">
        <div class="row masonry-container" id="goods_block_container">
          @foreach($goods as $good)
          <a href="{{ url('/goods/detail/'.$good->id) }}" class="goods_block_a">
            <div class="col-md-3 col-xs-12 item" width="100%">
              <div class="thumbnail" id="goods_block">
              @if($good->img_thumb_path!='')
                  <img src="{{asset('/').$good->img_thumb_path}}" class="img-responsive img-rounded" width="75%" alt="">
              @endif
                <div class="caption">
                  <h3>{{$good->title}}</h3>
                  <ul class="list-group">
                    <li class="list-group-item"><span class="label label-danger">¥{{$good->price}}</span>&nbsp;&nbsp;<span class="label label-danger">{{$good->type_name}}</span></li>                  
                    <li class="list-group-item">{{$good->trans_time}}</li>
                    <li class="list-group-item">{{$good->school_name}}&nbsp;{{$good->deal_place_ext}}</li>
                  </ul>
                  <p>
                  <button class="btn btn-primary" onclick="window.location.href={{asset('/').$good->img_thumb_path}}">查看详情</button>
                  </p>
                </div>
              </div>
            </div>
          </a>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>
<div id="load_res_txt" style="display:none;" class="alert alert-danger alert-dismissible text-center" role="alert">
  服务器没有更多资源了~
</div>
<input type="hidden" id="big_type" data-type="{{$type}}" />
<input type="hidden" id="page" data-type="1" />
@endsection
@section('footer')
@section('js')
<script src="{{asset('/js/masonry.min.js') }}"></script>
<script type="text/javascript" src="{{asset('/js/imagesLoaded.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/goods/load_more_goods.js')}}"></script>
@endsection
@endsection
