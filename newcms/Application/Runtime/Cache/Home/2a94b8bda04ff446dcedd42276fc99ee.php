<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<html>
 <head> 
  <title><?php echo ($baseinfo["title"]); ?></title> 
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
  <meta name="robots" content="all" /> 
  <meta name="keywords" content="<?php echo ($baseinfo["keywords"]); ?>" /> 
  <meta name="description" content="<?php echo ($baseinfo["description"]); ?>" /> 
  <link type="text/css" rel="stylesheet" href="/Public/Home/css/style.css?v=1401" /> 
 </head> 
 <body>
  <div class="nav_bar"> 
   <div class="wrap"> 
    <span class="domain"><a href="/"><b><font color="#ffffff" size="6"><script language="javascript">host = window.location.host;document.write(host)</script></font></b></a></span>
    <div class="nav_bar_r"> 
     <font color="#ffffff" size="4"><?php echo ($baseinfo["title"]); ?></font>
    </div> 
   </div> 
  </div> 
  <div id="top_box"> 
   <div class="wrap mt20 clearfix"> 
    <div class="box top_box"> 
     <ul> 
      <!-- <script type="text/javascript" language="javascript" src="/Public/Home/js/xx1.js"></script>  -->
     </ul> 
    </div> 
   </div> 
  </div> 
  <div id="header_box"> 
   <div class="wrap mt20 nav"> 
    <?php if(empty($data) != true): if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><ul class="nav_menu clearfix"> 
          <li><a href="<?php echo U('List/index',array('pid'=>$vo[id]));?>"><?php echo ($vo["name"]); ?></a></li> 
          <?php if(empty($vo.data) != true): if(is_array($vo["data"])): $i = 0; $__LIST__ = $vo["data"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo2): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('List/index',array('cid'=>$vo2[id],'pid'=>$vo[id]));?>"><?php echo ($vo2["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; endif; ?>
        </ul><?php endforeach; endif; else: echo "" ;endif; endif; ?>
   </div> 
  </div> 

  <div id="top_box"> 
   <div class="wrap mt20 clearfix"> 
    <div class="box top_box"> 
     <ul> 
      <!-- <script type="text/javascript" language="javascript" src="/Public/Home/js/xx2.js"></script>  -->
      <div class="l seach_tag">
       <strong>热门TAG：</strong>
       <a href="/">色色资源网</a>
       <a href="/">吉吉影音AV资源</a>
       <a href="/">色色AV资源</a>
       <a href="/">夜夜撸</a> 
      </div> 
     </ul> 
    </div> 
   </div> 
  </div>  
  <div class="wrap mt20"> 
   <div class="box movie_list"> 
    <div class="title">
     <b class="sp_pri movie_ico"></b>
     <h2>最新电影<font size="4">&nbsp;&nbsp;&nbsp;在线视频播放-无需安装播放器,仅支持平板,电脑设备播放</font>:<font color="#000080" size="5"><script language="javascript">host = window.location.host;document.write(host)</script></font></h2>
    </div> 
    <ul> 
	    <?php if(empty($content[2]) != true): if(is_array($content[2])): $i = 0; $__LIST__ = $content[2];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vv): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('List/details',array('id'=>$vv[id]));?>"> <img src="<?php echo ($vv["cover"]); ?>" /></a><h3><a><?php echo ($vv["title"]); ?><span class="movie_date"><?php echo (date("Y-m-d H:i:s",$vv["create_time"])); ?></span></a></h3></li><?php endforeach; endif; else: echo "" ;endif; endif; ?>
    </ul> 
   </div> 
   <!-- <script type="text/javascript" language="javascript" src="/Public/Home/js/xx4.js"></script>  -->
   <div class="wrap mt20 clearfix"> 
    <div class="box list box_left"> 
     <div class="title">
      <b class="sp_pri pic_ico"></b>
      <h2>最新图片&nbsp;&nbsp; <font size="4">收藏网址</font>：<font size="4"><script language="javascript">host = window.location.host;document.write(host)</script></font></h2>
     </div> 
     <ul> 
     	<?php if(empty($content[3]) != true): if(is_array($content[3])): $i = 0; $__LIST__ = $content[3];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vi): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('List/details',array('id'=>$vi[id]));?>"><span><?php echo (date("m-d",$vi["create_time"])); ?></span> <?php echo ($vi["title"]); ?> </a></li><?php endforeach; endif; else: echo "" ;endif; endif; ?>
     </ul> 
    </div> 
    <div class="box list box_right"> 
     <div class="title">
      <b class="sp_pri novel_ico"></b>
      <h2>最新小说&nbsp;&nbsp; <font size="4">收藏网址</font>：<font size="4"><script language="javascript">host = window.location.host;document.write(host)</script></font></h2>
     </div> 
      <ul> 
       <?php if(empty($content[1]) != true): if(is_array($content[1])): $i = 0; $__LIST__ = $content[1];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vs): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('List/details',array('id'=>$vs[id]));?>"><span><?php echo (date("m-d",$vs["create_time"])); ?></span> <?php echo ($vs["title"]); ?> </a></li><?php endforeach; endif; else: echo "" ;endif; endif; ?>
     </ul>
    </div> 
   </div> 
  </div> 

  <div id="top_sec" style="position: fixed;top: 76%;left: 84%;width: 50px;height: 50px;line-height: 50px;text-align: center;background: #d43686;opacity: 0.5;border-radius: 25px;color: #fff;font-size: 43px;display:none"><i class="iconfont icon-icon-test" style="font-size: 38px;"></i></div>
  <div id="top_box"> 
   <div class="wrap mt20 clearfix"> 
    <div class="box top_box"> 
     <!-- <script type="text/javascript" language="javascript" src="/Public/Home/js/xx3.js"></script>  -->
    </div> 
    <div class="wrap"> 
     <div class="copyright"> 
      <div style="line-height:50px"> 
       <div style="line-height:20px">
        <b> <a href="" style="text-decoration: none"> <font color="#000000">测试11111111111111 </font></a></b>
        <b> <a href=""><font color="#000000">搜狗</font></a></b> 
        <b><a href=""><font color="#000000">好搜</font></a></b>
        <b> <a href=""><font color="#000000">百度</font></a></b>
        <p></p>
        <div style="line-height:20px">
         <b>警告：本站禁止未滿18周歲訪客瀏覽,如果當地法律禁止請自覺離開本站！收藏本站：請使用Ctrl+D進行收藏</b> 
        </div>色色资源网,吉吉影音AV资源,色色AV资源，夜夜撸  
        <b>| 永久网址：<font color="#FF0000" size="3"><script language="javascript">host = window.location.host;document.write(host)</script></font></b> 
       </div> 
      </div> 
      <!-- <script type="text/javascript" src="/Public/Home/js/xxt.js?v=2" charset="gb2312"></script>  -->
      <!-- 统计 -->
      <!-- <div style="display:none">
       <script src="/Public/Home/js/tj.js"></script>
      </div>  -->
      <script>
		// (function(){
		//     var bp = document.createElement('script');
		//     var curProtocol = window.location.protocol.split(':')[0];
		//     if (curProtocol === 'https') {
		//         bp.src = 'https://zz.bd/media.com/linksubmit/push.js';        
		//     }
		//     else {
		//         bp.src = 'http://push.zhanzhang.baidu.com/push.js';
		//     }
		//     var s = document.getElementsByTagName("script")[0];
		//     s.parentNode.insertBefore(bp, s);
		// })();
		</script>  
     </div>
    </div>
   </div>
  </div>
 </body>
</html>