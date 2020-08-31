<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminUserRequest;
use App\Models\AdminUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    //列表
    public function index(AdminUser $adminuser){

        //查询管理员信息
        $adminuser = $adminuser->orderBy('id','desc')->get();

        $data = [
            'adminuser' => $adminuser
        ];

        return view('admin.adminuser.index',$data);
    }

    //添加
    public function add(AdminUser $adminuser){

        $data = [
            'adminuser' => $adminuser,
        ];

        return view('admin.adminuser.add',$data);

    }

    //保存
    public function save(AdminUserRequest $request , AdminUser $adminuser){
        //策略保护
        $this->authorizeForUser(Auth::guard('admin')->user(), 'modify', $adminuser);


        $data = $request->validated();

        if($adminuser->id){

            //如果更新密码，则加密，否则删除密码字段
            if($data['password']){
                $data['password'] = Hash::make($data['password']);
            }else{
                unset($data['password']);
            }

            $adminuser->update($data);

        }else{

            $data['state'] = AdminUser::NORMAL;

            $data['password'] = Hash::make($data['password']);

            $adminuser->create($data);
        }


        alert('操作成功');
        return redirect()->route('admin.adminuser');

    }

    //删除
    public function remove(AdminUser $adminuser){

        //策略保护
        $this->authorizeForUser(Auth::guard('admin')->user(), 'remove', $adminuser);

        $adminuser->delete();

        alert('操作成功');
        return back();
    }

    //状态切换
    public function state(AdminUser $adminuser){

        //策略保护
        $this->authorizeForUser(Auth::guard('admin')->user(), 'remove', $adminuser);

        $new_state = $adminuser->state === AdminUser::NORMAL ? AdminUser::BAN : AdminUser::NORMAL;

        $adminuser->state = $new_state;

        $adminuser->save();

        alert('操作成功');
        return back();
    }
}
