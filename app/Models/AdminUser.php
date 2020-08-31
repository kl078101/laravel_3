<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminUser extends Authenticatable
{
    //软删除
    use SoftDeletes;

    //设置黑名单
    protected $guarded = [];

    const NORMAL = 1; //可用，可以登陆
    const BAN = 0; //禁用，不可以登陆

    //状态访问器
    public function getStateTextAttribute(){
        return config('project.admin.state')[ $this->state ];
    }

}
