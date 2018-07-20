<?php
//配置文件最后（查询字典）
function searchDict($criteria, $dict, $returnField='value'){
    $arr = C($dict);
    if($returnField == 'value'){
        return $arr[$criteria];
    }else{
        return array_search($criteria, $arr);
    }
}


/** 
  * Auth权限控制 控制模板中操作功能的显示
  * @param rule string|array  需要验证的规则列表,支持逗号分隔的权限规则或索引数组
  * @param uid  int           认证用户的id
  * @return boolean           通过验证返回true;失败返回false
 */
function authCheck($rule){
	if($_SESSION['admin']['id'] == 1){
		return true;
	}else{
	    $auth = new \Think\Auth();
	    return $auth->check($rule,$_SESSION['admin']['id'])?true:false;
	}
}


/**
 * 添加数据
 * @param string $tableName 要添加的数据表
 * @param string $ids 要添加的数据
 * @return string 返回提示信息
 */
function getAddData($tableName, $data){
	if(!$tableName && !$data)
		return false;

	if(D($tableName)->create($data)){
		$is_success = D($tableName)->db(1,DB_NAME)->add();
		if($is_success){
			return array('info'=>'添加成功，提交中','status'=>'1','ReturnID'=>$is_success);
		}else{
			return array('info'=>'添加失败','status'=>'0');
		}
	}else{
		return array('info'=>D($tableName)->db(1,DB_NAME)->getError(),'status'=>'0');
	}
}


/**
 * 修改数据
 * @param string $tableName 要修改的数据表
 * @param string $ids 要修改的数据
 * @return string 返回提示信息
 */
function getSaveData($tableName, $data){
	if(!$tableName && !$data)
		return false;

	if(D($tableName)->create($data)){
		$is_success = D($tableName)->db(1,DB_NAME)->save();
		if($is_success){
			return array('info'=>'修改成功，提交中','status'=>'1','ReturnID'=>$is_success);
		}else{
			return array('info'=>'修改失败','status'=>'0','ReturnID'=>$is_success);
		}
	}else{
		return array('info'=>D($tableName)->db(1,DB_NAME)->getError(),'status'=>'0');
	}
}


/**
 * 批量删除与单个删除，
 * @param string $tableName 要删除的数据表
 * @param string $ids 要删除的id
 * @param int $type 1为要删除本地图片
 * @param string $field 存放的图片字段
 * @return string 返回提示信息
 */
function getDeleteData($tableName, $id, $type = 0, $field){
	if(!$tableName && !$id)
		return false;

	$where['id'] = array('in',$id);

    if($type == 1){    
        $pictureList = M($tableName)->db(1,DB_NAME)->where($where)->field($field)->select();
        foreach ($pictureList as $key => $value) {
            unlink($_SERVER['DOCUMENT_ROOT'].$value[$field]);
        }
    }

    // return $where;
    $is_success = M($tableName)->db(1,DB_NAME)->where($where)->delete();

	// $is_success = 1;
	if($is_success){
		return array('info'=>'成功删除'.$is_success.'条数据','status'=>'1','number'=>$is_success);
    }else{
        return array('info'=>'删除失败','number'=>$is_success);
    }
}




//无限极分类之六脉神剑
/**
 * 定义一个方法，对给定的数组，递归形成树
 * @param string $arr 分类数据表数据
 * @return string 返回其后代分类
 */
function catTree(array $arr,$pid = 0,$level = 0){
    if(!$arr)
        return false;

    static $tree = array();
    foreach ($arr as $k => $v){
        if ($v['pid'] == $pid){
            //说明找到，保存
            $v['level'] = $level; //保存当前分类的所在层级
            $tree[] = $v;
            //继续找
            catTree($arr,$v['id'],$level + 1);
        }
    }
    return $tree;
}


/**
 * 给定一个分类，找其后代分类的id，包括它自己
 * @param string $arr 分类数据表数据
 * @param string $id 要查询的ID
 * @return string 返回其后代分类ID
 */
function getChildIds(array $arr,$id){
	if(!$arr && !$id)
		return false;

	$list = catTree($arr,$id);
	$res = array();

	//把id追加到数组
	$res[] = $id;
	foreach ($list as $v){
		$res[] = $v['id'];
	}
	return $res;
}


/**
 * 给定一个分类，找其后代分类的id，不包括它自己
 * @param string $arr 分类数据表数据
 * @param string $id 要查询的ID
 * @return string 返回其后代分类ID
 */
function getChildIdsNotWo(array $arr,$id){
    if(!$arr && !$id)
        return false;

    $list = catTree($arr,$id);
    $res = array();

    //把id追加到数组
    foreach ($list as $v){
        $res[] = $v['id'];
    }
    return $res;
}


