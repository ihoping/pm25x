@extends('layouts.visual')
@section('title', '可视化省份')
@section('visual-content')
    <div class="date-select">
        省份选择:
        <select class="base-select">
            @foreach($provinces as $province)
                <option value="{{ $province }}">{{ $province }}</option>
            @endforeach
        </select>
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

    <div id="province-map" style="height: 700px;border-top: 1px solid silver;">

    </div>
    <div id="province-rank" style="height: 700px;margin-top: 10px;border-top: 1px solid silver;">

    </div>
@endsection
@section('script')
    <script src="{{ asset('js/geo.js') }}"></script>
    <script src="{{ $province_js }}"></script>
    <script>
        var province_map = echarts.init(document.getElementById('province-map'));
        var geoCoordMap = {};
        var data = [
            {name: '南京市', value: 199},
            // {name: '吉安市', value: 39},
            // {name: '上饶市', value: 152},
            // {name: '九江市', value: 299},
            // {name: '抚州市', value: 89},
            // {name: '宜春市', value: 52},
            // {name: '南昌市', value: 9},
            // {name: '景德镇市', value: 352},
            // {name: '萍乡市', value: 99},
            // {name: '鹰潭市', value: 39},
            // {name: '新余市', value: 480},
        ];
        var toolTipData = [
            {name:"南京市",value:[{name:"pm25",value:199},{name:"aqi",value:199}]},
            // {name:"南昌市",value:[{name:"pm25",value:132},{name:"aqi",value:123}]},
            // {name:"吉安市",value:[{name:"pm25",value:19},{name:"aqi",value:99}]},
        ];
        var max = 480, min = 9; // todo
        var maxSize4Pin = 100, minSize4Pin = 20;

        var convertData = function (data) {
            var res = [];
            for (var i = 0; i < data.length; i++) {
                var geoCoord = geoCoordMap[data[i].name];
                if (geoCoord) {
                    res.push({
                        name: data[i].name,
                        value: geoCoord.concat(data[i].value)
                    });
                }
            }
            return res;
        };

        province_map.showLoading();
        var mapFeatures = echarts.getMap('{{ $province_name }}').geoJson.features;
        province_map.hideLoading();
        mapFeatures.forEach(function(v) {
            // 地区名称
            var name = v.properties.name;
            // 地区经纬度
            geoCoordMap[name] = v.properties.cp;

        });
        console.log(geoCoordMap);
        option = {
            title: {
                text: '2017-01-12 {{ $province_name }}空气质量总览',
                subtext: '',
                x: 'center',
            },
            tooltip: {
                trigger: 'item',
                formatter: function(params) {
                    if (typeof(params.value)[2] == "undefined") {
                        var toolTiphtml = ''
                        for(var i = 0;i<toolTipData.length;i++){
                            if(params.name==toolTipData[i].name){
                                toolTiphtml += toolTipData[i].name+':<br>'
                                for(var j = 0;j<toolTipData[i].value.length;j++){
                                    toolTiphtml+=toolTipData[i].value[j].name+':'+toolTipData[i].value[j].value+"<br>"
                                }
                            }
                        }
                        console.log(toolTiphtml)
                        // console.log(convertData(data))
                        return toolTiphtml;
                    } else {
                        var toolTiphtml = ''
                        for(var i = 0;i<toolTipData.length;i++){
                            if(params.name==toolTipData[i].name){
                                toolTiphtml += toolTipData[i].name+':<br>'
                                for(var j = 0;j<toolTipData[i].value.length;j++){
                                    toolTiphtml+=toolTipData[i].value[j].name+':'+toolTipData[i].value[j].value+"<br>"
                                }
                            }
                        }
                        console.log(toolTiphtml)
                        // console.log(convertData(data))
                        return toolTiphtml;
                    }
                }
            },
            legend: {
                orient: 'vertical',
                y: 'bottom',
                x: 'right',
                data: ['credit_pm2.5'],
                textStyle: {
                    color: '#fff'
                }
            },
            visualMap: {
                show: true,
                min: 0,
                max: 500,
                left: 'left',
                top: 'bottom',
                text: ['高', '低'], // 文本，默认为数值文本
                calculable: true,
                seriesIndex: [1],
                inRange: {
                    // color: ['#3B5077', '#031525'] // 蓝黑
                    // color: ['#ffc0cb', '#800080'] // 红紫
                    // color: ['#3C3B3F', '#605C3C'] // 黑绿
                    // color: ['#0f0c29', '#302b63', '#24243e'] // 黑紫黑
                    // color: ['#23074d', '#cc5333'] // 紫红
                    color: ['#00467F', '#A5CC82'] // 蓝绿
                    // color: ['#1488CC', '#2B32B2'] // 浅蓝
                    // color: ['#00467F', '#A5CC82'] // 蓝绿
                    // color: ['#00467F', '#A5CC82'] // 蓝绿
                    // color: ['#00467F', '#A5CC82'] // 蓝绿
                    // color: ['#00467F', '#A5CC82'] // 蓝绿

                }
            },
            // toolbox: {
            //     show: true,
            //     orient: 'vertical',
            //     left: 'right',
            //     top: 'center',
            //     feature: {
            //             dataView: {readOnly: false},
            //             restore: {},
            //             saveAsImage: {}
            //             }
            // },
            geo: {
                show: true,
                map: '{{ $province_name }}',
                label: {
                    normal: {
                        show: false
                    },
                    emphasis: {
                        show: false,
                    }
                },
                roam: false,
                itemStyle: {
                    normal: {
                        areaColor: '#031525',
                        borderColor: '#3B5077',
                    },
                    emphasis: {
                        areaColor: '#2B91B7',
                    }
                }
            },
            series: [{
                name: '散点',
                type: 'scatter',
                coordinateSystem: 'geo',
                data: convertData(data),
                symbolSize: function(val) {
                    return val[2] / 10;
                },
                label: {
                    normal: {
                        formatter: '{b}',
                        position: 'right',
                        show: true
                    },
                    emphasis: {
                        show: true
                    }
                },
                itemStyle: {
                    normal: {
                        color: '#05C3F9'
                    }
                }
            },
                {
                    type: 'map',
                    map: '{{ $province_name }}',
                    geoIndex: 0,
                    aspectScale: 0.75, //长宽比
                    showLegendSymbol: false, // 存在legend时显示
                    label: {
                        normal: {
                            show: true
                        },
                        emphasis: {
                            show: false,
                            textStyle: {
                                color: '#fff'
                            }
                        }
                    },
                    roam: true,
                    itemStyle: {
                        normal: {
                            areaColor: '#031525',
                            borderColor: '#3B5077',
                        },
                        emphasis: {
                            areaColor: '#2B91B7'
                        }
                    },
                    animation: false,
                    data: data
                },
                {
                    name: '点',
                    type: 'scatter',
                    coordinateSystem: 'geo',
                    symbol: 'pin', //气泡
                    symbolSize: function(val) {
                        var a = (maxSize4Pin - minSize4Pin) / (max - min);
                        var b = minSize4Pin - a * min;
                        b = maxSize4Pin - a * max;
                        return a * val[2] + b;
                    },
                    label: {
                        normal: {
                            show: true,
                            textStyle: {
                                color: '#fff',
                                fontSize: 9,
                            }
                        }
                    },
                    itemStyle: {
                        normal: {
                            color: '#F62157', //标志颜色
                        }
                    },
                    zlevel: 6,
                    data: convertData(data),
                },
                {
                    name: 'Top 5',
                    type: 'effectScatter',
                    coordinateSystem: 'geo',
                    data: convertData(data.sort(function(a, b) {
                        return b.value - a.value;
                    }).slice(0, 5)),
                    symbolSize: function(val) {
                        return val[2] / 10;
                    },
                    showEffectOn: 'render',
                    rippleEffect: {
                        brushType: 'stroke'
                    },
                    hoverAnimation: true,
                    label: {
                        normal: {
                            formatter: '{b}',
                            position: 'right',
                            show: true
                        }
                    },
                    itemStyle: {
                        normal: {
                            color: 'yellow',
                            shadowBlur: 10,
                            shadowColor: 'yellow'
                        }
                    },
                    zlevel: 1
                },
            ]
        };

        province_map.setOption(option)
    </script>
    <script>
        var province_rank = echarts.init(document.getElementById('province-rank'));
        var option = {
            title : {
                text: '2018年空气质量排行',
                subtext: ''
            },
            tooltip : {
                trigger: 'axis'
            },
            legend: {
                data:['aqi','pm25']
            },
            toolbox: {
                show : true,
                feature : {
                    dataView : {show: true, readOnly: false},
                    magicType : {show: true, type: ['line', 'bar']},
                    restore : {show: true},
                    saveAsImage : {show: true}
                }
            },
            calculable : true,
            xAxis : [
                {
                    type : 'category',
                    data : ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月']
                }
            ],
            yAxis : [
                {
                    type : 'value'
                }
            ],
            series : [
                {
                    name:'aqi',
                    type:'bar',
                    data:[2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0, 6.4, 3.3],
                    markPoint : {
                        data : [
                            {type : 'max', name: '最大值'},
                            {type : 'min', name: '最小值'}
                        ]
                    },
                    markLine : {
                        data : [
                            {type : 'average', name: '平均值'}
                        ]
                    }
                },
                {
                    name:'pm25',
                    type:'bar',
                    data:[2.6, 5.9, 9.0, 26.4, 28.7, 70.7, 175.6, 182.2, 48.7, 18.8, 6.0, 2.3],
                    markPoint : {
                        data : [
                            {name : '年最高', value : 182.2, xAxis: 7, yAxis: 183},
                            {name : '年最低', value : 2.3, xAxis: 11, yAxis: 3}
                        ]
                    },
                    markLine : {
                        data : [
                            {type : 'average', name : '平均值'}
                        ]
                    }
                }
            ]
        };
        province_rank.setOption(option)
    </script>
    <script>
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
            console.log(date_type)
            $("#form_datetime_input_" + date_type).show();

        });
    </script>

    <script>
        {{--var mapFeatures = echarts.getMap('{{ $province_name }}').geoJson.features;--}}
        {{--var newMap = [];--}}
        {{--mapFeatures.forEach(function(v) {--}}
            {{--newMap.push(v.properties.name);--}}
        {{--});--}}
        {{--var url = '{{ route('areaPlus') }}';--}}

        {{--console.log(newMap);--}}
        {{--$.ajax({--}}
            {{--url: url,--}}
            {{--type: 'post',--}}
            {{--dataType: 'json',--}}
            {{--data:{'data' : JSON.stringify(newMap), 'province' :'{{ $province_name }}'}--}}
        {{--}).done(function(re) {--}}
            {{--console.log(re)--}}
        {{--});--}}
    </script>
@endsection