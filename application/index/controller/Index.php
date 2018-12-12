<?php
namespace app\index\controller;

use think\Controller;

class Index extends Controller
{
    public function hello($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }

    public function index()
    {
        $roles = [
            "patient" => "会员",
            "doctor" => "医生",
            "admin" => "管理员"
        ];
        if(session('?role'))
        {
            $role = $roles[session('role')];
            $this->assign("role", $role);
        }
        return $this->fetch();
    }
}
