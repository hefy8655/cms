<?php
namespace Home\Controller;
use Think\Controller;

class CommonController extends BaseController{

	public function error(){
		$this->display();
	}

	public function videoPlay(){
		$url = htmlspecialchars(trim(I('get.url')));
		$cover = htmlspecialchars(trim(I('get.cover')));
		if(isMobile()){
			$m3u8 = 'false';
		}else{
			$m3u8 = 'true';
		}
		$this->assign('url',$url);
		$this->assign('cover',$cover);
		$this->assign('m3u8',$m3u8);
		$this->display();
	}

	/**
	 * 获取域名
	 * @return [type] [description]
	 */
	public function getDomain(){
		if(IS_AJAX){
			$res = D('Domain')->getCache();
			$this->ajaxReturn($res);
		}
	}
}