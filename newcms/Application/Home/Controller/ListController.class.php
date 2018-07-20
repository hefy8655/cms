<?php
namespace Home\Controller;
use Think\Controller;

class ListController extends BaseController{
    
    /**
     * 列表
     * @return [type] [description]
     */
    public function index(){
        //大分类下的数据
        if(!isset($_GET['pid'])){
            return false;
        }
        $_data['pid'] = htmlspecialchars(trim(I('get.pid')));
        $page = htmlspecialchars(trim(I('get.p',1)));
        $num = 6;
        if(isset($_GET['cid'])){
            $_data['cid'] = htmlspecialchars(trim(I('get.cid')));
        }
        $data = D('Content')->getCache($num*($page-1),$num,$_data);
        //判断是否为移动端
        if(isMobile()){
            $index = 'appindex';
        }else{
            $index = 'index';
        }
        $baseinfo = D('Baseinfo')->getCate();
        $this->assign('baseinfo',$baseinfo);

        $this->assign('page',getPage($data['count'],$num));// 赋值分页输出
        $this->assign('data',D('Category')->getCate());//分类数据

        $this->assign('content',$data['content']);
        $this->assign('count',$data['count']);
        $this->assign('name',$data['name']);
        $this->assign('pid',$_data['pid']);

        $this->display($index);
    }

    /**
     * 详情页
     * @return [type] [description]
     */
    public function details(){
        if(IS_GET){
            $id = htmlspecialchars(trim(I('get.id')));
            $content = D('Content')->getDetails($id);//页面内容
            if($content){
                $start_end = D('Content')->getStartEnd($id);//页面内容
                if(isMobile()){
                    $_data['pid'] = $content['0']['pid'];
                    $end_data = D('Content')->getCache(0,10,$_data);
                    if($end_data['content']){
                        $end_data = $end_data['content'];
                    }
                    $this->assign('end_data',$end_data);
                    $index = 'appdetails';
                }else{
                    $this->assign('data',D('Category')->getCate());//分类数据
                    $index = 'details';
                }
                $baseinfo = D('Baseinfo')->getCate();
                $this->assign('baseinfo',$baseinfo);
                $this->assign('content',$content);
                $this->assign('start',$start_end['start']);
                $this->assign('end',$start_end['end']);

                $this->display($index);
            }else{

            }
        }
    }
}