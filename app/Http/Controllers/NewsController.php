<?php

namespace App\Http\Controllers;

use App\Areas;
use App\Posts;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class NewsController extends Controller
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
        //($request->route('id'));
        $this->setArea($request);

        $posts = Posts::OrderBy('id', 'desc')->paginate(10);
//        dd($posts);
        $data = [
            'nav' => 'news',
            'area' => $this->my_area,
            'posts' => $posts,
        ];

        return view('main.news', $data);
    }

    public function detail(Request $request)
    {
        $this->setArea($request);
        $post_id = $request->route('id');
        $post = Posts::where('id', $post_id)->get()->toArray();
        if (!$post) abort(404, '文章不存在！');

        $data = [
            'nav' => 'news',
            'area' => $this->my_area,
            'post' => $post[0]
        ];
//        dd($request->route('id'));
        return view('main.detail', $data);
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
