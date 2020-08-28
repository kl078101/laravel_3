<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminLogin;
use App\Models\AdminUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //
    public function index(){
        return view('admin.login');
    }

    public function check(AdminLogin $adminlogin){

        //获得通过验证后的数据
        $data = $adminlogin->validated();
        $data['state'] = AdminUser::NORMAL;  //追加验证 state

        //是否通过验证
        $is = Auth::guard('admin')->attempt($data);

        if(!$is){
            //未通过验证
            return back()->withErrors(['username' => '账号不可用']);
        }

        return redirect()->route('admin.index');
    }

    //退出
    public function logout(){
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');

    }
}
