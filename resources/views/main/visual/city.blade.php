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
    <div id="data-number" style="height: 300px; border-top: 1px solid silver;">

    </div>
    <div id="data-range" style="height: 500px;margin-top: 10px;border-top: 1px solid silver;">

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
                text: '2017-03-01空气质量(平均)',
                subtext: '',

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
                    center: ['35%', '40%'],
                    startAngle: 225,
                    color: [new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                        offset: 0,
                        color: '#9BCD9B'
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
                    center: ['60%', '40%'],
                    startAngle: 225,
                    color: [new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                        offset: 0,
                        color: '#9AC0CD'
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
    <script>

        var data_range = echarts.init(document.getElementById('data-range'));
        var colors = ['#5793f3', '#d14a61', '#675bba'];
        option = {
            title: {
                text: '2017-03-01详细',
                subtext: '',
            },
            color: colors,

            tooltip: {
                trigger: 'axis',
                axisPointer: {type: 'cross'}
            },
            grid: {
                right: '20%'
            },
            toolbox: {
                feature: {
                    dataView: {show: true, readOnly: false},
                    restore: {show: true},
                    saveAsImage: {show: true}
                }
            },
            legend: {
                data:['aqi','pm25','平均']
            },
            xAxis: [
                {
                    type: 'category',
                    axisTick: {
                        alignWithLabel: true
                    },
                    data: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月']
                }
            ],
            yAxis: [
                {
                    type: 'value',
                    name: 'aqi',
                    min: 0,
                    max: 250,
                    position: 'right',
                    axisLine: {
                        lineStyle: {
                            color: colors[0]
                        }
                    },
                    axisLabel: {
                        formatter: '{value}'
                    }
                },
                {
                    type: 'value',
                    name: 'pm25',
                    min: 0,
                    max: 250,
                    position: 'right',
                    offset: 80,
                    axisLine: {
                        lineStyle: {
                            color: colors[1]
                        }
                    },
                    axisLabel: {
                        formatter: '{value} μg/m³'
                    }
                },
                {
                    type: 'value',
                    name: '平均',
                    min: 0,
                    max: 25,
                    position: 'left',
                    axisLine: {
                        lineStyle: {
                            color: colors[2]
                        }
                    },
                    axisLabel: {
                        formatter: '{value}'
                    }
                }
            ],
            series: [
                {
                    name:'aqi',
                    type:'bar',
                    data:[2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0, 6.4, 3.3]
                },
                {
                    name:'pm25',
                    type:'bar',
                    yAxisIndex: 1,
                    data:[2.6, 5.9, 9.0, 26.4, 28.7, 70.7, 175.6, 182.2, 48.7, 18.8, 6.0, 2.3]
                },
                {
                    name:'平均',
                    type:'line',
                    yAxisIndex: 2,
                    data:[2.0, 2.2, 3.3, 4.5, 6.3, 10.2, 20.3, 23.4, 23.0, 16.5, 12.0, 6.2]
                }
            ]
        };
        data_range.setOption(option)
    </script>
@endsection