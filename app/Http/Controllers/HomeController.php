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
    /*
     * 全部地区数组
     */
    private $areas = [];
    /*
     * 用户所在地区
     * String
     */
    private $my_area = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $areas_obj = Areas::all();
        foreach ($areas_obj as $row) {
            $this->areas[] = $row->name;
        }

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /*地区*/
        if (Cookie::has('area')) {
            $this->my_area = Cookie::get('area');
            //dd($this->my_area);
        } else {
            $request->setTrustedProxies(array('10.32.0.1/16'));
            $this->ip = $request->getClientIp();
            $this->my_area = getAddr($this->ip);
            foreach ($this->areas as $area) {
                if (mb_strrpos($area, $this->my_area) !== false) {
                    Cookie::queue('area', $this->my_area, 24 * 60 * 10);
                } else {
                    Cookie::queue('area', '南京', 24 * 60 * 10);
                }
            }
        }

        /*获取pm25详细数据*/
        $pm25_details = pm25_detail($this->my_area);
        if (!$pm25_details) {
            abort(504, '抱歉，请求超时<a href="' . url('/') . '" style="color: #1b6d85">重新刷新</a>');
        }

        /*获取最近24小时pm25以及aqi数据*/
        $today = '2017-09-01';
        $hour = 13;
        $recent_24_data = Data::where('day', '<', $today)->where('hour', '<', $hour)->where('area', $this->my_area)->orderBy('day', 'desc')->take(24)->get()->toArray();

        $data = [
            'nav' => 'home',
            'area' => $this->my_area,
            'pm25_details' => $pm25_details,
            'sites_name_list' => array_column($pm25_details['sites'], 'name'),
            'sites_pm25_list' => array_column($pm25_details['sites'], 'pm25'),
            'recent_24_list' => array_reverse(array_column($recent_24_data, 'hour')),
            'recent_24_aqi' => array_reverse(array_column($recent_24_data, 'aqi')),
            'recent_24_pm25' => array_reverse(array_column($recent_24_data, 'pm25')),
        ];

        //dd(Cookie::get('area'));
        return view('main.home', $data);
    }

    /*
     * 更改地区
     */
    public function changeArea(Request $request)
    {
        $sub_area = $request->area;
        foreach ($this->areas as $area) {
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
}
