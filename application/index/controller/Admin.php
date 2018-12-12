<?php

namespace app\index\controller;

use think\Controller;
use think\Request;
use app\index\model\Doctor as DoctorModel;

class Admin extends Controller
{
    public function admin()
    {
        if (!session('?ext_user')) {
            return redirect('index/log/login');
            exit();
        }
        return $this->fetch();
    }

    public function add_doctor()
    {
        return $this->fetch('doctor/create');
    }

    public function view_doctor()
    {
        $list = DoctorModel::all();
        $this->assign('list', $list);
        return $this->fetch('doctor/index');
    }

    public function changepsw()
    {
        if (!session('?ext_user')) {
//            header(strtolower("location: /log"));
            return redirect('index/index/index');
            exit();
        }
        return $this->fetch();
    }

    public function change_password()
    {
        $old_password_input = md5(input('request.old_password'));
        $new_password = input('request.new_password');
        $new_password_repeat = input('request.new_password_repeat');
        $id = session('ext_user')['id'];
        $user = \app\index\model\Admin::search($id);
        $old_password = $user['password'];
        if($old_password == $old_password_input)
        {
            if($new_password == $new_password_repeat)
            {
                $is_successful = \app\index\model\Admin::update_password($id, $new_password);
                if($is_successful)
                {
                    session("ext_user", NULL);
                    session("role", NULL);
                    return $this->success('修改成功，请重新登录', config("web").'/index/log/log');
                }
                else
                    return $this->error("修改密码失败");
            }
            else
            {
                return $this->error("两次输入密码不一致");
            }
        }
        else
        {
            return $this->error("原密码输入错误");
        }
    }

}
