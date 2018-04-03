<?php

namespace App\Http\Controllers;

use App\Data;
use Illuminate\Http\Request;
use App\Areas;
use Illuminate\Support\Facades\Cookie;

class HomeController extends Controller
{
    /*
       * 用户真实ip
       */
    private $ip = [];

    /**
     * 用户所在地区
     * String
     */
    private $my_area = '';

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /**
         * 设置地区
         */
        $this->setArea($request);

        /*获取pm25详细数据*/
        $pm25_details = pm25_detail($this->my_area);

        if (!$pm25_details) {//如果因为网络原因获取失败
            abort(504, '抱歉，请求超时<a href="' . url('/') . '" style="color: #1b6d85">重新刷新</a>');
        }

        /*获取最近24小时pm25以及aqi数据*/
        $recent_24_data = Data::where('area', $this->my_area)->orderBy('id', 'desc')->take(24)->get()->toArray();

        //7天预测数据
        $forecast = $this->get7days();
        $data = [
            'nav' => 'home',
            'area' => $this->my_area,
            'pm25_details' => $pm25_details,
            'sites_name_list' => array_column($pm25_details['sites'], 'name'),
            'sites_pm25_list' => array_column($pm25_details['sites'], 'pm25'),
            'recent_24_list' => array_reverse(array_column($recent_24_data, 'hour')),
            'recent_24_aqi' => array_reverse(array_column($recent_24_data, 'aqi')),
            'recent_24_pm25' => array_reverse(array_column($recent_24_data, 'pm25')),
            'forecast' => $forecast
        ];

        return view('main.home', $data);
    }

    /*
     * 更改地区
     */
    public function changeArea(Request $request)
    {
        $areas_obj = Areas::all();
        foreach ($areas_obj as $row) {
            $areas[] = $row->name;
        }

        $sub_area = $request->area;//用户提交的地区
        foreach ($areas as $area) {
            if (mb_strrpos($area, $sub_area) !== false) {
                return response()->json([
                    'area' => $area,
                    'status' => 1
                ])->cookie('area', $area, 24 * 60 * 10);
            }
        }

        return response()->json([
            'status' => 0
        ]);
    }

    /*
     * 设置地区
     */
    private function setArea(Request $request)
    {
        if (Cookie::has('area')) {//如果cookie里有地区信息了
            $this->my_area = Cookie::get('area');
            //dd($this->my_area);
        } else {//没有再去获取
            $request->setTrustedProxies(array('10.32.0.1/16'));
            $this->ip = $request->getClientIp();
            $this->my_area = getAddr($this->ip);
            $areas_obj = Areas::all();
            foreach ($areas_obj as $row) {
                $areas[] = $row->name;
            }
            foreach ($areas as $area) {
                if (mb_strrpos($area, $this->my_area) !== false) {
                    Cookie::queue('area', $this->my_area, 24 * 60 * 10);
                } else {
                    Cookie::queue('area', '南京', 24 * 60 * 10);
                }
            }
        }
    }

    /**
     * 获取未来7天的预测数据
     */
    private function get7days()
    {
        $seven_days = [];
        $today = date('Y-m-d');
        $i = 7;
        while ($i--) {
            $today = date('Y-m-d', strtotime('+1 day', strtotime($today)));
            $seven_days[0][] = $today;
            $seven_days[1][] = rand(40, 155);
            $seven_days[2][] = rand(30, 50);
        }
        return $seven_days;
    }
}
