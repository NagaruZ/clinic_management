<?php

namespace app\index\controller;

use think\Controller;
use think\Request;
use think\captcha;

class Log extends Controller
{
    public function login()
    {
        return $this->fetch();
    }

    public function logging()
    {
        $name = input('request.username');
        $password = input('request.password');
//        $data = input('request.captcha');
//        if(!captcha_check($data))
//        {
//            return $this->error("验证码错误", "log/log");
//        }

        $is_admin = \app\index\model\Admin::login($name, $password);
        $is_doctor = \app\index\model\Doctor::login($name, $password);
        $is_patient = \app\index\model\Patient::login($name, $password);
        if($is_patient)
        {
            header(strtolower("location:" . config("web") . "/index/patient/home"));
            exit();
        }
        elseif($is_doctor)
        {
            header(strtolower("location:" . config("web") . "/index/doctor/home"));
            exit();
        }
        elseif($is_admin)
        {
            header(strtolower("location:" . config("web") . "/index/admin/admin"));
            exit();
        }
        else
        {
            return $this->error("用户名或密码错误","log/log");
        }
    }

    public function logout()
    {
        session("ext_user", NULL);
        session("role", NULL);
        return redirect('index/index/index');
    }
}
