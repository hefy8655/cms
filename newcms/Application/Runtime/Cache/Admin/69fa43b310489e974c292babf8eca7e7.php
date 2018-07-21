<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<!--[if lt IE 9]>
<script type="text/javascript" src="lib/html5.js"></script>
<script type="text/javascript" src="lib/respond.min.js"></script>
<script type="text/javascript" src="lib/PIE_IE678.js"></script>
<![endif]-->
<link href="/Public/Admin/css/H-ui.min.css" rel="stylesheet" type="text/css" />
<link href="/Public/Admin/css/H-ui.admin.css?v=2" rel="stylesheet" type="text/css" />

<link href="/Public/Admin/lib/Hui-iconfont/1.0.6/iconfont.css" rel="stylesheet" type="text/css" />
<!--[if IE 6]>
<script type="text/javascript" src="lib/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<title>我的桌面</title>
</head>
<body>
<div class="page-container" style="margin: 20px;">
	<p class="f-20 text-success">欢迎 <?php echo ($AdminInfo["username"]); ?> 到来！</p>
	<p>登录次数：<?php echo ($baseinfo["login_num"]); ?> </p>
	<p>上次登录IP：<?php echo ($baseinfo["last_ip"]); ?>  上次登录时间：<?php echo ($baseinfo["last_time"]); ?></p>
	<table class="table table-border table-bordered table-bg mt-20">
		<thead>
			<tr>
				<th colspan="2" scope="col">服务器信息</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>网站标题</td>
				<td><?php echo ($baseinfo["title"]); ?></td>
			</tr>
			<tr>
				<td>网站关键字</td>
				<td><?php echo ($baseinfo["keywords"]); ?></td>
			</tr>
			<tr>
				<td>网站描述</td>
				<td><?php echo ($baseinfo["description"]); ?></td>
			</tr>
			<tr>
				<td>服务器IP地址</td>
				<td><?php echo ($baseinfo["now_ip"]); ?></td>
			</tr>
			<tr>
				<td>服务器域名</td>
				<td><?php echo ($sys_info["domain"]); ?></td>
			</tr>
			<tr>
				<td>服务器端口 </td>
				<td><?php echo ($sys_info["post"]); ?></td>
			</tr>
			<tr>
				<td>服务器IIS版本 </td>
				<td><?php echo ($sys_info["web_server"]); ?></td>
			</tr>
			<tr>
				<td>服务器操作系统 </td>
				<td><?php echo ($sys_info["os"]); ?></td>
			</tr>
			<tr>
				<td>系统所在文件夹 </td>
				<td>C:\WINDOWS\system32</td>
			</tr>
			<tr>
				<td>服务器脚本超时时间 </td>
				<td><?php echo ($sys_info["max_ex_time"]); ?></td>
			</tr>
<!-- 			<tr>
				<td>服务器的语言种类 </td>
				<td>Chinese (People's Republic of China)</td>
			</tr>
			<tr>
				<td>.NET Framework 版本 </td>
				<td>2.050727.3655</td>
			</tr>
			<tr>
				<td>服务器当前时间 </td>
				<td>2014-6-14 12:06:23</td>
			</tr>
			<tr>
				<td>服务器IE版本 </td>
				<td>6.0000</td>
			</tr>
			<tr>
				<td>服务器上次启动到现在已运行 </td>
				<td>7210分钟</td>
			</tr>
			<tr>
				<td>逻辑驱动器 </td>
				<td>C:\D:\</td>
			</tr>
			<tr>
				<td>CPU 总数 </td>
				<td>4</td>
			</tr>
			<tr>
				<td>CPU 类型 </td>
				<td>x86 Family 6 Model 42 Stepping 1, GenuineIntel</td>
			</tr>
			<tr>
				<td>虚拟内存 </td>
				<td>52480M</td>
			</tr>
			<tr>
				<td>当前程序占用内存 </td>
				<td>3.29M</td>
			</tr>
			<tr>
				<td>Asp.net所占内存 </td>
				<td>51.46M</td>
			</tr>
			<tr>
				<td>当前Session数量 </td>
				<td>8</td>
			</tr>
			<tr>
				<td>当前SessionID </td>
				<td>gznhpwmp34004345jz2q3l45</td>
			</tr> -->
			<tr>
				<td>当前系统用户名 </td>
				<td><?php echo ($AdminInfo["username"]); ?></td>
			</tr>
			<tr>
				<td>数据库版本号 </td>
				<td><?php echo ($sys_info["mysql_version"]); ?></td>
			</tr>
		</tbody>
	</table>
</div>
<script type="text/javascript" src="/Public/Admin/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/Public/Admin/js/H-ui.js"></script>
</body>
</html>