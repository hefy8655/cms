<?php
namespace Admin\Controller;
use Think\Controller;

class CategoryController extends BaseController {

    public function category_index(){
        if(IS_AJAX){
            $data = I('get.');
            $data['defaultOrder'] = 'order_number';
            $data['handleData'] = 'catTree';
            $list = D('Category')->getData($data);
            $this->ajaxReturn($list);
        }
        $this->display();
    }

    //进入分类修改页
    public function category_upload(){
        if(IS_AJAX){
            $data = I('post.');
            $data['createtime'] = time();
            $ajaxReturn = getSaveData('category',$data);
            D('Category')->setRedis();
            $this->ajaxReturn($ajaxReturn);
        }else{
            $catelist = M('Category')->db(1,DB_NAME)->select();
            $catelist = catTree($catelist);
            
            $RuleList = M('Category')->db(1,DB_NAME)->find(I('get.id'));
            if($RuleList['pid']!=0){
                $catelist = M('Category')->db(1,DB_NAME)->where(['pid'=>0])->select();
                $this->assign('catelist',$catelist);
            }
            $this->assign('RuleList',$RuleList);
            $this->display();
        }
    }

    //分类添加、编辑
    public function category_add(){
        if(IS_AJAX){
            $data = I('post.');
            $data['createtime'] = time();
            $ajaxReturn = getAddData('Category',$data);
            D('Category')->setRedis();
            $this->ajaxReturn($ajaxReturn);
        }
    }

    //删除分类
    public function category_delete(){
        if(IS_AJAX){
            $id = I('post.id');
            $list = M('Category')->db(1,DB_NAME)->field('id,pid,name')->find($id);
            
            $child = M('Category')->db(1,DB_NAME)->where('pid='.$list['id'])->count();
            if($child > 0){
                $ajaxReturn['info'] = $list['name'].'分类中含有子分类<br/>请先删除它的子分类！';
                $ajaxReturn['status'] = 0;
            }else{
                $ajaxReturn = getDeleteData('Category',$id);
                D('Category')->db(1,DB_NAME)->saveChildNumber();
            }
            
            $this->ajaxReturn($ajaxReturn);
        }
    }
}