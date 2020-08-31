<?php

namespace App\Policies;

use App\Models\AdminUser;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class AdminUserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function remove(AdminUser $adminuser, $targetAdminUser)
    {
        if ($targetAdminUser->id == 1) {
            return Response::deny("禁止对超级管理员进行操作");
        }
        return true;
    }

    public function modify(AdminUser $adminuser, $targetAdminUser)
    {
        if ($targetAdminUser->id == 1) {
            if($adminuser->id <> $targetAdminUser->id)
            return Response::deny("禁止对超级管理员进行操作");
        }
        return true;
    }
}
