<?php

namespace app\index\controller;

use think\Controller;
use think\Request;
use app\index\model\CheckItem as CheckItemModel;

class CheckItem extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $list = CheckItemModel::all();
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
        $check_item = new CheckItemModel();
        if($check_item->save(input('post.')))
            return $this->success('检查项目[' . $check_item->name .']添加成功， ID:' . $check_item->id, url('index/check_item/index'));
        else
            return $check_item->getError();
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
        $check_item = CheckItemModel::get($id);
        return view('', ['check_item' => $check_item]);
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
        $check_item = CheckItemModel::get($id);
        if($check_item->save(input('post.')))
            return $this->success('检查项目[' . $check_item->name .']更新成功， ID:' . $check_item->id, url('index/check_item/index'));
        else
            return $check_item->getError();
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        $check_item = CheckItemModel::get($id);
        if($check_item->delete())
            return $this->success('检查项目[' . $check_item->name . ']' . "删除成功", url('index/check_item/index'));
        else
            return $this->error('删除失败', url('index/check_item/index'));
    }
}
