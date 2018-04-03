@extends('layouts.main')
@section('title', '可视化')
@section('content')
    <div class="row visual-desc">
        <div class="col-md-1"></div>
        <div class="col-md-10"><h1>数据发现真理</h1>
            <em>*本站搜罗了从2014-05-13到现在全国三百多个城市全天24小时约一千万条空气质量数据</em></div>
        <div class="col-md-1"></div>
    </div>
    <div class="row visual-chart">
        <div class="col-md-2">
            <ul class="nav nav-pills nav-stacked text-center">
                <li role="presentation" class="disabled"><a href="javascript:void(0)"><i class="icon-bookmark"></i> 维度选择>></a></li>
                <li role="presentation" class="@if($tab == 'country') selected @endif"><a href="{{ url('/visual?tab=country') }}"><i class="icon-fire"></i> 全国</a></li>
                <li role="presentation" class="@if($tab == 'province') selected @endif"><a href="{{ url('/visual?tab=province') }}"><i class=" icon-flag"></i> 省份</a></li>
                <li role="presentation" class="@if($tab == 'city') selected @endif"><a href="{{ url('/visual?tab=city') }}"><i class="  icon-book"></i> 地区</a></li>
                {{--<li role="presentation" class="@if($tab == 'other') selected @endif"><a href="{{ url('/visual?tab=other') }}"><i class="icon-bookmark"></i> 其它</a></li>--}}
            </ul>
        </div>
        <div class="col-md-10" style="border-left: 1px solid silver">
            @section('visual-content')
            @show
        </div>
    </div>
@endsection