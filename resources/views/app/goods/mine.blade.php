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
          @include('app.listcommon', ['goods' => $goods])
        </div> <!--/.masonry-container  -->
      </div><!--/.tab-panel -->
    </div> <!--/.tab-content -->

  </div> <!--/.tab-panel  -->

</div><!-- /.container -->
@endsection
@section('footer')
@section('js')

<script src="{{asset('/js/masonry.min.js') }}"></script>
<script type="text/javascript" src="{{asset('/js/imagesLoaded.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/goods/list.js')}}"></script>
@endsection
@endsection
