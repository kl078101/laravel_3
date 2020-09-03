<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{
    //引入软删除
    use SoftDeletes;

    //白名单
    protected $fillable = ['key','value','name','comment','sort'];

    protected $setting_keys = null ;

    public function setting_key($key){
        if($this->setting_keys === null){

            $this->setting_keys = $this->orderBy('sort')->get()->mapWithKeys(function ($item) {
                return [$item['key'] => $item['value']];

            });
        }

        return $this->setting_keys;
    }

}
