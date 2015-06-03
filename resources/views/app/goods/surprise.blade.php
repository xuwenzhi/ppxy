@extends('app')
@section('html', '<html>')
@section('title', '出现点小意外')
@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-12">
		<div class="panel panel-primary">
			<div class="panel-heading">出了点小意外~</div>
			<div class="panel-body">
				<div class="jumbotron">
				  	<p>
				  		{{$show}}
				  	</p>
				</div>
			</div>
		</div>
		</div>
	</div>
</div>
<br/>
<br/>

@endsection
@section('footer')
@endsection
@section('js')
@endsection
