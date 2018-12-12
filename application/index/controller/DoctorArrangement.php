<?php

namespace app\index\controller;

use think\Controller;
use think\Request;
use app\index\model\AppointmentPeriod as AppointmentPeriodModel;
use app\index\model\Doctor as DoctorModel;

class DoctorArrangement extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index($id)
    {
        $doctor = DoctorModel::get($id);
        $res["code"] = 0;
        $res["data"] = $doctor->periods;
        return json_encode($res);
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
        $doctor = DoctorModel::get($id);
        $periods_full_list = AppointmentPeriodModel::all();
        $periods_chosen = $doctor->periods;
        $this->assign('doctor', $doctor);
        $this->assign('appointment_period_list', $periods_full_list);
        $this->assign('appointment_period_chosen_list', $periods_chosen);
        return $this->fetch();
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
        $doctor->periods()->detach();
        $periods = input('post.period_id');
        if($doctor->periods()->saveAll($periods))
            return $this->success('修改成功！', url('index/doctor/home'));
        else
            return $doctor->getError();
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
}
