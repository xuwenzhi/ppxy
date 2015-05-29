@extends('app')
@section('title', '找回密码')
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">找回密码</div>
				<div class="panel-body">
					@if (session('status'))
						<div class="alert alert-success">
							@if(session('status') == 'We have e-mailed your password reset link!')
								我们已经向您的邮件地址发送一条重置密码的链接噢~
							@else
								{{ session('status') }}
							@endif
						</div>
					@endif

					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<ul>
								@foreach ($errors->all() as $error)
									@if($error == "We can't find a user with that e-mail address.")
										您好像不是用这个邮件地址注册的PP校园噢，换一个试试吧~
									@endif
								@endforeach
							</ul>
						</div>
					@endif

					<form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<label class="col-md-4 control-label">请输入邮件地址</label>
							<div class="col-md-6">
								<input type="email" class="form-control" name="email" value="{{ old('email') }}">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									给我发送重置密码邮件
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
