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
                <li role="presentation" class="@if($type == 'now') selected @endif"><a href="{{ url('rank') }}"><i class="icon-fire"></i> 实时排行</a></li>
                <li role="presentation" class="@if($type == 'yesterday') selected @endif"><a href="{{ url('rank/yesterday') }}"><i class=" icon-flag"></i> 昨日排行</a></li>
                <li role="presentation" class="@if($type == '7day') selected @endif"><a href="{{ url('rank/7day') }}"><i class="  icon-book"></i> 近7日排行</a></li>
                <li role="presentation" class="@if($type == 'last_month') selected @endif"><a href="{{ url('rank/last_month') }}"><i class="icon-bookmark"></i> 上月排行</a></li>
                <li role="presentation" class="@if(strpos($type, '-')) selected @endif"><a href="{{ url("rank/" . date('Y-m-d', strtotime('-1 day'))) }}"><i class="icon-lemon"></i> 自选日期</a></li>
            </ul>
        </div>
        <div class="col-md-1">
        </div>
    </div>
    @if (strpos($type, '-'))
        <div class="row input-append date form_datetime">
            <div class="col-md-1"></div>
            <div class="col-md-10 ">
                <input size="16" id="form_datetime_input" type="text" value="{{ $type }}" readonly>
                <span class="add-on"><i class="icon-th"></i></span>
                <button class="sub-choose-date">GO!</button>
            </div>
            <div class="col-md-1"></div>
        </div>
    @endif
    <div class="row rank-time" style="margin-top: 5px">
        <div class="col-md-1">
        </div>
        <div class="col-md-10 col-xs-12">
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <em>{{ $rank_time }}</em>
            </div>
        </div>
        <div class="col-md-1">
        </div>
    </div>
    <div class="row rank-content">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            @if ($rank_info)
                <table class="table table-hover text-center">
                    <tr class="table-head">
                        <td>#</td>
                        <td>地区</td>
                        <td>AQI</td>
                        <td>PM25浓度(μg/m³)</td>
                    </tr>
                    @foreach ($rank_info as $row)
                        <tr>
                            <td>{{ $row['num'] }}</td>
                            <td>{{ $row['area'] }}</td>
                            <td>{{ $row['aqi'] }}</td>
                            <td>{{ $row['pm25'] }}</td>
                        </tr>
                    @endforeach
                </table>
            @else
               <div style="text-align: center">
                   <h3>无记录！</h3>
               </div>
            @endif

        </div>
        <div class="col-md-1"></div>
    </div>
@endsection
@section('script')
    <script>
        $(".form_datetime").datetimepicker({
            format: "yyyy-mm-dd",
            minView: 2,
            autoclose: true
        });
        $('.sub-choose-date').click(function () {
            var day = $('#form_datetime_input').val();
            if (day == '') {
                alert('您还没选择日期呢！');
                return false;
            }
            location.href = '{{ url('rank') }}' + '/' + day;
        })
    </script>

@endsection