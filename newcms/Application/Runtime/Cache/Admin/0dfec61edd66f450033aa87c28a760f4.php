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
<link href="/Public/Admin/css/H-ui.login.css" rel="stylesheet" type="text/css" />
<link href="/Public/Admin/css/style.css" rel="stylesheet" type="text/css" />
<link href="/Public/Admin/lib/Hui-iconfont/1.0.6/iconfont.css" rel="stylesheet" type="text/css" />
<!--[if IE 6]>
<script type="text/javascript" src="http://lib.h-ui.net/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<title>后台登录 - 后台管理</title>
</head>
<body>
<div class="header"><span>后台管理</span></div>
<div class="loginWraper">
  <div id="loginform" class="loginBox">
    <form class="form form-horizontal">
      <div class="row cl">
        <label class="form-label col-3"><i class="Hui-iconfont">&#xe60d;</i></label>
        <div class="formControls col-8">
          <input id="username" name="username" type="text" placeholder="账户" class="input-text size-L">
        </div>
      </div>
      <div class="row cl">
        <label class="form-label col-3"><i class="Hui-iconfont">&#xe60e;</i></label>
        <div class="formControls col-8">
          <input id="password" name="password" type="password" placeholder="密码" class="input-text size-L">
        </div>
      </div>
      <div class="row cl">
        <div class="formControls col-8 col-offset-3">
          <input id="captcha" name="captcha" class="input-text size-L" type="text" placeholder="验证码" onblur="if(this.value==''){this.value='验证码:'}" onclick="if(this.value=='验证码:'){this.value='';}" value="验证码:" style="width:150px;">
          <img src="/index.php/Admin/Login/VerifyCode" width="100px" height="40px" onclick= this.src="/index.php/Admin/Login/VerifyCode/"+Math.random() style="cursor: pointer;" title="看不清？点击更换另一个验证码。" />
        </div>
      </div>
      <div class="row">
        <div class="formControls col-8 col-offset-3">
          <input type="button" class="btn btn-success radius size-L login_button" value="&nbsp;登录&nbsp;">&nbsp; 
          <input type="reset" class="btn btn-default radius size-L" value="&nbsp;取消&nbsp;">
        </div>
      </div>
    </form>
  </div>
</div>
<div class="footer">网盟工作室 后台管理</div>
<script type="text/javascript" src="/Public/Admin/lib/jquery/1.9.1/jquery.min.js"></script> 
<script type="text/javascript" src="/Public/Admin/js/H-ui.js"></script>
<script type="text/javascript" src="/Public/Admin/lib/layer/2.1/layer.js"></script> 
</body>
</html>
<script type="text/javascript">
var confirm = true;
//自定义价格区间(键盘)
$(document).keydown(function(event){
  if(event.keyCode == 13){
    if(confirm)
      searchPrice();
  }
});

$('.login_button').click(function(){
    if(confirm)
      searchPrice();
});

function searchPrice(){
  var username = $('input[name="username"]').val();
  var password = $('input[name="password"]').val();
  var captcha = $('input[name="captcha"]').val();
  
  if(!username || !password || captcha == '验证码:'){
      layer.msg('请补全信息', {icon: 5,time:2000});
      return false;
  }

  $.ajax({
      url : '<?php echo U("Login/login");?>',
      type : 'POST',
      data : {
          username : username,
          password : password,
          captcha : captcha,
      },
      success : function(data){
        if(data.status == 1){
          layer.msg(data.info, {icon: 6,time:1000});
          confirm = false;
          setInterval(function(){location.href='<?php echo U("Index/index");?>';},1000);
        }else{
          layer.msg(data.info, {icon: 5,time:2000});
        }
      }
  });
}
</script>