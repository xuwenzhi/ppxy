@extends('admin.header')
@section('Css')
@endsection
@section('content')
<body class="error-404">
    <div class="error-wrap error-wrap-404">
        <div class="metro big terques">
           <span> Whoops! </span>
        </div>
        <div class="metro green">
            <span> 4 </span>
        </div>
        <div class="metro yellow">
            <span> 0 </span>
        </div>
        <div class="metro purple">
            <span> 4 </span>
        </div>
        <div class="metro double red">
            <span class="page-txt"> 页面没有找到 </span>
        </div>
        <div class="metro gray">
        <a href="{{ url('/admin') }}" class="home"><font size="11px">Home</font> </a>
        </div>
    </div>
@endsection

@section('js')

@endsection
