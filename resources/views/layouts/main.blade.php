<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>@yield('title') - 霾视在线雾霾数据可视化统计与预测预警平台</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.bootcss.com/font-awesome/3.0.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/kuCity.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.min.css') }}">
</head>
<body>

<div class="wrap container-fluid">
    <!---头部地址与搜索-->
    <div class="row header">
        <div class="col-md-6 hidden-xs">
        </div>
        <div class="col-md-2 col-xs-6 address">
            <i class="icon-map-marker"></i>
            <span id="area">{{ $area }}</span>|<a href="javascript:void(0)" data-toggle="modal" data-target="#areaChooseModal">更换</a>
        </div>
        <div class="col-md-2 userinfo hidden-xs">
            @auth
                <i class="icon-user"></i>
                <span class="username">{{ Auth::user()['name'] }}</span>
                <ul class="dropdown-menu user-operate" aria-labelledby="dropdownMenu2">
                    <li><a href="#">个人中心</a></li>
                    <li role="separator" class="divider"></li>
                    <li>
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            Logout
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>
                </ul>
            @endauth
            @guest
                <a href="login">登录</a>|
                <a href="register">注册</a>
            @endguest

        </div>
        <div class="col-md-2 col-xs-6 address-search ">
            <input type="text" class="searchContent" placeholder="请输入您要搜索的内容...">
            <button type="button" onclick="search()"></button>
        </div>
    </div>
    <!--头部地址与搜索end-->
    <!--导航-->
    <div class="row m-nav">
        <div class="row">
            <div class="col-md-2 logo">
                <img src="{{ asset('img/logom2.png') }}"/>
            </div>
            <div class="col-md-4"></div>
            <div class="col-md-6">
                <ul class="nav nav-pills">
                    <li role="presentation" class="@if ($nav == 'home') selected @endif"><a href="{{ action('HomeController@index') }}"><i class="icon-home"></i> 首页</a></li>
                    <li role="presentation" class="@if ($nav == 'visual') selected @endif"><a href="{{ action('VisualController@index') }}"><i class=" icon-leaf"></i> 历史数据</a></li>
                    <li role="presentation" class="@if ($nav == 'rank') selected @endif"><a href="{{ action('RankController@index') }}"><i class="  icon-signal"></i> 排行榜</a></li>
                    <li role="presentation" class="@if ($nav == 'news') selected @endif"><a href="{{ action('NewsController@index') }}"><i class=" icon-bullhorn"></i> 资讯</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!--导航end-->
    <!--内容区-->
    @section('content')
        这是内容区。
    @show
<!--内容区end-->
    <!--底部-->
    <div class="row footer">
        <div class="col-md-2">

        </div>
        <div class="col-md-8 copyright">
            <p><a target="_blank" href="https://wpa.qq.com/msgrd?v=3&uin=1490771889&site=qq&menu=yes">联系作者</a> | <a
                        href="https://github.com/for-light">Github</a> | <a target="_blank"
                                                                            href="https://blog.hoping.me">博客</a> | <a
                        target="_blank" href="about.html">关于</a></p>
            <p>Powered By Lu tian song 版权所有</p>
            <address>address:南京信息工程大学计算机与软件学院</address>
        </div>
        <div class="col-md-2">

        </div>

    </div>
    <!--底部end-->
    <!--弹出框-->
    <div class="modal fade" id="areaChooseModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">选择地区</h4>
                </div>
                <div class="modal-body">
                    <p><input id="areaChoose" name="area" placeholder="点击选择地区"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary sub-area">保存</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
</div>
</body>
<script src="https://cdn.bootcss.com/jquery/2.1.4/jquery.min.js"></script>
<script src="https://cdn.bootcss.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
{{--<script src="{{ asset('js/vue.js') }}"></script>--}}
<script src="{{ asset('js/public.js') }}"></script>
<script src="{{ asset('js/ecStat.min.js') }}"></script>
<script src="https://cdn.bootcss.com/echarts/4.0.4/echarts.min.js"></script>
<script src="{{ asset('js/kuCity.js') }}"></script>
<script src="{{ asset('js/china.js') }}"></script>
<script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#areaChoose').kuCity();
    $('.username').hover(function () {
        $('.user-operate').show();
    }, function () {
//        $('.user-operate').hide()
    });
    $('.user-operate').hover(function () {
        $('.user-operate').show();
    }, function () {
        $('.user-operate').hide()
    })
    $('.sub-area').click(function () {
        var area = $('#areaChoose').val();
        if (area == '') {
            alert('你还没选择地区！');
            return false;
        }
        $.ajax({
            url: "{{ route('changeArea') }}",
            type: 'post',
            data: {
                area: area,
            },
            success: function (response) {
                if (response.status) {
                    location.reload();
                } else {
                    alert('抱歉暂不支持该地区！')
                }
            }
        });
    })
</script>
<script>
    function search() {
        var content = $('.searchContent').val();
        location.href = "{{ route('news') }}?q=" +content;

    }
</script>
@section('script')
    脚本。
@show
</html>