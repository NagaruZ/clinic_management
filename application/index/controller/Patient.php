<?php

namespace app\index\controller;

use think\Controller;
use think\Request;

class Patient extends Controller
{
    public function home()
    {
        if (!session('?ext_user')) {
            header(strtolower("location: " . config("web"). "index/log/log"));
            exit();
        }
        $this->assign('title', '主页');
        return $this->fetch();
    }

    public function logout()
    {
        \app\index\model\Patient::logout();
        if (!session('?ext_user')) {
            header(strtolower("location:". config("web").'/index/log/log'));
            exit();
        }
        return NULL;
    }

    public function register()
    {
        return $this->fetch();
    }

    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }

    public function change_password()
    {
        $old_password_input = md5(input('request.old_password'));
        $new_password = input('request.new_password');
        $new_password_repeat = input('request.new_password_repeat');
        $id = session('ext_user')['id'];
        $user = \app\index\model\Patient::search($id);
        $old_password = $user['password'];
        if($old_password == $old_password_input)
        {
            if($new_password == $new_password_repeat)
            {
                $is_successful = \app\index\model\Patient::update_password($id, $new_password);
                if($is_successful)
                {
                    session("ext_user", NULL);
                    session("role", NULL);
                    return $this->success('修改成功，请重新登录', config("web").'/index/log/login');
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
