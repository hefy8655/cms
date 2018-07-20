<?php
namespace Admin\Controller;
use Think\Controller;

class NavController extends BaseController {
    //菜单列表
    public function nav_index(){
        if(IS_AJAX){
            $data = I('get.');
            $data['defaultOrder'] = 'order_number';
            $data['handleData']   = 'catTree';
            $list = D('AdminNav')->getData($data);
            $this->ajaxReturn($list);
        }
        $NavList = M('AdminNav')->db(1,DB_NAME)->order('order_number')->select();
        $NavList = catTree($NavList);
        $this->assign('NavList',$NavList);
        $this->display();
    }

    //修改状态和名字和排序和全部信息
    public function nav_upload(){
        if(IS_AJAX){
            $data = I('post.');
            $is_success = getSaveData('AdminNav',$data);
            if($is_success['status'] == 1){
                D('AdminNav')->db(1,DB_NAME)->saveChildNumber();
                $ajaxReturn['info'] = '修改成功,提交中...';
                $ajaxReturn['status'] = 1;         
            }else{
                $ajaxReturn['info'] = $is_success['info'];
                $ajaxReturn['status'] = 0;
            }
            $this->ajaxReturn($ajaxReturn);
        }else{
            $id = I('get.id');
            $this->NavFind = M('AdminNav')->db(1,DB_NAME)->find($id);
            $NavList = M('AdminNav')->db(1,DB_NAME)->select();
            $NavList = catTree($NavList);
            $this->assign('NavList',$NavList);
            $this->display();
        }
    }

    //删除
    public function nav_delete(){
        if(IS_AJAX){
            $id = I('post.id');
            $list = M('AdminNav')->db(1,DB_NAME)->find($id);
            $child = M('AdminNav')->db(1,DB_NAME)->where('pid='.$list['id'])->count();
            if($child > 0){
                $ajaxReturn['info'] = $list['name'].' 菜单中含有子菜单<br/>请先删除它的子菜单！';
                $ajaxReturn['status'] = 0;
            }else{
                $ajaxReturn = getDeleteData('AdminNav',$id);
                D('AdminNav')->db(1,DB_NAME)->saveChildNumber();
            }
            $this->ajaxReturn($ajaxReturn);
        }
    }

    //添加菜单
    public function nav_add(){
        if(IS_AJAX){
            $data = I('post.');
            $ajaxReturn = getAddData('AdminNav',$data);
            D('AdminNav')->db(1,DB_NAME)->saveChildNumber();
            $this->ajaxReturn($ajaxReturn);
        }else{
            $this->display();
        }
    }
}