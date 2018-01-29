<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Areas extends Model
{
    /**
     * 与模型关联的数据表
     *
     * @var string
     */
    protected $table = 'areas';

    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;
}
