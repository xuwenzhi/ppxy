@extends('app')
@section('title', '大杂烩')
@section('content')
<div class="container main-container">

  <div role="tabpanel">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
      <li role="presentation"><a href="{{url('/')}}">单品</a></li>
      <li role="presentation" class="active"><a href="{{url('/complex')}}">大杂烩</a></li>
      <li role="presentation"><a href="{{url('/big4')}}">大四专区</a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
    <br/>
      <div role="tabpanel" class="tab-pane active" id="panel-1">
        <div class="row masonry-container">
          @foreach($goods as $good)
          <a href="{{ url('/goods/detail/'.$good->id) }}" class="goods_block_a">
            <div  class="col-md-3 col-xs-12 item" width="100%">
              <div class="thumbnail" id="goods_block">
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
                  </p>
                </div>
              </div>
            </div>
          </a>
          @endforeach
        </div> <!--/.masonry-container  -->
      </div><!--/.tab-panel -->
    </div> <!--/.tab-content -->

  </div> <!--/.tab-panel  -->

</div><!-- /.container -->
@endsection
<input type="hidden" id="big_type" data-type="{{$type}}" />
<input type="hidden" id="page" data-type="1" />
@section('footer')
@section('js')

<script src="{{asset('/js/masonry.min.js') }}"></script>
<script type="text/javascript" src="{{asset('/js/imagesLoaded.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/goods/load_more_goods.js')}}"></script>
@endsection
@endsection
