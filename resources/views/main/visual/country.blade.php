@extends('layouts.visual')
@section('title', '可视化全国')
@section('visual-content')

    <div class="date-select">
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
    <div id="china-map" style="height: 700px;border-top: 1px solid silver;">

    </div>
    <div id="china-rank" style="height: 700px;margin-top: 10px;border-top: 1px solid silver;">

    </div>
@endsection
@section('script')
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
            $("#form_datetime_input_" + date_type).show();

        });
        function randomData() {
            return Math.round(Math.random() * 2500);
        }
        var china_map = echarts.init(document.getElementById('china-map'));
        var name_title = "2018年全国平均空气质量(pm25、aqi)"
        var subname = ''
        var nameColor = " rgb(55, 75, 113)"
        var name_fontFamily = '等线'
        var subname_fontSize = 15
        var name_fontSize = 18
        var mapName = 'china'
        var data = [
            {name:"北京",value:177},
            {name:"天津",value:42},
            {name:"河北",value:102},
            {name:"山西",value:81},
            {name:"内蒙古",value:47},
            {name:"辽宁",value:67},
            {name:"吉林",value:82},
            {name:"黑龙江",value:66},
            {name:"上海",value:24},
            {name:"江苏",value:92},
            {name:"浙江",value:114},
            {name:"安徽",value:109},
            {name:"福建",value:116},
            {name:"江西",value:91},
            {name:"山东",value:119},
            {name:"河南",value:137},
            {name:"湖北",value:116},
            {name:"湖南",value:114},
            {name:"重庆",value:91},
            {name:"四川",value:125},
            {name:"贵州",value:199},
            {name:"云南",value:83},
            {name:"西藏",value:9},
            {name:"陕西",value:80},
            {name:"甘肃",value:56},
            {name:"青海",value:10},
            {name:"宁夏",value:18},
            {name:"新疆",value:67},
            {name:"广东",value:123},
            {name:"广西",value:59},
            {name:"海南",value:14},
        ];

        var geoCoordMap = {};
        var toolTipData = [
            {name:"北京",value:[{name:"PM25",value:199},{name:"AQI",value:199}]},
            {name:"天津",value:[{name:"PM25",value:22},{name:"AQI",value:20}]},
            {name:"河北",value:[{name:"PM25",value:60},{name:"AQI",value:42}]},
            {name:"山西",value:[{name:"PM25",value:40},{name:"AQI",value:41}]},
            {name:"内蒙古",value:[{name:"PM25",value:23},{name:"AQI",value:24}]},
            {name:"辽宁",value:[{name:"PM25",value:39},{name:"AQI",value:28}]},
            {name:"吉林",value:[{name:"PM25",value:41},{name:"AQI",value:41}]},
            {name:"黑龙江",value:[{name:"PM25",value:35},{name:"AQI",value:31}]},
            {name:"上海",value:[{name:"PM25",value:12},{name:"AQI",value:12}]},
            {name:"江苏",value:[{name:"PM25",value:47},{name:"AQI",value:45}]},
            {name:"浙江",value:[{name:"PM25",value:57},{name:"AQI",value:57}]},
            {name:"安徽",value:[{name:"PM25",value:57},{name:"AQI",value:52}]},
            {name:"福建",value:[{name:"PM25",value:59},{name:"AQI",value:57}]},
            {name:"江西",value:[{name:"PM25",value:49},{name:"AQI",value:42}]},
            {name:"山东",value:[{name:"PM25",value:67},{name:"AQI",value:52}]},
            {name:"河南",value:[{name:"PM25",value:69},{name:"AQI",value:68}]},
            {name:"湖北",value:[{name:"PM25",value:60},{name:"AQI",value:56}]},
            {name:"湖南",value:[{name:"PM25",value:62},{name:"AQI",value:52}]},
            {name:"重庆",value:[{name:"PM25",value:47},{name:"AQI",value:44}]},
            {name:"四川",value:[{name:"PM25",value:65},{name:"AQI",value:60}]},
            {name:"贵州",value:[{name:"PM25",value:199},{name:"AQI",value:199}]},
            {name:"云南",value:[{name:"PM25",value:42},{name:"AQI",value:41}]},
            {name:"西藏",value:[{name:"PM25",value:5},{name:"AQI",value:4}]},
            {name:"陕西",value:[{name:"PM25",value:38},{name:"AQI",value:42}]},
            {name:"甘肃",value:[{name:"PM25",value:28},{name:"AQI",value:28}]},
            {name:"青海",value:[{name:"PM25",value:5},{name:"AQI",value:5}]},
            {name:"宁夏",value:[{name:"PM25",value:10},{name:"AQI",value:8}]},
            {name:"新疆",value:[{name:"PM25",value:36},{name:"AQI",value:31}]},
            {name:"广东",value:[{name:"PM25",value:63},{name:"AQI",value:60}]},
            {name:"广西",value:[{name:"PM25",value:29},{name:"AQI",value:30}]},
            {name:"海南",value:[{name:"PM25",value:8},{name:"AQI",value:6}]},
        ];

        /*获取地图数据*/
        china_map.showLoading();
        var mapFeatures = echarts.getMap(mapName).geoJson.features;
        china_map.hideLoading();
        mapFeatures.forEach(function(v) {
            // 地区名称
            var name = v.properties.name;
            // 地区经纬度
            geoCoordMap[name] = v.properties.cp;

        });

        // console.log("============geoCoordMap===================")
        // console.log(geoCoordMap)
        // console.log("================data======================")
        // console.log(data)
        // console.log(toolTipData)
        var max = 480,
            min = 9; // todo
        var maxSize4Pin = 100,
            minSize4Pin = 20;

        var convertData = function(data) {
            var res = [];
            for (var i = 0; i < data.length; i++) {
                var geoCoord = geoCoordMap[data[i].name];
                if (geoCoord) {
                    res.push({
                        name: data[i].name,
                        value: geoCoord.concat(data[i].value),
                    });
                }
            }
            return res;
        };
        option = {
            title: {
                text: name_title,
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
            // legend: {
            //     orient: 'vertical',
            //     y: 'bottom',
            //     x: 'right',
            //     data: ['credit_pm2.5'],
            //     textStyle: {
            //         color: '#fff'
            //     }
            // },
            visualMap: {
                show: true,
                min: 0,
                max: 200,
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
                    // color: ['#00467F', '#A5CC82'] // 蓝绿
                    // color: ['#1488CC', '#2B32B2'] // 浅蓝
                    // color: ['#00467F', '#A5CC82'] // 蓝绿
                    // color: ['#00467F', '#A5CC82'] // 蓝绿
                    color: ['#A5CC82', '#00467F'] // 蓝绿
                    // color: ['#A5CC82', '#cc5333'] // 蓝绿
                    // color: ['#00467F', '#A5CC82'] // 蓝绿

                }
            },

            geo: {
                show: true,
                map: mapName,
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
                    map: mapName,
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
        }
        china_map.setOption(option);
    </script>
    <script>
        var china_rank = echarts.init(document.getElementById('china-rank'));
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
        china_rank.setOption(option)
    </script>
@endsection