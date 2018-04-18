@extends('layouts.visual')
@section('title', '可视化地区')
@section('visual-content')
    <div class="date-select">
        地区选择:
        <input id="city-choose" name="city" value="{{ $select_area }}" placeholder="点击选择地区">
        日期类型:
        <select class="base-select date-type-select">
            <option value="3" @if($date_type == 3) selected @endif>日</option>
            <option value="2" @if($date_type == 2) selected @endif>月</option>
            <option value="1" @if($date_type == 1) selected @endif>年</option>
        </select>
        日期选择:
        <input size="16" class="date_time_input base-select" id="form_datetime_input_3" type="text" value="{{ $date }}" readonly>
        <input size="16" class="date_time_input base-select" id="form_datetime_input_2" type="text" value="{{ date('Y-m', strtotime($date)) }}" readonly style="display: none">
        <input size="16" class="date_time_input base-select" id="form_datetime_input_1" type="text" value="{{ date('Y', strtotime($date)) }}" readonly style="display: none">
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

        $(".date_time_input").hide();
        $("#form_datetime_input_" + '{{ $date_type }}').show();
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
                text: '{{ $date }} 空气质量(平均)',
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
                                formatter: '\n{{ round($data["pm25_aqi"][0]["pm25"]) }}μg/m³',
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
                                formatter: '\n{{ round($data["pm25_aqi"][0]["aqi"]) }}',
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
        option = {
            title: {
                text: "数据走势图@if ($date_type == 3) 小时 @endif"
            },
            tooltip: {
                trigger: 'axis'
            },
            toolbox: {
                feature: {
                    dataView: {
                        show: true,
                        readOnly: false
                    },
                    restore: {
                        show: true
                    },
                    saveAsImage: {
                        show: true
                    }
                }
            },
            grid: {
                containLabel: true
            },
            legend: {
                data: ['AQI','PM25']
            },
            xAxis: [{
                type: 'category',
                axisTick: {
                    alignWithLabel: true
                },
                data: [@foreach($data['section'] as $section)
                        '{{ $section }}',
                    @endforeach]
            }],
            yAxis: [{
                type: 'value',
                name: 'AQI',
                min: 0,
                max: 500,
                position: 'right',
                axisLabel: {
                    formatter: '{value}'
                }
            }, {
                type: 'value',
                name: 'PM25',
                min: 0,
                max: '{{ round($data['pm25_max']) + 100}}',
                position: 'left',
                axisLabel: {
                    formatter: '{value}μg/m³'
                }
            }],
            series: [{
                name: 'AQI',
                type: 'line',
                stack: '总量',
                label: {
                    normal: {
                        show: true,
                        position: 'top',
                    }
                },
                lineStyle: {
                    normal: {
                        width: 3,
                        shadowColor: 'rgba(0,0,0,0.4)',
                        shadowBlur: 10,
                        shadowOffsetY: 10
                    }
                },
                data: [{{ $data['section_aqi'] }}]
            }, {
                name: 'PM25',
                type: 'bar',
                yAxisIndex: 1,
                stack: '总量',
                label: {
                    normal: {
                        show: true,
                        position: 'top'
                    }
                },
                data: [{{ $data['section_pm25'] }}]
            }]
        };
        data_range.setOption(option)
    </script>
    <script>
        $('.sub-choose-date').click(function () {
            var info = [];
            var area = $('#city-choose').val();
            info.push('area=' + area);
            if (area == '') {
                alert('您还没选择地区！');
                return false;
            }

            var check = false;
            $.ajax({
                url: "{{ route('checkArea') }}",
                type: 'post',
                async: false,
                data: {
                    area: area
                },
                success: function (response) {
                    if (response.status) {
                        check = true;
                    }
                }
            });

            if (!check) {
                alert('抱歉暂不支持该地区！请重新选择');
                return false;
            }
            var date_type = $('.date-type-select').val();
            info.push('date_type=' + date_type);
            var date = $('#form_datetime_input_' + date_type).val();
            if (date == '') {
                alert('您还没选择日期呢！');
                return false;
            }
            info.push('date=' + date);
            location.href = '{{ url('visual') }}' + '?' + info.join('&');
        })
    </script>
@endsection