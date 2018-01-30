<?php

namespace App\Http\Controllers;

use App\Areas;
use App\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class RankController extends Controller
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

    private $rank_types = ['now', 'yesterday', '7day', 'last_month'];
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

    //
    public function index(Request $request)
    {
        if (Cookie::has('area')) {
            $this->my_area = Cookie::get('area');
            //dd($this->my_area);
        } else {
            $request->setTrustedProxies(array('10.32.0.1/16'));
            $this->ip = $request->getClientIp();
            $this->my_area = getAddr($this->ip);
            Cookie::queue('area', $this->my_area, 24 * 60 * 10);
        }

        $type = $this->checkType($request->route('type'));
        $rank_data = $this->getRankData($type);
        $data = [
            'nav' => 'rank',
            'type' => $type,
            'rank_info' => $rank_data[0],
            'rank_time' => $rank_data[1],
            'area' => $this->my_area
        ];
        return view('main.rank', $data);
    }

    private function checkType($type)
    {
        if ($type === null) {//没有参数则为默认为实时
            return 'now';
        } elseif (in_array($type, $this->rank_types) || (strtotime($type) !== false && strpos($type, '-') != strrpos($type, '-'))) {
            return $type;
        } else {
            //出错
            abort(404, '此链接不存在！');
            die();
        }
    }

    private function getRankData($type)
    {
        $data = [];
        if ($type == 'now') {
             return [pm25_top(), '最后更新于:' . date('Y-m-d H:i:s')];
        } else if ($type == 'yesterday') {
            $yesterday = '2017-08-23';
            $res = Data::where('day', $yesterday)->groupBy('area')->orderBy('aqi')->get([
                'area',
                DB::raw('avg(pm25) as pm25'),
                DB::raw('avg(aqi) as aqi'),
            ])->toArray();
            $data = [$res, '以下数据为' . $yesterday . '当天的平均值'];
        } else if ($type == '7day') {
            $today = '2017-09-01';
            $pre_7_day = date('Y-m-d', strtotime('-7 day', strtotime($today)));
            $res = Data::where('day', '<=', $today)->where('day', '>=', $pre_7_day)->groupBy('area')->orderBy('aqi')->get([
                'area',
                DB::raw('avg(pm25) as pm25'),
                DB::raw('avg(aqi) as aqi'),
            ])->toArray();
            $data = [$res, '区间:' . $pre_7_day . '至' . $today];
        } else if ($type == 'last_month') {
            $today = '2017-09-01';
            $last_month_start = date('Y-m-01', strtotime('-1 month', strtotime($today)));
            $last_month_end = date('Y-m-d', strtotime('+1 month -1 day', strtotime($last_month_start)));

            $res = Data::where('day', '<=', $last_month_end)->where('day', '>=', $last_month_start)->groupBy('area')->orderBy('aqi')->get([
                'area',
                DB::raw('avg(pm25) as pm25'),
                DB::raw('avg(aqi) as aqi'),
            ])->toArray();
            $data = [$res, '区间:' . $last_month_start . '至' . $last_month_end];
        } else {//具体日期
            $res = Data::where('day', $type)->groupBy('area')->orderBy('aqi')->get([
                'area',
                DB::raw('avg(pm25) as pm25'),
                DB::raw('avg(aqi) as aqi'),
            ])->toArray();
            $data = [$res, '选择的日期为:' . $type];
        }
        //添加排名
        for ($i = 0; $i < count($data[0]); $i++) {
            $data[0][$i]['num'] = $i + 1;
        }
        return $data;
    }
}
