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
            
            @if($baseinfo->role == $role_pending && $baseinfo->phone_nu == '')
              <div class="alert alert-success" role="alert">
                <a href="#qa_verify_phone" data-toggle="modal"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span></a>尚未验证手机号,是否现在验证?</div>
              <!-- Modal -->
              <div class="modal fade" id="qa_verify_phone" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title" id="myModalLabel">为什么要验证手机号?</h4>
                    </div>
                    <div class="modal-body">
                        验证手机号,保证了交易双方信息的有效性和真实性,我们会充分保护您的个人隐私,谢谢您的合作！
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
              <form action="" method="post">
                <div class="form-group">
                <label for="veryfy_phone" class="control-label">请输入您的手机号</label>
                    <input type="text" id="veryfy_phone" class="form-control" id="veryfy_phone" required placeholder="请输入您的手机号"/>
                </div>
                <div class="form-group" style="display:none;" id="verify_code_block">
                    <input type="text" class="form-control" id="veryfy_code" required placeholder="请输入短信验证码"/>
                </div>
                <button type="button" id="verify_button" class="btn btn-success btn-block" disabled="disabled"><span id="verify_button_txt">点击获取验证码</span><span id="time_flee" style="display:none;">60</span></button>
            </form>
            @else
              您已验证手机号
            @endif 
          </h5>
        </div>
        <div class="panel-body">

        </div>   
    </div>
    <div class="col-md-3">
  		
    </div>
</div>
</div>
@endsection
@section('footer')
2015 &copy; PP校园
@endsection
@section('js')
<script src="{{ asset('/js/individual/verifyphone.js')}}"></script>
@endsection
