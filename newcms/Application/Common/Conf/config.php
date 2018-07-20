<?php
return array(
	// 数据库设置
	'DB_TYPE'               =>  'mysql',     // 数据库类型
	'DB_HOST'               =>  '127.0.0.1', // 服务器地址
	'DB_NAME'               =>  'cscms',          // 数据库名
	'DB_USER'               =>  'root',      // 用户名
	'DB_PWD'                =>  'root',          // 密码
	'DB_PORT'               =>  '3306',        // 端口
	'DB_PREFIX'             =>  'c_',    // 数据库表前缀
    'LOG_RECORD'            =>  false,  // 进行日志记录
    
    'domain'                => 'http://127.0.0.1',
    'DEFAULT_FILTER'        => 'strip_tags,htmlspecialchars',//I方法过滤

    //redis
    // 'CACHE_TYPE'			=>'Redis',
    // 'REDIS_HOST'			=>'127.0.0.1',
    // 'REDIS_PORT'			=>6379,
    // 'REDIS_PASSWORD'		=>'',
    // 'REDIS_DB_PREFIX'		=>'cms',
    // 'LOAD_EXT_CONFIG' 		=>'sdk_config',
    'DATA_CACHE_TIME'		=>'2592000',//30天

	//多图片上传
	'UPLOAD_PATH' => './Public/Uploads/',

	'GENDER' => array(
		'0' => '女',
		'1' => '男',
		'2' => '不详',
	),

	//管理员角色
	'ADMINGROUP' => array(
		'1' => '超级管理员',
		'2' => '普通管理员',
	),


	// 话题的状态改变
	'TOPICSTATUSCHANGES' => array(
		'0' => '禁用',
		'1' => '已发布',
		'2' => '待审核',
	),
	'TOPICSTATUSTITLE' => array(
		'0' => '发布',
		'1' => '禁用',
		'2' => '通过审核',
	),
	'TOPICSTATUSLABEL' => array(
		'0' => 'label-default',
		'1' => 'label-success',
		'2' => 'label-danger',
	),
	'TOPICSTATUSICONFOUNT' => array(
		'0' => '&#xe615;',
		'1' => '&#xe631;',
		'2' => '&#xe6e1;',
	),

	// 状态改变四个一套
	'STATUSCHANGES' => array(
		'0' => '禁用',
		'1' => '启用',
	),
	'STATUSTITLE' => array(
		'0' => '启用',
		'1' => '禁用',
	),
	'STATUSLABEL' => array(
		'0' => 'label-default',
		'1' => 'label-success',
	),
	'STATUSICONFOUNT' => array(
		'0' => '&#xe615;',
		'1' => '&#xe631;',
	),
    
    'STATUSUSER' => array(
        '0' => '黑名单',
        '1' => '白名单',
    ),
    'TYPETITLE' => array(
        '0' => '无连接',
        '1' => '当前页面打开',
        '2' => '另开页面打开',
    ),
    'TYPELABEL' => array(
        '0' => 'label-default',
        '1' => 'label-success',
        '2' => 'label-danger',
    ),

	// 为什么要有置顶啊改变四个一套
	'STATUSCHANGESTOP' => array(
		'0' => '未置顶',
		'1' => '已置顶',
	),
	'STATUSTITLETOP' => array(
		'0' => '置顶',
		'1' => '取消置顶',
	),
	'STATUSLABELTOP' => array(
		'0' => 'label-secondary',
		'1' => 'label-danger',
	),
	'STATUSICONFOUNTTOP' => array(
		'0' => '&#xe679;',
		'1' => '&#xe674;',
	),
  
	'WECHAT' => array(
		'appid'=>'wxcc8716aa995774ae', //填写高级调用功能的app id, 请在微信开发模式后台查询
		'appsecret'=>'4d8e182eaa38417eaf993db2c6f75888', //填写高级调用功能的密钥
	)

);