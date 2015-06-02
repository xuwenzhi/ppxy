@extends('app')
@section('title', '我的商品')
@section('content')
<div class="container main-container">
<ol class="breadcrumb">
	  	<li>首页</li>
	  	<li class="active">我的商品</li>
	</ol>
  <div role="tabpanel">
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
                    <li class="list-group-item">
                      <span class="label label-danger">¥{{$good->price}}</span>&nbsp;
                      <span class="label label-danger">{{$good->type_name}}</span>&nbsp;
                      <span class="label label-danger">{{$good->new_level}}</span>
                    </li>
                    <li class="list-group-item">{{$good->trans_time}}</li>
                    <li class="list-group-item">{{$good->school_name}}</li>
                  </ul>
                  <p>
                    <button class="btn btn-primary" onclick="window.location.href={{asset('/').$good->img_thumb_path}}">查看详情</button>
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
<br/>
<div id="load_res_txt" style="display:none;" class="alert alert-danger alert-dismissible text-center" role="alert">
  服务器没有更多资源了~
</div>
<input type="hidden" id="page" data-type="1" />
@endsection
@section('footer')
@endsection
@section('js')
<script src="{{asset('/js/masonry.min.js') }}"></script>
<script type="text/javascript" src="{{asset('/js/imagesLoaded.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/goods/mine.js')}}"></script>
@endsection
