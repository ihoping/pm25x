<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Areaplus extends Model
{
    //
    /**
     * 与模型关联的数据表
     *
     * @var string
     */
    protected $table = 'areaplus';

    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = true;
}
