<?php

namespace app\index\controller;

use think\Controller;
use think\Request;
use think\captcha;

class Login extends Controller
{
    public function login()
    {
        return $this->fetch('login');
    }
}