/**
 * 给定一个分类，找其后代分类，递归形成树
 * @param string $arr 分类数据表数据
 * @param string $id 要查询的ID
 * @return string 返回其后代分类
 */
function getChildTree(array $arr,$id){
	if(!$arr && !$id)
		return false;

	$list = catTree($arr,$id);
	$res = array();

	foreach ($list as $v){
		$res[] = $v;
	}
	return $res;
}


/**
 * 给定一个分类，找其后代分类，构造嵌套结构的多维数组
 * @param string $arr 分类数据表数据
 * @param string $id 要查询的ID
 * @return string 返回其后代分类
 */
function getChildList(array $arr,$id){
	if(!$arr && !$id)
		return false;

	$list = childList($arr,$id);
	$res = array();

	foreach ($list as $v){
		$res[] = $v;
	}
	return $res;
}


/**
 * 构造嵌套结构的多维数组
 * @param string $arr 分类数据表数据
 * @return string 返回其所有祖先分类信息
 */
function childList($arr,$pid = 0){
	if(!$arr)
		return false;

	$res = array();
	foreach ($arr as $v){
		if ($v['pid'] == $pid){
			//找到节点，接着继续找当前节点的所有子孙节点
			$v['child'] = childList($arr,$v['id']);
			$res[] = $v;
		}
	}
	return $res;
}


/**
 * 给定分类id，获取其所有祖先分类信息----迭代
 * @param string $tableName 数据表名
 * @param string $filetype 分类ID
 * @return string 返回其所有祖先分类信息
 */
function getParents($tableName,$id) {
	if(!$tableName && !$id)
		return false;

	$res = array();
	while($id) {
		$Category = M($tableName)->db(1,DB_NAME)->where("id =".$id)->find();
		$res[] = array(
			'id' => $Category['id'],
			'name' => $Category['name']
		);
		//改变条件
		$id = $Category['pid'];
	}
	return array_reverse($res);
}

/**
 * 前后台登录区分大小写
 * @param  string $tableName 数据库名
 * @param  string $field     查询字段(组合数组)
 * @param  string $postField 要比较的值
 * @param  string $where     查询条件(增加查询条件)
 * @return int               1或0
 */
function getStrcmp($tableName, $field, $postField, $where = " 1 = 1 "){
    $fields = M($tableName)->db(1,DB_NAME)->where($where)->getField($field,true);
    $count = 0;
    foreach ($fields as $key => $value) {
        if(strcmp($postField,$value) == 0)
            $count += 1;
    }
    return $count;
}

/**
 * 执行日期查询条件
 * @param string $int_datemin 第一个时间
 * @param string $int_datemax 第二个时间
 */
function date_range($int_datemin, $int_datemax){
    if(!empty($int_datemin) || !empty($int_datemax)){
        $datemin = strtotime($int_datemin);
        $datemax = strtotime($int_datemax);
        if($datemin == ''){
            $datemin = 0;
            $datemax = strtotime($int_datemax)+(3600 * 24);
        }elseif($datemax == ''){
            $datemax = time();
        }elseif(!empty($datemin) || !empty($datemax)){
            $datemax = strtotime($int_datemax)+(3600 * 24);
        }
        return array(array('EGT',$datemin),array('ELT',$datemax));
    }
} 

/**
 * 单文件 : 处理上传文件，并返回存放路径
 * @param string $folder 上传文件保存上级文件名
 * @param string $filetype 上传文件类型
 * @return string 以数组返回文件存储路径
 */
function getUploadsAdd($folder, $filetype = array('jpg', 'gif', 'png', 'jpeg')){
    if(!$folder)
        return false;

	$upload = new \Think\Upload();// 实例化上传类
	$upload->maxSize   =  6291456 ;// 设置附件上传大小
	$upload->exts      =  $filetype;// 设置附件上传类型
	$upload->rootPath  =  './Public/Uploads/'.$folder.'/'; // 设置附件上传根目录
	$upload->savePath  =  ''; // 设置附件上传（子）目录
	$upload->subType   =  'date';

    if (!file_exists($upload->rootPath)){
        mkdir ($upload->rootPath,0777,true);
    }
	$info = $upload->upload();
	if(!$info) {
	    $result['status'] = 0;
	    $result['info'] = $upload->getError();
	}else{
	    $result['status'] = 1;
	    foreach($info as $file){        
	        $result['info'][] = '/Public/Uploads/'.$folder.'/'.$file['savepath'].$file['savename'];    
	    }    
	}
	return $result;
}

/**
 * 导出Excel表格
 * @param unknown $columns    标题
 * @param unknown $exportlist 内容
 * @param string $file_name   文件名称
 */
