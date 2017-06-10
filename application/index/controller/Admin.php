<?php
namespace app\index\controller;

use app\index\model\Api;

class Admin extends Base
{

    public function _initialize()
    {
        parent::_initialize();
        if(!$this->admin){
            $this->error('请登录！','index/login/index');
        }
    }

    //添加页面
    public function add(){
        if (request()->isPost()){
            $params = $this->valid([
                'title'=>'require',
                'content'=>'',
                'pid'=>'require',
                'sort'=>''
            ]);
            $result = Api::create($params);
            if($result){
                $this->redirect('/show/'.$result['id']);
            }else{
                $this->error('操作失败！');
            }
        }
        $maxSort = Api::max('sort');
        return $this->fetch('add',['maxSort'=>$maxSort+1]);
    }

    public function update(){
        if (request()->isPost()){
            $params = $this->valid([
                'id'=>'require',
                'title'=>'require',
                'content'=>'',
                'pid'=>'require',
                'sort'=>''
            ]);
            $result = Api::update($params);
            if($result){
                $this->redirect('/show/'.$result['id']);
            }else{
                $this->error('操作失败！');
            }
        }
        $id = input('id');
        $api = Api::get($id);
        return $this->fetch('update',['api'=>$api]);
    }

    public function cp(){
        if (request()->isPost()){
            $params = $this->valid([
                'title'=>'require',
                'content'=>'',
                'pid'=>'require',
                'sort'=>''
            ]);
            $result = Api::create($params);
            if($result){
                $this->redirect('/show/'.$result['id']);
            }else{
                $this->error('操作失败！');
            }
        }
        $id = input('id');
        $api = Api::get($id);
        $maxSort = Api::max('sort');
        return $this->fetch('copy',['api'=>$api,'maxSort'=>$maxSort+1]);
    }

    //导出
    public function export(){
        $data = '';
        $list = Api::all();
        $tree = $this->getTree($list,0);
        $parent = 1;
        foreach($tree as $value){
            $data .= "<h1>{$parent}、{$value['title']}</h1>";
            $data .= '<div style="margin-left:20px;">';

            $child = 1 ;
            if ($value['son']) {
                foreach ($value['son'] as $page) {
                    $data .= "<h2>{$parent}.{$child}、{$page['title']}</h2>";
                    $data .= '<div style="margin-left:20px;">';
                    $data .= $page['content'];
                    $data .= '</div>';
                    $child ++;
                }
            }
            $data .= '</div>';
            $parent ++;
        }
        output_word($data,'API文档');
    }

    public function del(){
        $params = $this->valid([
            'id'=>'require'
        ]);
        $result = Api::destroy($params['id']);
        if($result){
            $this->redirect('/');
        }else{
            $this->error('操作失败！');
        }
    }

}
