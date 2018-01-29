@extends('layouts.main')
@section('title', '数据排行')
@section('content')
    <div class="row rank-desc">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <h1>国内城市排行</h1>
            <em>*数据最后更新于 2018-01-20 12:02</em>
        </div>
        <div class="col-md-1"></div>
    </div>
    <div class="row rank-classify">
        <div class="col-md-1">
        </div>
        <div class="col-md-10 col-xs-12">
            <ul class="nav nav-pills nav-justified">
                <li role="presentation" class="selected"><a href="index.html"><i class="icon-fire"></i> 实时排行</a></li>
                <li role="presentation"><a href="#"><i class=" icon-flag"></i> 昨日排行</a></li>
                <li role="presentation"><a href="#"><i class="  icon-book"></i> 近7日排行</a></li>
                <li role="presentation" class=""><a href="rank.html"><i class="icon-bookmark"></i> 上月排行</a></li>
                <li role="presentation"><a href="#"><i class=" icon-lemon"></i> 自选日期</a></li>
            </ul>
        </div>
        <div class="col-md-1">
        </div>
    </div>
    <div class="row rank-content">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <table class="table table-hover text-center">
                <tr class="table-head">
                    <td>#</td>
                    <td>地区</td>
                    <td>AQI</td>
                    <td>PM25浓度(μg/m³)</td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>铜仁地区</td>
                    <td>79</td>
                    <td>32</td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>铜仁地区</td>
                    <td>79</td>
                    <td>32</td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>铜仁地区</td>
                    <td>79</td>
                    <td>32</td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>铜仁地区</td>
                    <td>79</td>
                    <td>32</td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>铜仁地区</td>
                    <td>79</td>
                    <td>32</td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>铜仁地区</td>
                    <td>79</td>
                    <td>32</td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>铜仁地区</td>
                    <td>79</td>
                    <td>32</td>
                </tr>
            </table>
        </div>
        <div class="col-md-1"></div>
    </div>
@endsection
@section('script')
@endsection