@extends('app')
@section('html', '<html>')
@section('title', '创建订单')
@section('css')
<link href="{{ asset('/lib/swf_uploadify/uploadify.css') }}" rel="stylesheet" />
@endsection
@section('content')

@endsection
@section('js')
<script src="{{ asset('/js/goods/modifygoods.js')}}"></script>
<script src="{{ asset('/lib/swf_uploadify/jquery.uploadify-3.1.min.js')}}"></script>
<script src="{{ asset('/js/goods/uploadify.js')}}"></script>
@endsection
