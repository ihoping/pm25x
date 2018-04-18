<?php

namespace App\Http\Controllers;

use App\Areaplus;
use App\Areas;
use Illuminate\Http\Request;

class InfoController extends Controller
{
    //
    public function areaPlus(Request $request)
    {
        exit();
        $province = $request->post('province');
        $cities = json_decode($request->post('data'), true);
        $areas_obj = Areas::all();
        foreach ($areas_obj as $row) {
            $areas[] = $row->name;
        }

        $area_plus_p = new Areaplus();
        $area_plus_p->name = $province;
        $area_plus_p->ename = $province;
        $area_plus_p->parent_id = 0;
        $area_plus_p->save();

        foreach ($cities as $city) {
            $area_plus = new Areaplus();

            foreach ($areas as $area) {
                if (mb_strrpos($city, $area) !== false) {
                    $area_plus->name = $area;
                    break;
                }
                $len = mb_strlen($area);
                if (mb_strpos($area, '州')) {
                    if (mb_strrpos($city, mb_substr($area, 0, $len - 1)) !== false) {
                        $area_plus->name = $area;
                        break;
                    }
                }
                if (mb_strpos($area, '地区')) {
                    if (mb_strrpos($city, mb_substr($area, 0, $len - 2)) !== false) {
                        $area_plus->name = $area;
                        break;
                    }
                }

            }
            $area_plus->ename = $city;
            $area_plus->parent_id = $area_plus_p->id;
            $area_plus->save();
        }
        return response()->json(
        );
    }
}
