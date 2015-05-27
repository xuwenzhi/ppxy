@extends('app')
@section('title', '主页')
@section('content')
<div class="container main-container">

  <div role="tabpanel">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
      <li role="presentation" class="active"><a href="#panel-1" aria-controls="panel-1" role="tab" data-toggle="tab">默认</a></li>
      <li role="presentation"><a href="#panel-single" id="single" aria-controls="panel-2" role="tab" data-toggle="tab">单品</a></li>
      <li role="presentation"><a href="#panel-hotchpotch" aria-controls="panel-2" role="tab" data-toggle="tab">大杂烩</a></li>
      <li role="presentation"><a href="#panel-big4" aria-controls="panel-3" role="tab" data-toggle="tab">大四专区</a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
    <br/>
      <div role="tabpanel" class="tab-pane active" id="panel-1">
        <div class="row masonry-container">

        @foreach($goods as $good)
          <div id="goods_block" class="col-md-3 col-xs-12 item" width="100%">
            <div class="thumbnail">
            @if($good->img_thumb_path!='')
              	<img src="{{$good->img_thumb_path}}" class="img-responsive img-rounded" width="100%" alt="">
            @endif
              <div class="caption">
                <h3>{{$good->title}}</h3>
                <ul class="list-group">
                	<li class="list-group-item"><span class="label label-danger">¥{{$good->price}}</span>&nbsp;&nbsp;<span class="label label-danger">{{$good->type_name}}</span></li>                	
                	<li class="list-group-item">{{$good->username}}发布于{{$good->trans_time}}</li>
                	<li class="list-group-item"><span class="label label-success">{{$good->school_name}}</span></li>
				</ul>
                <p>{{$good->content}}</p>
                <p><a href="{{ url('/goods/detail/'.$good->id) }}" class="btn btn-primary" role="button">查看详情</a>
              </div>
            </div>
          </div><!--/.item  -->
        @endforeach

        </div> <!--/.masonry-container  -->
      </div><!--/.tab-panel -->

      <div role="tabpanel" class="tab-pane" id="panel-single">
        <div class="row masonry-container" id="panel-single-masonry">

          

        </div> <!--/.masonry-container  -->
      </div><!--/.tab-panel -->

      <div role="tabpanel" class="tab-pane" id="panel-hotchpotch">
        <div class="row masonry-container">

          <div class="col-md-4 col-sm-6 item">
            <div class="thumbnail">
              <img src="http://lorempixel.com/200/200/nature" alt="">
              <div class="caption">
                <h3>Thumbnail label</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. </p>
                <p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
              </div>
            </div>
          </div><!--/.item  -->

        </div> <!--/.masonry-container  -->
      </div><!--/.tab-panel -->

      <div role="tabpanel" class="tab-pane" id="panel-big4">
        <div class="row masonry-container">

          <div class="col-md-4 col-sm-6 item">
            <div class="thumbnail">
              <img src="http://lorempixel.com/200/200/cats" alt="">
              <div class="caption">
                <h3>Thumbnail label</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corrupti, illum voluptates consectetur consequatur ducimus. Necessitatibus, nobis consequatur hic eaque laborum laudantium. Adipisci, explicabo, asperiores molestias deleniti unde dolore enim quas.</p>
                <p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
              </div>
            </div>
          </div>

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
