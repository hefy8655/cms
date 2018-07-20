<?php
namespace Admin\Model;
use Think\Model;

class AuthGroupModel extends GetDataModel{
   
    protected $_validate = array(
		// array(验证字段1,验证规则,错误提示,[验证条件,附加规则,验证时间]),
		array('title',	'require',	'角色名不能为空!',	0),
		array('title',	'',			'角色名已经存在！',	0,	'unique',	3),
	);
}