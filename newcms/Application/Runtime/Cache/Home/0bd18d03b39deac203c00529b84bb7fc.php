<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
 <head> 
  <title><?php echo ($content["title"]); ?></title> 
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
  <meta name="robots" content="all" /> 
  <meta name="keywords" content="<?php echo ($content["keywords"]); ?>" /> 
  <meta name="description" content="<?php echo ($content["description"]); ?>" /> 
  <link type="text/css" rel="stylesheet" href="/Public/Home/css/style.css?v=31" /> 
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
      </ul> 
    </div> 
  </div> 
</div> 
<div id="header_box"></div> 
<div id="top_box"></div> 
<div class="wrap mt20"> 
  <div class="box cat_pos clearfix"> 
    <span class="cat_pos_l">您的位置：
      <a href="/">首页</a>&nbsp;&nbsp;&raquo;&nbsp;&nbsp;
      <a href="<?php echo U('List/index',array('pid'=>$content[pid],'cid'=>$content[cid]));?>">
        <?php echo ($content["name"]); ?></a>&nbsp;&nbsp;&raquo;&nbsp;&nbsp;
      <h1>
        <a href="">
          <?php echo ($content["title"]); ?></a></h1>
    </span>
  </div> 
</div> 
<div class="wrap mt20"> 
  <div class="box pic_text"> 
    <div class="page_title"><?php echo ($content["title"]); ?></div> 
    <div id="pic_text_top"> 
      <div class="pic_text_box"> 
        <!-- <script type="text/javascript" language="javascript" src="/Public/Home/js/xn.js"></script>  -->
      </div> 
    </div> 
    <div class="content">   
      <?php echo ($content["content"]); ?>
      <div id="pic_text_bottom"></div>
      <div class="pic_text_box"></div>
      <ul>
        <span>上一篇: <?php if(empty($start) != true): ?><a href="<?php echo U('List/details',array('id'=>$start[id]));?>"><?php echo ($start[title]); ?></a><?php else: ?>没有了<?php endif; ?></span> 
        <span>下一篇: <?php if(empty($end) != true): ?><a href="<?php echo U('List/details',array('id'=>$end[id]));?>"><?php echo ($end[title]); ?></a><?php else: ?>没有了<?php endif; ?></span>
      </ul>
    </div>
  </div>
</div>
<script src="/Public/Home/js/jquery-1.10.2.min.js"></script>
<script>
  var video_cover = "<?php echo ($content["cover"]); ?>";
  var video = $('body').find('video');
  if(video){
    $.ajax({
      url:"<?php echo U('Common/getDomain');?>",//这里指向的就不再是页面了，而是一个方法。
      data:{},
      type:'post',
      success:function(data){
        if(data.errorcode=='0'){
          domain = 'http://'+data.info;
        }else{
          domain = '';
        }
        $.each(video,function(k,v){
          var html = '<iframe src="'+domain+'/Home/common/videoPlay?url='+video.eq(k).attr('src')+'&cover='+video_cover+'" style="border: 0;width:100%" onload="changeFrameHeight()" class="myiframe"></iframe>';
          video.eq(k).replaceWith(html);
        });
      }
    });
  }
  function changeFrameHeight(){
    $('.myiframe').css('height',document.documentElement.clientHeight*0.57);
  }

  window.onresize=function(){  
       changeFrameHeight();  
  } 
</script>

  <div id="top_sec" style="position: fixed;top: 76%;left: 84%;width: 50px;height: 50px;line-height: 50px;text-align: center;background: #d43686;opacity: 0.5;border-radius: 25px;color: #fff;font-size: 43px;display:none"><i class="iconfont icon-icon-test" style="font-size: 38px;"></i></div>
  <div id="top_box"> 
   <div class="wrap mt20 clearfix"> 
    <div class="box top_box"> 
     <!-- <script type="text/javascript" language="javascript" src="__PULIC__/Home/js/xx3.js"></script>  -->
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
      <!-- <script type="text/javascript" src="__PULIC__/Home/js/xxt.js?v=2" charset="gb2312"></script>  -->
      <!-- 统计 -->
      <!-- <div style="display:none">
       <script src="__PULIC__/Home/js/tj.js"></script>
      </div>  -->
      <script>
    // (function(){
    //     var bp = document.createElement('script');
    //     var curProtocol = window.location.protocol.split(':')[0];
    //     if (curProtocol === 'https') {
    //         bp.src = 'https://zz.bd/Public/Home.com/linksubmit/push.js';        
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