<?php
/**
 * Created by PhpStorm.
 * User: syw
 * Date: 18-1-28
 * Time: 下午9:53
 * 公共函数库
 */
function getAddr($ip)
{
    $host = "http://saip.market.alicloudapi.com";
    $path = "/ip";
    $method = "GET";
    $appcode = "50877461394c49ea89733c51498af352";
    $headers = array();
    array_push($headers, "Authorization:APPCODE " . $appcode);
    $querys = 'ip=' . $ip;
    $bodys = "";
    $url = $host . $path . "?" . $querys;


    $curl = curl_init();
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_FAILONERROR, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, false);
    if (1 == strpos("$" . $host, "https://")) {
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    }
    $content = json_decode(curl_exec($curl), true);
    return isset($content['showapi_res_body']['city']) ? $content['showapi_res_body']['city'] : '南京';
}

function pm25_detail($city)
{
    $host = "https://ali-pm25.showapi.com";
    $path = "/pm25-detail";
    $method = "GET";
    $appcode = "50877461394c49ea89733c51498af352";
    $headers = array();
    array_push($headers, "Authorization:APPCODE " . $appcode);
    $querys = "city=$city";
    $url = $host . $path . "?" . $querys;

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_FAILONERROR, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, false);
    if (1 == strpos("$" . $host, "https://")) {
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    }
    $content = json_decode(curl_exec($curl), true);
    if (!$content) return false;
    $data = [
        'area' => $content['showapi_res_body']['pm']['area'],
        'pm25' => $content['showapi_res_body']['pm']['pm2_5'],
        'aqi' => $content['showapi_res_body']['pm']['aqi'],
        'rank' => $content['showapi_res_body']['pm']['num'] / 373 * 100,
        'sites' => [],
        'last_up' => date('Y-m-d H:i:s', strtotime($content['showapi_res_body']['pm']['ct']))
    ];
    foreach ($content['showapi_res_body']['siteList'] as $row) {
        if (is_numeric($row['pm2_5'])) {
            $data['sites'][] = [
                'name' => $row['site_name'],
                'pm25' => $row['pm2_5']
            ];
        }
    }
    return $data;
}

/*
 * @param now int 现在的小时数
 * return array 过去24小时的数组
 */
function getPast24hour($now)
{
    if (!strtotime($now)) return false;
    $data = [];
    $i = 24;
    while ($i != 0) {
        $data[] = date('YmdH', strtotime("-{$i} hour", strtotime($now)));
        $i--;
    }
    var_dump($data);
}

function pm25_top()
{
    $host = "https://ali-pm25.showapi.com";
    $path = "/pm25-top";
    $method = "GET";
    $appcode = "50877461394c49ea89733c51498af352";
    $headers = array();
    array_push($headers, "Authorization:APPCODE " . $appcode);
    $url = $host . $path;

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_FAILONERROR, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, false);
    if (1 == strpos("$" . $host, "https://")) {
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    }
    $data = [];
    $content = json_decode(curl_exec($curl), true);
    if ($content) {
        foreach ($content['showapi_res_body']['list'] as $row) {
            $data[] = [
                'num' => $row['num'],
                'area' => $row['area'],
                'pm25' => $row['pm2_5'],
                'aqi' => $row['aqi']
            ];
        }
    }
    return $data;
}