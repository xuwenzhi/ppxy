@extends('app')
@section('html','<html>')
@section('title', '手机号验证')
@section('content')
<div class="container">
	<ol class="breadcrumb">
	  	<li>首页</li>
	  	<li class="active">手机号验证</li>
	</ol>
<div class="row">
    <div class="col-md-9">
  	    <div class="panel-heading">
          <h5>
            
            @if($baseinfo->role == $role_pending || $baseinfo->phone_nu == '')
              @if($verify_reason != '')
              <div class="alert alert-danger" role="alert">
                <a href="#qa_verify_phone" data-toggle="modal"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></a>{{$verify_reason}}
              </div>
              @else
              <div class="alert alert-danger" role="alert">
                <a href="#qa_verify_phone" data-toggle="modal"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span></a>您尚未验证手机号,是否现在验证?
              </div>
              @endif
              
              <form action="" method="post">
                @if($url_back != '')
                <input type="hidden" id="url_back" value="{{$url_back}}" />
                @endif
                <div class="form-group">
                    <input type="text" id="veryfy_phone" class="form-control" id="veryfy_phone" required placeholder="请输入您的手机号"/>
                </div>
                <div class="form-group" style="display:none;" id="verify_code_block">
                    <input type="text" class="form-control" id="verify_code" required placeholder="请输入短信验证码"/>
                </div>
                <button type="button" id="get_verify_button" class="btn btn-warning btn-block" disabled="disabled"><span id="get_verify_button_txt">获取验证码</span><span id="time_flee" style="display:none;">60秒</span></button>
                <button type="button" id="verify_button" disabled="disabled" class="btn btn-success btn-block" style="display:none;" ><span id="verify_button_txt">下一步</span></button>
            </form>
            @else
              <div class="alert alert-success" role="alert">
                <a href="#qa_verify_phone" data-toggle="modal">
                <span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span></a>您已验证过手机号 : {{$baseinfo->phone_nu}}
              </div>

            @endif 
          </h5>
        </div>
        <div class="panel-body">
            <div class="jumbotron">
              <h3>为什么需要验证手机号?</h3>
              <p>&nbsp;&nbsp;手机号将会成为买家和卖家交易的通道,验证手机号，同时也保证了交易双方信息的有效性和真实性,我们会充分保护您的个人隐私,谢谢您的合作！</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <!-- Modal -->
        <div class="modal fade" id="qa_verify_phone" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">为什么要验证手机号?</h4>
              </div>
              <div class="modal-body">
                  手机号将会成为买家和卖家交易的通道,验证手机号，同时也保证了交易双方信息的有效性和真实性,我们会充分保护您的个人隐私,谢谢您的合作！
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
              </div>
            </div>
          </div>
        </div>
  		  <!-- Modal -->
        <div class="modal fade" id="verify_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-body" id="verify_modal_body">
                  
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
              </div>
            </div>
          </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="verify_error_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-body" id="verify_error_modal_body">
                  
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
              </div>
            </div>
          </div>
        </div>
    </div>
</div>
</div>
@endsection
@section('footer')
@endsection
@section('js')
<script src="{{ asset('/js/individual/verifyphone.js')}}"></script>
@endsection
