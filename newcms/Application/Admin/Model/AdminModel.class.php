<?php
namespace Admin\Model;
use Think\Model;

class AdminModel extends GetDataModel{
	protected $_validate = array(
		// array(验证字段1,验证规则,错误提示,[验证条件,附加规则,验证时间]),
		array('group_id',	'require',	'用户组不能为空!',		1),
		array('username',	'require',	'管理员名不能为空!',	1),
		array('password',	'require',	'初始密码不能为空!',	1),
		array('username',	'',			'帐号名称已经存在！',	0,	'unique',	1),
	);


	protected $_link = array(
		'AuthGroup'=>array(
			'mapping_type'  => self::BELONGS_TO,
			'class_name'    => 'AuthGroup',
			'foreign_key'   => 'group_id',
			'as_fields' => 'title',
		),    
	);


	/**
	 * 验证用户名、密码、验证码
	 * @param  string $username 姓名
	 * @param  string $password 密码
	 * @param  string $captcha  验证码
	 * @return array            提示语跟状态
	 */
	public function login($username,$password,$captcha){
		$Verify = new \Think\Verify();
		if(!$Verify->check($captcha)){
			return array('info'=>'验证码错误','field'=>'captcha','status'=>'0');
		}

		$where['username'] = array('eq',$username);
		$where['state'] = 1;
		$admin = $this->where($where)->relation(true)->find();
		//区分大小写
		$count = getStrcmp('admin','username',$username,"`state` = '1'");

		if($count != 1){
			return array('info'=>'管理员不存在或被禁用','field'=>'username','status'=>'0');
		}elseif($admin['password'] != md5($password)){
			return array('info'=>'密码错误','field'=>'password','status'=>'0');
		}else{
			session('[start]'); 
			unset($admin['password']);
			session('admin',$admin);
			return array('info'=>'登录成功，正在跳转...','status'=>'1');				
		}
	}


}