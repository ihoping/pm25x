<?php

namespace App\Http\Controllers;

use App\Areas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

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

        $data = [
            'nav' => 'rank',
            'area' => $this->my_area
        ];
        return view('main.rank', $data);
    }
}
