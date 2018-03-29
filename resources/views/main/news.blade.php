@extends('layouts.main')
@section('title', '资讯')
@section('content')
    <div class="row news-desc">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <h3>忘记从什么时候开始，用颜色表示空气</h3>
            <h3>不知道什么时候可以，用甜度描述空气</h3>
        </div>
        <div class="col-md-1"></div>
    </div>
    @foreach ($posts as $post)
        <div class="row news-content">
            <div class="col-md-1"></div>
            <div class="col-md-10" style="background: #F9F9F9; line-height: 40px; border-radius: 10px">
                <div class="row">
                    <div class="col-md-2">
                        <a href="{{ url('/news/') . '/' . $post->id}}"><img src="{{ env('APP_STORAGE_URL') . '/' . $post->image }}" width="120" height="80" /></a>
                    </div>
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-md-12">
                                <a href="{{ url('/news/') . '/' . $post->id}}"> <span class="news-title">{{ $post->title }}</span></a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <span class="news-publisher">霾视 {{ $post->created_at }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-1"></div>
        </div>
    @endforeach
    <div class="text-center">
        {{ $posts->links() }}
    </div>
@endsection
@section('script')
@endsection