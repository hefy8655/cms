<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<STYLE> 
	body { 
	SCROLLBAR-FACE-COLOR: rgb(10,236,209); //滚动条凸出部分的颜色 
	SCROLLBAR-HIGHLIGHT-COLOR: rgb(23,255,155);//滚动条空白部分的颜色 
	SCROLLBAR-SHADOW-COLOR: rgb(255,116,23);//立体滚动条阴影的颜色 
	SCROLLBAR-3DLIGHT-COLOR: rgb(66,93,127);//滚动条亮边的颜色 
	SCROLLBAR-ARROW-COLOR: rgb(93,232,255);//上下按钮上三角箭头的颜色 
	SCROLLBAR-TRACK-COLOR: rgb(255,70,130);//滚动条的背景颜色 
	SCROLLBAR-DARKSHADOW-COLOR: rgb(10,0,209);//滚动条强阴影的颜色 
	SCROLLBAR-BASE-COLOR: rgb(66,93,128)；//滚动条的基本颜色 
	} 
	</STYLE>
	<meta charset="UTF-8">
	<title>视频播放</title>
</head>
<body>
		<script type="text/javascript" src="/Public/Home/js/ckplayer.js"></script>
	  	<div id="video" style="width: 100%;padding-top:10px;"></div>
	  	<script type="text/javascript">
	  	var state = "<?php echo ($m3u8); ?>";
	    var videoObject = {
	      container: '#video', //容器的ID或className
	      variable: 'player',//播放函数名称
	      poster:'<?php echo ($cover); ?>',//封面图片
	      video: "<?php echo ($url); ?>",
	      html5m3u8:state
	      // autoplay:true,
	    };
	    var player = new ckplayer(videoObject);
	  	</script>
</body>
</html>