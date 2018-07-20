<?php
namespace Admin\Controller;
use Think\Controller;

class IndexController extends BaseController {
    public function index(){
		$nav_data = D('AdminNav')->db(1,DB_NAME)->getTreeData('level','order_number,id');
		$this->assign('nav_data',$nav_data);
		$this->display();
    }

    public function welcome(){
    	$sys = new ApiController();
    	$sys_info = $sys->get_sys_info();
        $baseinfo = M('baseinfo')->db(1,DB_NAME)->find();
        $this->assign('sys_info',$sys_info);
    	$this->assign('baseinfo',$baseinfo);
        $this->display();
    }
}