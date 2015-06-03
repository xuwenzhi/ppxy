@extends('app')
@section('title', '用户注册')
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">注册</div>
				<div class="panel-body">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							发生了一点点错误<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif
					<div class="alert alert-danger" id="show_register_issue" style="display:none;">
						
					</div>
					<form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/register') }}" id="registerForm">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<label class="col-md-4 control-label">昵称</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" placeholder="请输入2-16位昵称" />
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">邮件地址</label>
							<div class="col-md-6">
								<input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}" placeholder="请输入有效的邮箱" />
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">密码</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password" id="password" placeholder="请输入6-19位密码"/>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">确认密码</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="请确认密码"/>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="button" class="btn btn-success" id="register_btn">
									点击注册
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
<script type="text/javascript" src="{{ asset('/js/users/register.js') }}"></script>
@endsection
