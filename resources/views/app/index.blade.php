@extends('app')
@section('title', '主页')
@section('content')
<div class="container main-container">

  <div role="tabpanel">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
      <li role="presentation" class="active"><a href="#panel-1" aria-controls="panel-1" role="tab" data-toggle="tab">Panel 1</a></li>
      <li role="presentation"><a href="#panel-2" aria-controls="panel-2" role="tab" data-toggle="tab">Panel 2</a></li>
      <li role="presentation"><a href="#panel-3" aria-controls="panel-3" role="tab" data-toggle="tab">Panel 3</a></li>
      <li role="presentation"><a href="#panel-4" aria-controls="panel-4" role="tab" data-toggle="tab">Panel 4</a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">

      <div role="tabpanel" class="tab-pane active" id="panel-1">
        <div class="row masonry-container">
        @foreach($goods as $good)
        <a href="{{ url('/goods/detail/'.$good->id) }}" id="goods_block" target="__blank">
          <div class="col-md-4 col-sm-6 item">
            <div class="thumbnail">
            @if($good->img_thumb_path!='')
              	<img src="{{$good->img_thumb_path}}" class="img-responsive img-rounded" alt="">
            @endif
              <div class="caption">
                <h3>{{$good->title}}</h3>
                <ul class="list-group">
                	<li class="list-group-item"><span class="label label-danger">¥{{$good->price}}</span></li>
                	<li class="list-group-item">{{$good->username}}发布于{{$good->trans_time}}</li>
                	<li class="list-group-item"><span class="label label-success">{{$good->school_name}}{{$good->deal_place_ext}}</span></li>
				</ul>
                <p>{{$good->content}}</p>
                <p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
              </div>
            </div>
          </div><!--/.item  -->
      	</a>
        @endforeach
          <div class="col-md-4 col-sm-6 item">
            <div class="thumbnail">
              <div class="caption">
                <h3>Thumbnail label</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corrupti, illum voluptates consectetur consequatur ducimus. Necessitatibus, nobis consequatur hic eaque laborum laudantium. Adipisci, explicabo, asperiores molestias deleniti unde dolore enim quas.</p>
                <p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
              </div>
            </div>
          </div><!--/.item  -->

          <div class="col-md-4 col-sm-6 item">
            <div class="thumbnail">
              <img src="http://lorempixel.com/200/200/abstract" alt="">
              <div class="caption">
                <h3>Thumbnail label</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corrupti, illum voluptates consectetur consequatur ducimus. Necessitatibus, nobis consequatur hic eaque laborum laudantium. Adipisci, explicabo, asperiores molestias deleniti unde dolore enim quas.</p>
                <p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
              </div>
            </div>
          </div><!--/.item  -->

          <div class="col-md-4 col-sm-6 item">
            <div class="thumbnail">
              <img src="http://lorempixel.com/200/200/abstract" alt="">
              <div class="caption">
                <h3>Thumbnail label</h3>
                <p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
              </div>
            </div>
          </div><!--/.item  -->

          <div class="col-md-4 col-sm-6 item">
            <div class="thumbnail">
              <img src="http://lorempixel.com/200/200/abstract" alt="">
              <div class="caption">
                <h3>Thumbnail label</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corrupti, illum voluptates consectetur consequatur ducimus. Necessitatibus, nobis consequatur hic eaque laborum laudantium. Adipisci, explicabo, asperiores molestias deleniti unde dolore enim quas.</p>
                <p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
              </div>
            </div>
          </div><!--/.item  -->

          <div class="col-md-4 col-sm-6 item">
            <div class="thumbnail">
              <img src="http://lorempixel.com/200/200/abstract" alt="">
              <div class="caption">
                <h3>Thumbnail label</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corrupti, illum voluptates consectetur consequatur ducimus. Necessitatibus, nobis consequatur hic eaque laborum laudantium. Adipisci, explicabo, asperiores molestias deleniti unde dolore enim quas.</p>
                <p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
              </div>
            </div>
          </div>

        </div> <!--/.masonry-container  -->
      </div><!--/.tab-panel -->

      <div role="tabpanel" class="tab-pane" id="panel-2">

        <div class="row masonry-container">

          <div class="col-md-4 col-sm-6 item">
            <div class="thumbnail">
              <img src="http://lorempixel.com/200/200/city" alt="">
              <div class="caption">
                <h3>Thumbnail label</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. </p>
                <p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
              </div>
            </div>
          </div><!--/.item  -->

          <div class="col-md-4 col-sm-6 item">
            <div class="thumbnail">
              <div class="caption">
                <h3>Thumbnail label</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corrupti, illum voluptates consectetur consequatur ducimus. Necessitatibus, nobis consequatur hic eaque laborum laudantium. Adipisci, explicabo, asperiores molestias deleniti unde dolore enim quas.</p>
                <p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
              </div>
            </div>
          </div><!--/.item  -->

          <div class="col-md-4 col-sm-6 item">
            <div class="thumbnail">
              <img src="http://lorempixel.com/200/200/city" alt="">
              <div class="caption">
                <h3>Thumbnail label</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corrupti, illum voluptates consectetur consequatur ducimus. Necessitatibus, nobis consequatur hic eaque laborum laudantium. Adipisci, explicabo, asperiores molestias deleniti unde dolore enim quas.</p>
                <p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
              </div>
            </div>
          </div><!--/.item  -->

          <div class="col-md-4 col-sm-6 item">
            <div class="thumbnail">
              <img src="http://lorempixel.com/200/200/city" alt="">
              <div class="caption">
                <h3>Thumbnail label</h3>
                <p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
              </div>
            </div>
          </div><!--/.item  -->

          <div class="col-md-4 col-sm-6 item">
            <div class="thumbnail">
              <img src="http://lorempixel.com/200/200/city" alt="">
              <div class="caption">
                <h3>Thumbnail label</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corrupti, illum voluptates consectetur consequatur ducimus. Necessitatibus, nobis consequatur hic eaque laborum laudantium. Adipisci, explicabo, asperiores molestias deleniti unde dolore enim quas.</p>
                <p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
              </div>
            </div>
          </div><!--/.item  -->

          <div class="col-md-4 col-sm-6 item">
            <div class="thumbnail">
              <img src="http://lorempixel.com/200/200/city" alt="">
              <div class="caption">
                <h3>Thumbnail label</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corrupti, illum voluptates consectetur consequatur ducimus. Necessitatibus, nobis consequatur hic eaque laborum laudantium. Adipisci, explicabo, asperiores molestias deleniti unde dolore enim quas.</p>
                <p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
              </div>
            </div>
          </div>

        </div> <!--/.masonry-container  -->

      </div><!--/.tab-panel -->

      <div role="tabpanel" class="tab-pane" id="panel-3">
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

          <div class="col-md-4 col-sm-6 item">
            <div class="thumbnail">
              <div class="caption">
                <h3>Thumbnail label</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corrupti, illum voluptates consectetur consequatur ducimus. Necessitatibus, nobis consequatur hic eaque laborum laudantium. Adipisci, explicabo, asperiores molestias deleniti unde dolore enim quas.</p>
                <p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
              </div>
            </div>
          </div><!--/.item  -->

          <div class="col-md-4 col-sm-6 item">
            <div class="thumbnail">
              <img src="http://lorempixel.com/200/200/nature" alt="">
              <div class="caption">
                <h3>Thumbnail label</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corrupti, illum voluptates consectetur consequatur ducimus. Necessitatibus, nobis consequatur hic eaque laborum laudantium. Adipisci, explicabo, asperiores molestias deleniti unde dolore enim quas.</p>
                <p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
              </div>
            </div>
          </div><!--/.item  -->

          <div class="col-md-4 col-sm-6 item">
            <div class="thumbnail">
              <img src="http://lorempixel.com/200/200/nature" alt="">
              <div class="caption">
                <h3>Thumbnail label</h3>
                <p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
              </div>
            </div>
          </div><!--/.item  -->

          <div class="col-md-4 col-sm-6 item">
            <div class="thumbnail">
              <img src="http://lorempixel.com/200/200/nature" alt="">
              <div class="caption">
                <h3>Thumbnail label</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corrupti, illum voluptates consectetur consequatur ducimus. Necessitatibus, nobis consequatur hic eaque laborum laudantium. Adipisci, explicabo, asperiores molestias deleniti unde dolore enim quas.</p>
                <p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
              </div>
            </div>
          </div><!--/.item  -->

          <div class="col-md-4 col-sm-6 item">
            <div class="thumbnail">
              <img src="http://lorempixel.com/200/200/nature" alt="">
              <div class="caption">
                <h3>Thumbnail label</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corrupti, illum voluptates consectetur consequatur ducimus. Necessitatibus, nobis consequatur hic eaque laborum laudantium. Adipisci, explicabo, asperiores molestias deleniti unde dolore enim quas.</p>
                <p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
              </div>
            </div>
          </div>

        </div> <!--/.masonry-container  -->
      </div><!--/.tab-panel -->

      <div role="tabpanel" class="tab-pane" id="panel-4">
        <div class="row masonry-container">

          <div class="col-md-4 col-sm-6 item">
            <div class="thumbnail">
              <img src="http://lorempixel.com/200/200/cats" alt="">
              <div class="caption">
                <h3>Thumbnail label</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. </p>
                <p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
              </div>
            </div>
          </div><!--/.item  -->

          <div class="col-md-4 col-sm-6 item">
            <div class="thumbnail">
              <div class="caption">
                <h3>Thumbnail label</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corrupti, illum voluptates consectetur consequatur ducimus. Necessitatibus, nobis consequatur hic eaque laborum laudantium. Adipisci, explicabo, asperiores molestias deleniti unde dolore enim quas.</p>
                <p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
              </div>
            </div>
          </div><!--/.item  -->

          <div class="col-md-4 col-sm-6 item">
            <div class="thumbnail">
              <img src="http://lorempixel.com/200/200/cats" alt="">
              <div class="caption">
                <h3>Thumbnail label</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corrupti, illum voluptates consectetur consequatur ducimus. Necessitatibus, nobis consequatur hic eaque laborum laudantium. Adipisci, explicabo, asperiores molestias deleniti unde dolore enim quas.</p>
                <p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
              </div>
            </div>
          </div><!--/.item  -->

          <div class="col-md-4 col-sm-6 item">
            <div class="thumbnail">
              <img src="http://lorempixel.com/200/200/cats" alt="">
              <div class="caption">
                <h3>Thumbnail label</h3>
                <p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
              </div>
            </div>
          </div><!--/.item  -->

          <div class="col-md-4 col-sm-6 item">
            <div class="thumbnail">
              <img src="http://lorempixel.com/200/200/cats" alt="">
              <div class="caption">
                <h3>Thumbnail label</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corrupti, illum voluptates consectetur consequatur ducimus. Necessitatibus, nobis consequatur hic eaque laborum laudantium. Adipisci, explicabo, asperiores molestias deleniti unde dolore enim quas.</p>
                <p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
              </div>
            </div>
          </div><!--/.item  -->

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
<script>
(function( $ ) {

	var $container = $('.masonry-container');
	$container.imagesLoaded( function () {
		$container.masonry({
			columnWidth: '.item',
			itemSelector: '.item'
		});
	});
	
	//Reinitialize masonry inside each panel after the relative tab link is clicked - 
	$('a[data-toggle=tab]').each(function () {
		var $this = $(this);

		$this.on('shown.bs.tab', function () {
		
			$container.imagesLoaded( function () {
				$container.masonry({
					columnWidth: '.item',
					itemSelector: '.item'
				});
			});

		}); //end shown
	});  //end each
	
})(jQuery);
</script>
@endsection
@endsection
