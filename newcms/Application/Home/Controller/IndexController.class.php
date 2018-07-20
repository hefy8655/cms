<?php
namespace Home\Controller;
use Think\Controller;

class IndexController extends BaseController{

    public function index(){
    	$baseinfo = D('Baseinfo')->getCate();
    	$data = D('Category')->getCate();
    	$content = D('Content')->getCache(0,10);
		//判断是否为移动端
		if(isMobile()){
			$content['2'] = array_splice($content['2'],0,6);
			$index = 'appindex';
		}else{
			$content['2'] = array_splice($content['2'],0,8);
			$index = 'index';
		}
        $this->assign('content',$content);

        $this->assign('data',$data);

        $this->assign('baseinfo',$baseinfo);

		$this->display($index);
    }
}