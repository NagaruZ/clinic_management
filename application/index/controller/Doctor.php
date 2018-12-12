<?php

namespace app\index\controller;

use think\Controller;
use think\Exception;
use think\Request;
use app\index\model\Doctor as DoctorModel;
use app\index\model\Section as SectionModel;

class Doctor extends Controller
{
    public function home()
    {
        if (!session('?ext_user') || session('role') != "doctor") {
            return redirect('index/log/login');
        }
        return $this->fetch();
    }

    public function logout()
    {
        \app\index\model\Doctor::logout();
        if (!session('?ext_user')) {
            header(strtolower("location:". config("web").'/index/log/log'));
            exit();
        }
        return NULL;
    }

    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $list = DoctorModel::all();
        $this->assign('list', $list);
        return $this->fetch();
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        $section_list= SectionModel::all();
        $this->assign('section_list', $section_list);
        return $this->fetch();
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     */
    public function save(Request $request)
    {
        $doctor = new DoctorModel();
        $doctor->username = input('request.username');
        $doctor->password = md5(input('request.password'));
        $doctor->section_id = input('request.section_id');
        $doctor->name = input('request.name');
        $doctor->birth_date = input('request.birth_date');
        $doctor->gender = input('request.gender');
        $doctor->phone = input('request.phone');
        $doctor->level = input('request.level');
        $doctor->description = input('request.description');
        $doctor->max_appointment_num = input('request.max_appointment_num');
        if($doctor->save())
            return $this->success('医生[' . $doctor->name . ']' . '新增成功，ID：' . $doctor->id, url('index/doctor/index'));
        else
            return $doctor->getError();
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
        //todo: verify session
        $doctor = DoctorModel::get($id);
        $section_list= SectionModel::all();
        $this->assign('section_list', $section_list);
        return view('', ['doctor' => $doctor]);
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
        $doctor = DoctorModel::get($id);
        $doctor->username = input('request.username');
        $doctor->section_id = input('request.section_id');
        $doctor->name = input('request.name');
        $doctor->birth_date = input('request.birth_date');
        $doctor->gender = input('request.gender');
        $doctor->phone = input('request.phone');
        $doctor->level = input('request.level');
        $doctor->description = input('request.description');
        $doctor->max_appointment_num = input('request.max_appointment_num');
        if($doctor->save())
            return $this->success('医生[' . $doctor->name . ']' . "修改成功，ID：" . $doctor->id, url('index/doctor/index'));
        else
            return $doctor->getError();
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     */
    public function delete($id)
    {
        $doctor = DoctorModel::get($id);
        if($doctor->delete())
            return $this->success('医生[' . $doctor->name . ']' . "删除成功", url('index/doctor/index'));
        else
            return $this->error('删除失败', config("web").'/index/doctor/index');
    }
}
