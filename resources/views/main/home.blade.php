@extends('layouts.main')
@section('title', '首页')
@section('content')
    <div class="row content">
        <div class="col-md-6 address-number">
            <p><i class="icon-map-marker"></i> {{ $pm25_details['area'] }}</p>
            <div id="data-number" style="height: 300px"></div>
            <p><strong>温馨提示：</strong><span class="note">空气质量可接受，但某些污染物可能对极少异常敏感人群健康有较弱影响。极少数异常敏感人群减少户外活动</span></p>

        </div>
        <div class="col-md-6 sites">
            <div id="sites-list" style="height: 350px"></div>
        </div>
        <div class="update-time">*数据最后更新于 {{ $pm25_details['last_up'] }}</div>
    </div>
    <div class="row chart2">
        <div class="col-md-1">

        </div>
        <div class="col-md-10">
            <div id="forecast" style="width: auto;height:400px;"></div>
        </div>
        <div class="col-md-1>"></div>
    </div>
    <div class="row chart1">
        <div class="col-md-1">

        </div>
        <div class="col-md-10">
            <div id="data-24h" style="width: auto;height:400px;"></div>
        </div>
        <div class="col-md-1>"></div>
    </div>
@endsection
@section('script')
    <script>
        var aqi = '{{ $pm25_details['aqi'] }}';
        if (aqi >=0 && aqi <= 50) {
            $('.note').text('空气质量令人满意，基本无空气污染')
        } else if (aqi >=51 && aqi <= 100) {
            $('.note').text('空气质量可接受，但某些污染物可能对极少数异常敏感人群健康有较弱影响')
        } else if (aqi >=101 && aqi <= 150) {
            $('.note').text('易感人群症状有轻度加剧，健康人群出现刺激症状')
        } else if (aqi >=151 && aqi <= 200) {
            $('.note').text('进一步加剧易感人群症状，可能对健康人群心脏、呼吸系统有影响')
        } else if (aqi >=201 && aqi <= 300) {
            $('.note').text('心脏病和肺病患者症状显著加剧，运动耐受力降低，健康人群普遍出现症状')
        }else if (aqi > 300) {
            $('.note').text('健康人群运动耐受力降低，有明显强烈症状，提前出现某些疾病')
        }
    </script>
    <script type="text/javascript">
        // 基于准备好的dom，初始化echarts实例
        var data_24h = echarts.init(document.getElementById('data-24h'));

        // 指定图表的配置项和数据
        option = {
            toolbox: {
                show: true,
                feature: {
                    dataZoom: {},
                    dataView: {readOnly: false},
                    magicType: {type: ['line', 'bar']},
                    restore: {},
                    saveAsImage: {}
                }
            },
            title: {
                text: '最近24个小时的AQI系数与PM25浓度趋势图',
                left: '50%',
                textAlign: 'center'
            },
            tooltip: {
                trigger: 'axis',
                axisPointer: {
                    lineStyle: {
                        color: '#ddd'
                    }
                },
                backgroundColor: 'rgba(255,255,255,1)',
                padding: [5, 10],
                textStyle: {
                    color: '#7588E4',
                },
                extraCssText: 'box-shadow: 0 0 5px rgba(0,0,0,0.3)'
            },
            legend: {
                left: 50,
                orient: 'vertical',
                data: ['AQI', 'PM25']
            },
            xAxis: {
                type: 'category',
                data: [
                    {{ implode(',', $recent_24_list) }}
                ],
                boundaryGap: false,
                splitLine: {
                    show: true,
                    interval: 'auto',
                    lineStyle: {
                        color: ['#D4DFF5']
                    }
                },
                axisTick: {
                    show: false
                },
                axisLine: {
                    lineStyle: {
                        color: '#609ee9'
                    }
                },
                axisLabel: {
                    margin: 10,
                    textStyle: {
                        fontSize: 14
                    }
                }
            },
            yAxis: {
                type: 'value',
                splitLine: {
                    lineStyle: {
                        color: ['#D4DFF5']
                    }
                },
                axisTick: {
                    show: false
                },
                axisLine: {
                    lineStyle: {
                        color: '#609ee9'
                    }
                },
                axisLabel: {
                    margin: 10,
                    textStyle: {
                        fontSize: 14
                    }
                }
            },
            series: [{
                name: 'AQI',
                type: 'line',
                smooth: true,
                showSymbol: false,
                symbol: 'circle',
                symbolSize: 6,
                data: [
                    {{ implode(',', $recent_24_aqi) }}
                ],
                areaStyle: {
                    normal: {
                        color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                            offset: 0,
                            color: 'rgba(199, 237, 250,0.5)'
                        }, {
                            offset: 1,
                            color: 'rgba(199, 237, 250,0.2)'
                        }], false)
                    }
                },
                itemStyle: {
                    normal: {
                        color: '#f7b851'
                    }
                },
                lineStyle: {
                    normal: {
                        width: 3
                    }
                }
            }, {
                name: 'PM25',
                type: 'line',
                smooth: true,
                showSymbol: false,
                symbol: 'circle',
                symbolSize: 6,
                data: [
                    {{ implode(',', $recent_24_pm25) }}
                ],
                areaStyle: {
                    normal: {
                        color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                            offset: 0,
                            color: 'rgba(216, 244, 247,1)'
                        }, {
                            offset: 1,
                            color: 'rgba(216, 244, 247,1)'
                        }], false)
                    }
                },
                itemStyle: {
                    normal: {
                        color: '#58c8da'
                    }
                },
                lineStyle: {
                    normal: {
                        width: 3
                    }
                }
            }]
        };

        // 使用刚指定的配置项和数据显示图表。
        data_24h.setOption(option);
    </script>
    <script>
        var forecast = echarts.init(document.getElementById('forecast'));
        option = {
            title: {
                text: '未来12个小时PM25浓度值预测',
                subtext: '基于Python Keras+LSTM单向量时间序列预测模型',
                left: '50%',
                textAlign: 'center'
            },
            tooltip: {
                trigger: 'axis'
            },

            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            toolbox: {
                feature: {
                    saveAsImage: {}
                }
            },
            xAxis: {
                type: 'category',
                boundaryGap: false,
                data: [@foreach($forecast as $k => $v)'{{$k}}',@endforeach],
                splitLine: { //设置X轴的网格
                    show: true,
                    interval: 'auto'
                },
                axisLine: { //设置X轴的颜色
                    lineStyle: {
                        color: 'blue'
                    }
                }
            },
            yAxis: {
                type: 'value',
                axisLine: { //设置y轴的颜色
                    lineStyle: {
                        color: 'blue'
                    }
                }
            },
            series: [{
                name: '预测值',
                type: 'line',
                smooth: true, //点与点之间的幅度,false为直线
                label: { //设置点数据的提示
                    normal: {
                        show: true,
                        position: 'bottom'
                    }
                },
                data: [{{ implode(',', array_values($forecast)) }}],
                markPoint: { //设置最大值和最小值
                    data: [{
                        type: 'max',
                        name: '最大值'
                    }, {
                        type: 'min',
                        name: '最小值'
                    }]
                }

            }]
        };

        forecast.setOption(option);
        //    var option = {
        //        xAxis: [{
        //            type: 'value',
        //            scale: true
        //        }]
        //    }

    </script>
    <script>
        var data_number = echarts.init(document.getElementById('data-number'));
        var option = {
            backgroundColor: '#5F9EA0',
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
                        color: '#FFFFFF'
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
                                    color: '#fff',
                                    fontSize: 16
                                }
                            }
                        }
                    }, {
                        value: 25,
                        name: '%',
                        label: {
                            normal: {
                                formatter: '\n{{ $pm25_details['pm25'] }}μg/m³',
                                textStyle: {
                                    color: '#FFFFFF',
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
                        color: '#fff'
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
                                    color: '#fff',
                                    fontSize: 16

                                }
                            }
                        }
                    }, {
                        value: 25,
                        name: '%',
                        label: {
                            normal: {
                                formatter: '\n{{ $pm25_details['aqi'] }}',
                                textStyle: {
                                    color: '#FFFFFF',
                                    fontSize: 20

                                }
                            }
                        }
                    },
                    ]
                },
                {
                    name: '饼图二',
                    type: 'pie',
                    radius: ['40%', '45%'],
                    center: ['75%', '40%'],
                    label: {
                        normal: {
                            position: 'center'
                        }
                    },
                    data: [
                        {
                            value: 100 - '{{ $pm25_details['rank'] }}',
                            name: '占有率',
                            label: {
                                normal: {
                                    formatter: '{d} %',
                                    textStyle: {
                                        fontSize: 30
                                    }
                                }
                            }
                        },
                        {
                            value: '{{ $pm25_details['rank'] }}',
                            name: '占位',
                            label: {
                                normal: {
                                    formatter: '\n击败城市',
                                    textStyle: {
                                        color: '#555',
                                        fontSize: 15
                                    }
                                }
                            },
                            tooltip: {
                                show: false
                            },
                            itemStyle: {
                                normal: {
                                    color: '#fff'
                                },
                                emphasis: {
                                    color: '#aaa'
                                }
                            },
                            hoverAnimation: false
                        }
                    ]
                },
            ]
        };
        data_number.setOption(option);
    </script>
    <script>
        var sites_list = echarts.init(document.getElementById('sites-list'));
        var dataAll = [{{ implode(',', $sites_pm25_list) }}];
        var yAxisData = [
            @foreach ($sites_name_list as $v)
                '{{ $v }}',
            @endforeach
        ];
        var option = {
            backgroundColor: '#5F9EA0',
            grid: [
                {x: '20%'},
            ],
            title: [
                {
                    text: "各监测点数据",
                    left: '10%',
                    textStyle: {color: "#333", fontSize: "20", fontWeight: '100'},
                },
            ],
            tooltip: {
                formatter: '{b} ({c})'
            },
            xAxis: [
                {
                    gridIndex: 0,
                    axisTick: {show: false},
                    axisLabel: {show: false},
                    splitLine: {show: false},
                    axisLine: {show: false}
                },
            ],
            yAxis: [
                {
                    offset: 2,
                    gridIndex: 0, interval: 0, data: yAxisData.reverse(),
                    axisTick: {show: false}, axisLabel: {show: true}, splitLine: {show: false},
                    axisLine: {show: true, fontSize: "20", lineStyle: {color: "#4A4A4A"}},
                }
            ],
            series: [
                {
                    name: '各监测点数据',
                    type: 'bar', xAxisIndex: 0, yAxisIndex: 0, barWidth: '45%',
                    itemStyle: {normal: {color: '#fff', fontSize: '20'}},
                    label: {normal: {show: true, position: "right", textStyle: {color: "#4A4A4A"}}},
                    data: dataAll.sort(),
                },

            ]
        };
        sites_list.setOption(option);
    </script>
@endsection