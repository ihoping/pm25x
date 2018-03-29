@extends('layouts.main')
@section('title', '内容')
@section('content')
    <div class="row news-desc">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <h3>忘记从什么时候开始，用颜色表示空气</h3>
            <h3>不知道什么时候可以，用甜度描述空气</h3>
        </div>
        <div class="col-md-1"></div>
    </div>
    <div class="row">
        <div class="col-md-2">

        </div>
        <div class="col-md-8">
            <div class="detail-title text-center" style="font-size: 26px;
    margin-top: 22px;">{!! $post['title'] !!}</div>
            <div class="detail-info text-center" style="color: rgb(180, 184, 187); font-size: 15px">霾视 {{ $post['created_at'] }}</div>
            <hr/>
            <div class="detail-content">
                {!! $post['body'] !!}
            </div>

        </div>
        <div class="col-md-2">

        </div>

    </div>
@endsection
@section('script')
@endsection