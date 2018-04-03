<?php

namespace App\Http\Controllers;

use App\Areas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;
use PhpParser\Node\Expr\Array_;

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

    private $tabs = ['country', 'province', 'city', 'other'];

    //
    public function index(Request $request)
    {
        $this->setArea($request);
        $tab = $request->get('tab') ? $request->get('tab') : 'country';
        if (!in_array($tab, $this->tabs)) abort(404, '无此tab');

        $data = $this->getData($tab, $request);


        return view('main.visual.' . $tab, $data);
    }

    /**
     * 通过tab获取数据
     * @param $tab
     * @param Request $request
     * @return mixed
     *
     */
    private function getData($tab, Request $request)
    {
        $func = 'get' . ucfirst($tab) . 'data';
        $data = $this->$func($request);
        return $data;
    }

    private function getCountryData(Request $request)
    {
        $type = $request->get('type') ? $request->get('type') : 'day';
        $date = $request->get('date') ? $request->get('date') : date('Y-m-d');
        //dd($type . $date);

        $data = [
            'nav' => 'visual',
            'area' => $this->my_area,
            'tab' => 'country'
        ];
        return $data;
    }

    private function getProvinceData(Request $request)
    {
        $province_name = $request->get('province') ? $request->get('province') : '江苏';
//        dd($province);
        $provinces = ['beijing' => '北京', 'tianjin' => '天津', 'hebei' => '河北', 'shanxi' => '山西', 'neimenggu' => '内蒙古', 'liaoning' => '辽宁', 'jilin' => '吉林', 'heilongjiang' => '黑龙江', 'shanghai' => '上海', 'jiangsu' => '江苏', 'zhejiang' => '浙江', 'anhui' => '安徽', 'fujian' => '福建', 'jiangxi' => '江西', 'shandong' => '山东', 'henan' => '河南', 'hubei' => '湖北', 'hunan' => '湖南', 'guangdong' => '广东', 'guangxi' => '广西', 'hainan' => '海南', 'chongqing' => '重庆', 'sichuan' => '四川', 'guizhou' => '贵州', 'yunnan' => '云南', 'xizang' => '西藏', 'shanxi1' => '陕西', 'gansu' => '甘肃', 'qinghai' => '青海', 'ningxia' => '宁夏', 'xinjiang' => '新疆', 'xianggang' =>  '香港', 'aomen' => '澳门'];

        if (!in_array($province_name, $provinces)) abort(404, '无此地区');
        $tmp = array_keys($provinces, $province_name);
        $data = [
            'nav' => 'visual',
            'area' => $this->my_area,
            'tab' => 'province',
            'provinces' => $provinces,
            'province_name' => $province_name,
            'province_js' => asset('js/province/' . $tmp[0] . '.js')
        ];
        //dd($data);
        return $data;
    }

    private function getCityData(Request $request)
    {
        $data = [
            'nav' => 'visual',
            'area' => $this->my_area,
            'tab' => 'city'
        ];
        return $data;
    }

    private function getOtherData(Request $request)
    {
        $data = [
            'nav' => 'visual',
            'area' => $this->my_area,
            'tab' => 'other'
        ];
        return $data;
    }

    /**
     *
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