function outputXlsHeader($columns,$exportlist,$filename="数据统计"){
    header("Content-type:text/html;charset=UTF-8;" );
    header('Content-Type: text/xls;');
    header("Content-type:application/vnd.ms-excel;charset=UTF-8;" );
    header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
    header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
    header('Expires:0');
    header('Pragma:public');
    $table_data = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
    $table_data .= '<head>';
    $table_data .= '<meta http-equiv="expires" content="Mon, 06 Jan 1999 00:00:01 GMT">';
    $table_data .= '<!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name></x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]-->';
    $table_data .= '</head>';
    $table_data .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
    $table_data .= '<table border="1">';
    $table_data .= '<tr>';
    foreach ($columns as $column){
        $height = empty($column['height']) ? 30 : $column['height'];
        $width = empty($column['width']) ? 100 : $column['width'];
        $table_data .="<td height='".$height."' width='".$width."'>".$column['title']."</td>";
    }
    $table_data .= '</tr>';
    $table_data .= '<tr>';
    foreach ($exportlist as $line){
        $len = count($columns);
        for ($i = 0; $i < $len; $i++) {
            $value = isset($line[$columns[$i]['field']]) ? $line[$columns[$i]['field']] : '';
            $table_data .= '<td>' . $value . '</td>';
        }
        $table_data .= '</tr>';
    }
    $table_data .='</table>';
    return $table_data;
}

function isMobile(){ 
    // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
    {
        return true;
    } 
    // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
    if (isset ($_SERVER['HTTP_VIA']))
    { 
        // 找不到为flase,否则为true
        return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
    } 
    // 脑残法，判断手机发送的客户端标志,兼容性有待提高
    if (isset ($_SERVER['HTTP_USER_AGENT']))
    {
        $clientkeywords = array ('nokia',
            'sony',
            'ericsson',
            'mot',
            'samsung',
            'htc',
            'sgh',
            'lg',
            'sharp',
            'sie-',
            'philips',
            'panasonic',
            'alcatel',
            'lenovo',
            'iphone',
            'ipod',
            'blackberry',
            'meizu',
            'android',
            'netfront',
            'symbian',
            'ucweb',
            'windowsce',
            'palm',
            'operamini',
            'operamobi',
            'openwave',
            'nexusone',
            'cldc',
            'midp',
            'wap',
            'mobile'
            ); 
        // 从HTTP_USER_AGENT中查找手机浏览器的关键字
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
        {
            return true;
        } 
    } 
    // 协议法，因为有可能不准确，放到最后判断
    if (isset ($_SERVER['HTTP_ACCEPT']))
    { 
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
        {
            return true;
        } 
    } 
    return false;
} 

function getPage($count,$num){
    $Page = new \Think\Page($count,$num);// 实例化分页类 传入总记录数和每页显示的记录数(25)
    $Page->setConfig('header', '<li class="rows">共<b>%TOTAL_ROW%</b>条记录 第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');  
    $Page->setConfig('prev', '上一页');  
    $Page->setConfig('next', '下一页');  
    $Page->setConfig('last', '末页');  
    $Page->setConfig('first', '首页');  
    $Page->lastSuffix = false;//最后一页不显示为总页数  
    $show = $Page->show();// 分页显示输出

    return $show;
}


/** 下载远程图片,保存图片到本地 ---- 开始*/
function downloadImage($url, $path='__PUBLIC__/Home/images/video_cover/'){
    if (!is_dir($path)) mkdir($path);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    $file = curl_exec($ch);
    curl_close($ch);

    $filename = uniqid().rand(1000,9999).'.jpg';//pathinfo($url, PATHINFO_BASENAME);
    $resource = fopen($path . $filename, 'a');
    fwrite($resource, $file);//fwrite(file,string,length)
    fclose($resource);

    return $path . $filename;
}

function extract_attrib($tag) {
    $regex_vr = "/\[video\].*?\[\/video\]/i";
    $regex_video = "/\[video\](.*?)\[\/video\]/i";
    $regex_ir = "/\[img\].*?\[\/img\]/i";
    $regex_img = "/\[img\](.*?)\[\/img\]/i";
    if(preg_match_all($regex_video, $tag, $matches)){
        foreach ($matches['1'] as $v) {
            $tag = preg_replace($regex_vr,'<video src="'.$v.'" controls="controls" style="width:80%">您的浏览器不支持 video 标签。</video>',$tag,1);
        }
        unset($v);
    }

    if(preg_match_all($regex_img, $tag, $matches)){
        foreach ($matches['1'] as $v) {
            $file_name = $downloadImage($v);
            $tag = preg_replace($regex_ir,'<img src="__PUBLIC__/Home/images/content/'.$file_name.'">',$tag,1);
        }
        unset($v);
    }
    unset($matches);
    return $tag;
}
/** 下载远程图片,保存图片到本地 ---- 结束*/