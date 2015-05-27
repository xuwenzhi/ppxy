@extends('app')
@section('html', '<html>')
@section('title', '404')
@section('css')
@endsection
@section('content')
<div class="container">
    <div>
        <a href="{{url('/')}}"><img src="{{ asset('/images/404_icon.png') }}" width="30%" class="img-responsive center-block" /></a>
        <div class="center-block">
            <h1 class="text-center">唉呀!</h1>
            <p class="text-center">你正在寻找的页面无法找到。<br/><a style="color:#ff6600;" href="{{url('/')}}">可能在这里！</a><br/>
            <a class="text-center" href="/" onclick="history.go(-1)"><span id="sec">5</span> 秒后返回首页</a></p>
            <br /><br /><br />
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
$(function () {            
   setTimeout("lazyGo();", 1000);
});
function lazyGo() {
    var sec = $("#sec").text();
    $("#sec").text(--sec);
    if (sec > 0)
        setTimeout("lazyGo();", 1000);
    else
        window.location.href = "{{ url('/') }}";
}
</script>
@endsection
