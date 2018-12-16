<?php

namespace app\index\controller;

use think\Controller;
use think\Request;
use app\index\model\Section as SectionModel;

class Section extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $list = SectionModel::all();
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
        $section = new SectionModel();
        $section->name = input('request.name');
        if($section->save())
            return $this->success('科室[' . $section->name . ']' . '新增成功，ID：' . $section->id, url('index/section/index'));
        else
            return $section->getError();
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        $section = SectionModel::get($id);
        $this->assign('list',$section->doctors);
        return $this->fetch('doctor/index');
//        dump($section->doctors);
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        $section = SectionModel::get($id);
        return view('', ['section' => $section]);
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
        $section = SectionModel::get($id);
        if($section->save(input('post.')))
            return $this->success('科室[' . $section->name . ']' . '修改成功，ID：' . $section->id, url('index/section/index'));
        else
            return $section->getError();
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        $section = SectionModel::get($id);
        if($section->delete())
            return $this->success('科室[' . $section->name . ']' . "删除成功", url('index/section/index'));
        else
            return $this->error('删除失败', url('index/section/index'));
    }
}
