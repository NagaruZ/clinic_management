<?php

namespace app\index\controller;

use think\Controller;
use think\Request;
use app\index\model\Doctor as DoctorModel;
use app\index\model\Patient as PatientModel;
use app\index\model\AppointmentPeriod as AppointmentPeriodModel;
use app\index\model\Appointment as AppointmentModel;
use app\index\model\DoctorArrangement as DoctorArrangementModel;

class Appointment extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $appointment_list = AppointmentModel::all();
        $this->assign('appointment_list', $appointment_list);
        $appointment_period_list = AppointmentPeriodModel::all();
        $this->assign('appointment_period_list',$appointment_period_list);
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
        $this->assign('doctor_list', $doctor_list);
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

        $doctor = DoctorModel::get(input('post.doctor_id'));
        $existing_appointments_num = AppointmentModel::where('doctor_id',input('post.doctor_id'))
            ->where('is_finished', 0)
            ->where('is_cancelled', 0)
            ->count();
        $period_status = DoctorArrangementModel::where('doctor_id',input('post.doctor_id'))
            ->where('period_id', input('post.period_id'))
            ->find();
        if($period_status->is_free == 0)
        {
            return $this->error('预约失败，此时段的预约名额已满！');
        }
        else
        {
            if($existing_appointments_num == $doctor->max_appointment_num-1) // only 1 more available appointment left
            {
                // update period info
                $period_status->is_free = 0;
                $period_status->save();
            }
            if($appointment->save(input('post.')))
                return $this->success('预约成功！', url('index/appointment/index'));
            else
                return $appointment->getError();
        }
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
        $doctor = DoctorModel::get(input('post.doctor_id'));
        $existing_appointments_num = AppointmentModel::where('doctor_id',input('post.doctor_id'))
            ->where('is_finished', 0)
            ->where('is_cancelled', 0)
            ->count();
        if($existing_appointments_num >= $doctor->max_appointment_num)
        {
            // update period info
            $period_status = DoctorArrangementModel::where('doctor_id',input('post.doctor_id'))
                ->where('period_id', input('post.period_id'))
                ->find();
            $period_status->is_free = 0;
            $period_status->save();
            return $this->error('预约修改失败，此时段的预约名额已满！');
        }
        else
        {
            if($appointment->save(input('post.')))
                return $this->success('预约修改成功！', url('index/appointment/index'));
            else
                return $appointment->getError();
        }
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

        // update period info
        $period_status = DoctorArrangementModel::
            where('doctor_id', $appointment->doctor->id)
            ->where('period_id', $appointment->period->id)
            ->find();
        $period_status->is_free = 1;
        $period_status->save();

        if($appointment->save()){
            session('appointment_id', $appointment->id);
            return $this->success('已完成预约，接下来将跳转到就诊记录添加页面', url('index/medical_record/create'));
        }
        else
            return $appointment->getError();
    }

    public function search()
    {
//        $appointment_list = AppointmentModel::where('patient_id', input('post.patient_id'))
//            ->where('period_id', input('post.period_id'))
//            ->where('is_finished', input('post.is_finished'))
//            ->where('is_cancelled', input('post.is_cancelled'))
        $appointment_list = AppointmentModel::where(input('post.'))
            ->select();
        $this->assign('appointment_list', $appointment_list);
        $appointment_period_list = AppointmentPeriodModel::all();
        $this->assign('appointment_period_list',$appointment_period_list);
        return $this->fetch('appointment/index');
    }
}
