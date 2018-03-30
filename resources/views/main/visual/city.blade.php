@extends('layouts.visual')
@section('title', '可视化地区')
@section('visual-content')
    <div class="date-select">
        地区选择:
        <input id="city-choose" name="city" placeholder="点击选择地区">
        日期类型:
        <select class="base-select date-type-select">
            <option value="3">日</option>
            <option value="2">月</option>
            <option value="1">年</option>
        </select>
        日期选择:
        <input size="16" class="date_time_input base-select" id="form_datetime_input_3" type="text" value="" readonly>
        <input size="16" class="date_time_input base-select" id="form_datetime_input_2" type="text" value="" readonly style="display: none">
        <input size="16" class="date_time_input base-select" id="form_datetime_input_1" type="text" value="" readonly style="display: none">
        <button class="sub-choose-date">GO!</button>
    </div>
    <div id="data-number" style="height: 300px">

    </div>
@endsection
@section('script')
    <script>
        $('#city-choose').kuCity();
        $("#form_datetime_input_3").datetimepicker({
            format: "yyyy-mm-dd",
            minView: 2,
            autoclose: true
        });
        $("#form_datetime_input_2").datetimepicker({
            format: "yyyy-mm",
            minView: 3,
            startView: '3',
            autoclose: true
        });
        $("#form_datetime_input_1").datetimepicker({
            format: "yyyy",
            minView: 4,
            startView: '4',
            autoclose: true
        });

        $(".date-type-select").change(function () {
            $(".date_time_input").hide();
            var date_type = $(".date-type-select").val();
            $("#form_datetime_input_" + date_type).show();

        });
    </script>
    <script>
        var data_number = echarts.init(document.getElementById('data-number'));
        var option = {
            title: {
                text: '2017-10-28 空气质量信息',
                subtext: subname,
                x: 'center',
                textStyle: {
                    color: nameColor,
                    fontFamily: name_fontFamily,
                    fontSize: name_fontSize
                },
                subtextStyle:{
                    fontSize:subname_fontSize,
                    fontFamily:name_fontFamily
                }
            },
            tooltip: {
                "trigger": 'item',
                "formatter": "{a} : ({d}%)"
            },
            series: [
                {
                    name: 'PM25浓度',
                    type: 'pie',
                    radius: ['40%', '45%'],
                    center: ['15%', '40%'],
                    startAngle: 225,
                    color: [new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                        offset: 0,
                        color: '#777'
                    },]), "transparent"],
                    labelLine: {
                        normal: {
                            show: false
                        }
                    },
                    label: {
                        normal: {
                            position: 'center'
                        }
                    },
                    data: [{
                        value: 75,
                        name: 'PM25浓度',
                        label: {
                            normal: {
                                formatter: 'PM25浓度',
                                textStyle: {
                                    color: '#777',
                                    fontSize: 16
                                }
                            }
                        }
                    }, {
                        value: 25,
                        name: '%',
                        label: {
                            normal: {
                                formatter: '\n19μg/m³',
                                textStyle: {
                                    color: '#777',
                                    fontSize: 20

                                }
                            }
                        }
                    },
                    ]
                },
                {
                    name: ' AQI指数',
                    type: 'pie',
                    radius: ['40%', '45%'],
                    center: ['45%', '40%'],
                    startAngle: 225,
                    color: [new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                        offset: 0,
                        color: '#777'
                    }]), "transparent"],
                    labelLine: {
                        normal: {
                            show: false
                        }
                    },
                    label: {
                        normal: {
                            position: 'center'
                        }
                    },
                    data: [{
                        value: 75,
                        name: 'AQI指数',
                        label: {
                            normal: {
                                formatter: 'AQI指数',
                                textStyle: {
                                    color: '#777',
                                    fontSize: 16

                                }
                            }
                        }
                    }, {
                        value: 25,
                        name: '%',
                        label: {
                            normal: {
                                formatter: '\n77',
                                textStyle: {
                                    color: '#777',
                                    fontSize: 20

                                }
                            }
                        }
                    },
                    ]
                },
            ]
        };
        data_number.setOption(option);
    </script>
@endsection