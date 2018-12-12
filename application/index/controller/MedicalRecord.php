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
        //
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

        $medical_record = new MedicalRecordModel();
        $medical_record->description = input('post.description');
        $medical_record->diagnose = input('post.diagnose');
        $medical_record->appointment_id = session('appointment_id');
        $medical_record->save();

        $prescription = $medical_record->prescription()->save(null);
        dump($prescription->id);
        $status = $prescription->check_items()->saveAll(input('post.check_item_id'));
        if($status)
        {
            return $this->success('就诊记录与处方添加成功！',url('index/appointment/index'));
        }
        else
        {
            return $prescription->getError();
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
