<?php

namespace app\index\model;

use think\Model;

class Patient extends Model
{
    public static function login($name, $password)
    {
        $where['username'] = $name;
        $where['password'] = md5($password);
        $user = Patient::where($where)->find();
        if($user)
        {
            unset($user["password"]);
            session("ext_user", $user);
            session("role", "patient");
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
}
