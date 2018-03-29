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
    <div class="row news-content">
        <div class="col-md-1"></div>
        <div class="col-md-10" style="background: #F9F9F9; line-height: 40px; border-radius: 10px">
            <div class="row">
                <div class="col-md-2">
                    <a href="#"><img src="storage/news/example.jpg" width="120" height="80" /></a>
                </div>
                <div class="col-md-10">
                    <div class="row">
                        <div class="col-md-12">
                            <span class="news-title">南方多地百花争艳 踏春赏景正当时</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <span class="news-publisher">中国新闻网 2018-03-29 10:18</span>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        <div class="col-md-1"></div>
    </div>
    <div class="row news-content">
        <div class="col-md-1"></div>
        <div class="col-md-10" style="background: #F9F9F9; line-height: 40px; border-radius: 10px">
            <div class="row">
                <div class="col-md-2">
                    <a href="#"><img src="storage/news/example.jpg" width="120" height="80" /></a>
                </div>
                <div class="col-md-10">
                    <div class="row">
                        <div class="col-md-12">
                            <span class="news-title">南方多地百花争艳 踏春赏景正当时</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <span class="news-publisher">中国新闻网 2018-03-29 10:18</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-1"></div>
    </div>
    <nav aria-label="...">
        <ul class="pager">
            <li class="disabled"><a href="#">Previous</a></li>
            <li><a href="#">Next</a></li>
        </ul>
    </nav>
@endsection
@section('script')
@endsection