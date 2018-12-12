<?php

namespace app\index\controller;

use think\Controller;
use think\Request;
use app\index\model\AppointmentPeriod as AppointmentPeriodModel;

class AppointmentPeriod extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $list = AppointmentPeriodModel::all();
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
        $appointment_period = new AppointmentPeriodModel();
        if($appointment_period->save(input('post.')))
            return $this->success('预约时段[' . $appointment_period->id . ']' . '新增成功', url('index/appointment_period/index'));
        else
            return $appointment_period->getError();
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
        $appointment_period = AppointmentPeriodModel::get($id);
        return view('', ['appointment_period' => $appointment_period]);
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
        $appointment_period = AppointmentPeriodModel::get($id);
        if($appointment_period->save(input('post.')))
            return $this->success('预约时段[' . $appointment_period->id .']修改成功', url('index/appointment_period/index'));
        else
            return $appointment_period->getError();
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        $appointment_period = AppointmentPeriodModel::get($id);
        if($appointment_period->delete())
            return $this->success('预约时段[' . $appointment_period->id . ']' . "删除成功", url('index/appointment_period/index'));
        else
            return $this->error('删除失败', url('index/appointment_period/index'));
    }
}
