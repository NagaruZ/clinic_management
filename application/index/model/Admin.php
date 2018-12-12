<?php

namespace app\index\model;

use think\Model;

class Admin extends Model
{
    public static function login($name, $password)
    {
        $where['username'] = $name;
        $where['password'] = md5($password);
        $user = Admin::where($where)->find();
        if($user)
        {
            unset($user["password"]);
            session("ext_user", $user);
            session("role", "admin");
            return true;
        }
        else
        {
            return false;
        }
    }

    public static function logout(){
        session("ext_user", NULL);
        session("role", NULL);
        return ;
    }

    public static function search($id)
    {
        $where['id'] = $id;
        return Admin::where($where)->find();
    }

    public static function update_password($id, $new_password)
    {
        $where['id'] = $id;
        $user = Admin::where($where)->update(['password' => md5($new_password)]);
        if($user)
            return true;
        else
            return false;
    }
}
