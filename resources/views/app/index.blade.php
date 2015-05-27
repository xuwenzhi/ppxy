@extends('app')
@section('title', '主页')
@section('content')
<div class="container main-container">

  <div role="tabpanel">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
      <li role="presentation" class="active"><a href="{{url('/')}}">单品</a></li>
      <li role="presentation"><a href="{{url('/complex')}}">大杂烩</a></li>
      <li role="presentation"><a href="{{url('/big4')}}">大四专区</a></li>
    </ul>
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

<script src="http://cdn.bootcss.com/masonry/3.3.0/masonry.pkgd.min.js"></script>
<script src="http://cdn.bootcss.com/jquery.imagesloaded/3.1.8/imagesloaded.min.js"></script>
<script type="text/javascript" src="{{asset('/js/goods/list.js')}}"></script>
@endsection
@endsection
