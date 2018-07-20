<?php
namespace Admin\Model;
use Think\Model;

class CategoryModel extends GetDataModel{
    protected $_validate = array(
        // array(验证字段1,验证规则,错误提示,[验证条件,附加规则,验证时间]),
        array('name',  'require',  '分类不能为空!',     0),
        array('name',  '',         '分类已经存在！',    0,  'unique',   1),
    );
    
    /**
     * 获取全部数据
     * @param  string $type  tree获取树形结构 level获取层级结构
     * @param  string $order 排序方式
     * @return array         结构数据
     */
    public function getTreeData($type='tree',$order='',$name='name',$child='id',$parent='pid'){
        // 判断是否需要排序
        if(empty($order)){
            $data=$this->select();
        }else{
            $data=$this->order($order.' is null,'.$order)->select();
        }
        // 获取树形或者结构数据
        if($type=='tree'){
            $data=\Org\Nx\Data::tree($data,$name,$child,$parent);
        }elseif($type="level"){
            $data=\Org\Nx\Data::channelLevel($data,0,'&nbsp;',$child);
        }
        return $data;
    }
    
    /**
     * 更新子集数量
     * @return [type] [description]
     */
    public function saveChildNumber(){
        $AdminRuleList = $this->select();
        foreach ($AdminRuleList as $key => $value) {
            $ids = getChildList($AdminRuleList,$value['id']);
            $where['id'] = $value['id'];
            $data['num'] = count($ids);
            $this->where($where)->save($data);
        }
    }
    
    /**
     * 存入redis
     */
    public function setRedis(){
        $catelist = $this
        ->order('order_number desc,createtime desc,id desc')
        ->field('order_number,id,name,createtime,pid')
        ->select();
        $catelist = catTree($catelist);
        $data = array();
        foreach ($catelist as $k=>$v){
            if($v['level']==0){
                $data[$v['id']]['id'] = $v['id'];
                $data[$v['id']]['name'] = $v['name'];
                $data[$v['id']]['data'] = array();
            }else{
                if(count($data[$v['pid']]['data'])<8){
                    $data[$v['pid']]['data'][] = array('id'=>$v['id'],'name'=>$v['name']);
                }
            }
        }
        S('r_category_'.DB_NAME,$category);
    }

    private $regex_vr = "/\[video\].*?\[\/video\]/i";
    private $regex_video = "/\[video\](.*?)\[\/video\]/i";
    private $regex_ir = "/\[img\].*?\[\/img\]/i";
    private $regex_img = "/\[img\](.*?)\[\/img\]/i";

    /** 下载远程图片,保存图片到本地 */
    public function downloadImage($url, $path=''){
    	$path = '/Public/Uploads/Content/'.date('Y').'/'.date('m').'/'.date('d').'/';
        $root_file = dirname(dirname(dirname(dirname(__FILE__))));
        if (!is_dir($root_file.$path)) mkdir($root_file.$path,0777,true);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        $file = curl_exec($ch);
        curl_close($ch);
        if(!$file){
            return $url;
            exit;
        }
        $filename = uniqid().rand(1000,9999).'.jpg';//pathinfo($url, PATHINFO_BASENAME);
        $resource = fopen($root_file.$path . $filename, 'a+');
        fwrite($resource, $file);//fwrite(file,string,length)
        fclose($resource);
        return $path . $filename;
    }

    public function extract_attrib($tag) {
        if(preg_match_all($this->regex_video, $tag, $matches)){
            foreach ($matches['1'] as $v) {
                $tag = preg_replace($this->regex_vr,'<video src="'.$v.'" controls="controls" style="width:80%">您的浏览器不支持 video 标签。</video>',$tag,1);
            }
            unset($v);
        }

        if(preg_match_all($this->regex_img, $tag, $matches)){
            foreach ($matches['1'] as $v) {
                $file_name = $this->downloadImage($v);
                $tag = preg_replace($this->regex_ir,'<img src="'.$file_name.'">',$tag,1);
            }
            unset($v);
        }
        unset($matches);
        return $tag;
    }

    public function array_urlencode($data){
        $new_data = array();
        foreach($data as $key => $val){   // 这里我对键也进行了urlencode
            $new_data[urlencode($key)] = is_array($val) ? $this->array_urlencode($val) : urlencode($val);
        }
        return $new_data;
    }

    public function encode_json($str) {
      return urldecode( json_encode(  $this->array_urlencode($str) ) );
    }
}