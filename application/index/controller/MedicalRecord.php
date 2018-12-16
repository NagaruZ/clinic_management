<?php

namespace app\index\controller;

use think\Controller;
use think\Request;
use app\index\model\MedicalRecord as MedicalRecordModel;
use app\index\model\Appointment as AppointmentModel;
use app\index\model\CheckItem as CheckItemModel;
use app\index\model\Prescription as PrescriptionModel;

class MedicalRecord extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $list = MedicalRecordModel::all();
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
        $check_item_list = CheckItemModel::all();
        $this->assign('check_item_list', $check_item_list);
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
        if(MedicalRecordModel::where('appointment_id', session('appointment_id'))->find())
            return $this->error('此预约已有对应的就诊记录',url('index/appointment/index'));

        // add appointment
        $appointment = AppointmentModel::get(session('appointment_id'));
        $medical_record = $appointment->medical_record()->save([
            'description' => input('post.description'),
            'diagnose' => input('post.diagnose')
        ]);

        // add prescription
        $prescription = $medical_record->prescription()->save(null);

        // add check items
        $prescription->items()->saveAll(input('post.check_item_id'));

        // add payment
        $total_price = CheckItemModel::where(['id' => input('post.check_item_id')])->sum('price');
        $status = $prescription->payment()->save(['price' => $total_price]);

        if($status)
        {
            return $this->success('就诊记录与处方添加成功！',url('index/appointment/index'));
        }
        else
        {
            return $prescription->payment()->getError();
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
        $medical_record = MedicalRecordModel::get($id);
        $prescription = PrescriptionModel::get($medical_record->prescription->id);
        $check_items = $prescription->items;
        $this->assign('check_item_list', $check_items);
        $this->assign('medical_record', $medical_record);
        $this->assign('payment', $prescription->payment);
//        $this->assign('total_price', $prescription->payment->price);
//        $this->assign('is_paid', $prescription->payment->is_paid);
        return $this->fetch();
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
}
