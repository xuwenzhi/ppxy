@extends('app')
@section('title', '我的商品')
@section('content')
<div class="container main-container">
<ol class="breadcrumb">
	  	<li>首页</li>
	  	<li class="active">查询结果</li>
      <li class="active" id="keyword" data-value="{{$keyword}}">关键字:{{$keyword}}</li>
	</ol>
  <div role="tabpanel">
    <!-- Tab panes -->
    <div class="tab-content">
    <br/>
      <div role="tabpanel" class="tab-pane active" id="panel-1">
        <div class="row masonry-container">
          @foreach($goods as $good)
            <div  class="col-md-3 col-xs-12 item" width="100%">
              <div class="thumbnail" id="goods_block">
              @if($good->img_thumb_path!='')
                  <img src="{{asset('/').$good->img_thumb_path}}" class="img-responsive img-rounded" width="75%" alt="">
              @endif
                <div class="caption">
                  <h3>{{$good->title}}</h3>
                  <ul class="list-group">
                    <li class="list-group-item"><span class="glyphicon glyphicon-tag" aria-hidden="true"></span>&nbsp;
                      <span class="label label-danger">¥{{$good->price}}</span>&nbsp;
                      <span class="label label-danger">{{$good->type_name}}</span>&nbsp;
                      <span class="label label-danger">{{$good->new_level}}</span>
                    </li>
                    <li class="list-group-item"><span class="glyphicon glyphicon-time" aria-hidden="true"></span>&nbsp;{{$good->trans_time}}</li>
                    <li class="list-group-item"><span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span>&nbsp;{{$good->school_name}}&nbsp;{{$good->deal_place_ext}}</li>
                  </ul>
                  <p>
                   <a href="{{ url('/goods/detail/'.$good->id) }}" class="goods_block_a"><button class="btn btn-primary" onclick="window.location.href={{asset('/').$good->img_thumb_path}}">查看详情</button></a>
                  </p>
                </div>
              </div>
            </div>
          @endforeach
        </div> <!--/.masonry-container  -->
      </div><!--/.tab-panel -->
    </div> <!--/.tab-content -->

  </div> <!--/.tab-panel  -->

</div><!-- /.container -->
<!-- Modal -->
<div class="modal fade" id="modify_goods_status" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body" id="modify_goods_status_body">
          <input type="hidden" id="to_be_goods_enid" value="" />
          <input type="hidden" id="to_be_status" value="" />
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="modify_goods_btn" onclick="changeStatus()" date-enId="" data-value="">确定</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
      </div>
    </div>
  </div>
</div>
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
<script type="text/javascript" src="{{asset('/js/goods/lookfor.js')}}"></script>
@endsection
