<?php

namespace app\index\controller;

use think\Controller;
use think\Request;
use app\index\model\Doctor as DoctorModel;
use app\index\model\AppointmentPeriod as AppointmentPeriodModel;
use app\index\model\Appointment as AppointmentModel;

class Appointment extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $list = AppointmentModel::all();
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
        $doctor_list = DoctorModel::all();
        $appointment_period_list = AppointmentPeriodModel::all();
        $this->assign('doctor_list', $doctor_list);
        $this->assign('appointment_period_list', $appointment_period_list);
        return $this->fetch();
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        $appointment = new AppointmentModel();
        $appointment->patient_id = session('ext_user')['id'];
        if($appointment->save(input('post.')))
            return $this->success('预约成功！', url('index/appointment/index'));
        else
            return $appointment->getError();
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
        $appointment = AppointmentModel::get($id);
        $doctor_list = DoctorModel::all();
        $appointment_period_list = AppointmentPeriodModel::all();
        $this->assign('doctor_list', $doctor_list);
        $this->assign('appointment_period_list', $appointment_period_list);
        return $this->fetch('',['appointment' => $appointment]);
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
        $appointment = AppointmentModel::get($id);
        if($appointment->save(input('post.')))
            return $this->success('修改预约成功！', url('index/appointment/index'));
        else
            return $appointment->getError();
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        // soft delete
        $appointment = AppointmentModel::get($id);
        $appointment->is_cancelled = 1;
        if($appointment->save())
            return $this->success('预约删除成功！', url('index/appointment/index'));
        else
            return $appointment->getError();
    }

    public function finish($id)
    {
        $appointment = AppointmentModel::get($id);
        $appointment->is_finished = 1;
        if($appointment->save()){
            session('appointment_id', $appointment->id);
            return $this->success('已完成预约，接下来将跳转到就诊记录添加页面', url('index/medical_record/create'));
        }
        else
            return $appointment->getError();
    }
}
