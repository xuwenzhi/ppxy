@extends('app')
@section('title', '密码重置')
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">密码重置</div>
				<div class="panel-body">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<ul>
								@foreach ($errors->all() as $error)
								@if($error == 'The password confirmation does not match.')
									<li>两次密码输入不一致</li>
								@elseif($error == 'Passwords must be at least six characters and match the confirmation.')
									<li>请保证密码最少6位噢~</li>
								@elseif($error == 'This password reset token is invalid.')
									<li>您在平台上留下的好像不是这个邮箱噢~</li>
								@endif
								@endforeach
							</ul>
						</div>
					@endif
					<div class="alert alert-danger" id="show_reset_issue" style="display:none;">
						
					</div>
					<form class="form-horizontal" id="passRestForm" role="form" method="POST" action="{{ url('/password/reset') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="hidden" name="token" value="{{ $token }}">

						<div class="form-group">
							<label class="col-md-4 control-label">邮件地址</label>
							<div class="col-md-6">
								<input type="email" id="email" class="form-control" name="email" value="{{ old('email') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">密码</label>
							<div class="col-md-6">
								<input type="password" id="password" class="form-control" name="password">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">确认密码</label>
							<div class="col-md-6">
								<input type="password" id="confirmpassword" class="form-control" name="password_confirmation">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="button" id="passreset" class="btn btn-primary">
									点击重置
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('js')
<script type="text/javascript" src="{{asset('/js/users/passreset.js')}}"></script>
@endsection
