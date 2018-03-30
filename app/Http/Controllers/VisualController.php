<?php

namespace App\Http\Controllers;

use App\Areas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;

class VisualController extends Controller
{
    /*
      * 用户真实ip
      */
    private $ip = [];
    /*
     * 用户所在地区
     * String
     */
    private $my_area = '';

    //
    public function index(Request $request)
    {
        $this->setArea($request);
        $tab = $request->get('tab') ? $request->get('tab') : 'country';
        if (!in_array($tab, ['country', 'province', 'city', 'other'])) abort(404, '无此tab');
//        dd($request->get('kk'));
        $provinces = ['北京', '天津', '河北', '山西', '内蒙古', '辽宁', '吉林', '黑龙江', '上海', '江苏', '浙江', '安徽', '福建', '江西', '山东', '河南', '湖北', '湖南', '广东', '广西', '海南', '重庆', '四川', '贵州', '云南', '西藏', '陕西', '甘肃', '青海', '宁夏', '新疆', '台湾', '香港', '澳门'];
        $data = [
            'nav' => 'visual',
            'area' => $this->my_area,
            'tab' => $tab,
            'provinces' => $provinces,
            'province_js' => asset("js/province/jiangxi.js")
        ];
        return view('main.visual.' . $tab, $data);
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
}
