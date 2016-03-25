@extends('app')
@section('title', '')
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
          <div id="loading_status" class="alert alert-success alert-dismissible text-center" role="alert">
            资源正在加载中...
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div id="load_res_txt" style="display:none;" class="alert alert-danger alert-dismissible text-center" role="alert">
  服务器没有更多资源了~
</div>
<input type="hidden" id="big_type" data-type="{{$type}}" />
<input type="hidden" id="page" data-type="0" />
<input type="hidden" id="isMobile" data-type="{{$isMobile}}" />
@endsection
@section('footer')
@section('js')
<script src="{{asset('/js/masonry.min.js') }}"></script>
<script type="text/javascript" src="{{asset('/js/imagesLoaded.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/goods/load_more_goods.js')}}"></script>
@endsection
@endsection
