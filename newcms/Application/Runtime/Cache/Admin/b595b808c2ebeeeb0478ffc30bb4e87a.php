<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<LINK rel="Bookmark" href="/favicon.ico" >
<LINK rel="Shortcut Icon" href="/favicon.ico" />
<!--[if lt IE 9]>
<script type="text/javascript" src="lib/html5.js"></script>
<script type="text/javascript" src="lib/respond.min.js"></script>
<script type="text/javascript" src="lib/PIE_IE678.js"></script>
<![endif]-->
<link href="/Public/Admin/css/H-ui.min.css?v=212" rel="stylesheet" type="text/css" />
<link href="/Public/Admin/css/H-ui.admin.css?v=212" rel="stylesheet" type="text/css" />
<link href="/Public/Admin/lib/Hui-iconfont/1.0.6/iconfont.css?v=212" rel="stylesheet" type="text/css" />
<link href="/Public/Admin/css/style.css?v=212" rel="stylesheet" type="text/css" />
<!--[if IE 6]>
<script type="text/javascript" src="http://lib.h-ui.net/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<title>后台管理</title>
</head>
<body>
<header class="Hui-header cl">
	<a class="Hui-logo l" title="H-ui.admin v2.3" href="<?php echo U('Index/index');?>">后台管理</a>
	<ul class="Hui-userbar">
		<li><?php echo (searchDict($AdminInfo["group_id"],'ADMINGROUP')); ?></li>
		<li class="dropDown dropDown_hover"><a href="#" class="dropDown_A"><?php echo ($AdminInfo["username"]); ?><i class="Hui-iconfont">&#xe6d5;</i></a>
			<ul class="dropDown-menu radius box-shadow">
				<li><a title="修改密码" href="javascript:;" onclick="admin_upload('修改密码','<?php echo U('Mall/admin_upload',array('id'=>$AdminInfo[id]));?>')">修改密码</a></li>
				<li><a title="退出"  href="<?php echo U('Login/LoginOut');?>">退出</a></li>
			</ul>
		</li>
	</ul>
	<a href="javascript:;" class="Hui-nav-toggle Hui-iconfont" aria-hidden="false">&#xe667;</a> </header>
	<aside class="Hui-aside">
		<input runat="server" id="divScrollValue" type="hidden" value="" />
		<div class="menu_dropdown bk_2">
			<?php if(is_array($nav_data)): $i = 0; $__LIST__ = $nav_data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><dl id="menu-admin">
					<?php if(($vo["pid"] == 0) and ($vo["child_number"] == 0)): ?><dt class="selected"><a _href="<?php echo U($vo['url']);?>" onclick="login_session(this)" data-title="<?php echo ($vo["name"]); ?>" href="javascript:void(0)"><i class="Hui-iconfont <?php echo ($vo["ico"]); ?>"></i> <?php echo ($vo["name"]); ?></a></dt>
					<?php else: ?>
						<dt><i class="Hui-iconfont <?php echo ($vo["ico"]); ?>"></i> <?php echo ($vo["name"]); ?><i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
						<dd>
							<ul>
								<?php if(is_array($vo["_data"])): $i = 0; $__LIST__ = $vo["_data"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vn): $mod = ($i % 2 );++$i;?><li><a _href="<?php echo U($vn['url']);?>" onclick="login_session(this)" data-title="<?php echo ($vn["name"]); ?>" href="javascript:void(0)"><?php echo ($vn["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
							</ul>
						</dd><?php endif; ?>
				</dl><?php endforeach; endif; else: echo "" ;endif; ?>
		</div>
	</aside>
	<div class="dislpayArrow"><a class="pngfix" href="javascript:void(0);" onClick="displaynavbar(this)"></a></div>
	<section class="Hui-article-box">
		<div id="Hui-tabNav" class="Hui-tabNav">
			<div class="Hui-tabNav-wp">
				<ul id="min_title_list" class="acrossTab cl">
					<li class="active"><span title="我的桌面" data-href="<?php echo U('Index/welcome');?>">我的桌面</span><em></em></li>
				</ul>
			</div>
			<div class="Hui-tabNav-more btn-group"><a id="js-tabNav-prev" class="btn radius btn-default size-S" href="javascript:;"><i class="Hui-iconfont">&#xe6d4;</i></a><a id="js-tabNav-next" class="btn radius btn-default size-S" href="javascript:;"><i class="Hui-iconfont">&#xe6d7;</i></a></div>
		</div>
		<div id="iframe_box" class="Hui-article">
			<div class="show_iframe">
				<div style="display:none" class="loading"></div>
				<iframe scrolling="yes" frameborder="0" src="<?php echo U('Index/welcome');?>"></iframe>
			</div>
		</div>
	</section>
	<script type="text/javascript" src="/Public/Admin/lib/jquery/1.9.1/jquery.min.js"></script> 
	<script type="text/javascript" src="/Public/Admin/lib/layer/2.1/layer.js"></script> 
	<script type="text/javascript" src="/Public/Admin/js/H-ui.js"></script> 
	<script type="text/javascript" src="/Public/Admin/js/H-ui.admin.js"></script> 
	<script type="text/javascript">
	// 整个页面的弹框
	function article_add(title,url){
		var index = layer.open({
			type: 2,
			title: title,
			content: url
		});
		layer.full(index);
	}

	// 小窗口弹框
	function admin_upload(title,url){
		layer_show(title,url);
	}

	function login_session(obj){
		$.ajax({
			url : '<?php echo U("Api/login_session");?>',
			type : 'POST',
			success:function(data){
				if(data.status == 1){
					window.top.location.reload();
				}
			}
		});
	}
	</script>
</body>
</html>