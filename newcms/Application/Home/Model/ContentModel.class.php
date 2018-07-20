<?php
namespace Home\Model;
use Think\Model\RelationModel;

class ContentModel extends RelationModel{
    /**
     * 处理查询数据
     * @param  
     */
    public function getDetails($id='null'){
        if(!$id){
            return false;
        }
        $DB_PREFIX = C('DB_PREFIX');
        $result = $this
                ->db(1,DB_NAME)
                ->join('LEFT JOIN '.$DB_PREFIX.'category cate ON '.$DB_PREFIX.'content.cid = cate.id')
                ->field('cate.name name,'.$DB_PREFIX.'content.title,'.$DB_PREFIX.'content.keywords,'.$DB_PREFIX.'content.description,'.$DB_PREFIX.'content.content,'.$DB_PREFIX.'content.id,'.$DB_PREFIX.'content.create_time,'.$DB_PREFIX.'content.cover,'.$DB_PREFIX.'content.pid,'.$DB_PREFIX.'content.cid')
                ->where([$DB_PREFIX.'content.id'=>$id])
                ->find();
        
        return $result;
    }

    /**
     * 获取内容数据
     * @param  
     */
    public function getCache($start=0,$num=0,$_data=''){
        $res = array();
        $data = array();
        if(false){
        // if(S('r_content_'.DB_NAME)){
            $data = S('r_content_'.DB_NAME);
        }else{
            $res = $this->db(1,DB_NAME)->field('pid')->group('pid')->select();
            if($res){
                foreach ($res as $key => $value) {
                    $data[$value['pid']] = $this->field('id,cid,title,cover,content,create_time,pid')->where(['pid'=>$value['pid']])->order('sort desc')->select();
                }
            }
            S('r_content_'.DB_NAME,$data);
        }       
        //查出某类型下第几页的数据
        if(isset($_data['pid'])){
            $pid_content = $data[$_data['pid']];

            if(S('r_category')){
                $category = S('r_category');
            }else{
                $category = D('Category')->getCate();
            }
            $new_arr = array_column($category,null,'id');
            if(isset($_data['cid'])){
                $arr = array();
               foreach ($pid_content as $key => $value) {
                   if($value['cid']==$_data['cid']){
                        $arr[] = $value;
                   }
               }
               $pid_content = $arr;
               unset($arr);
               $new_arr = array_column($new_arr[$_data['pid']]['data'],null,'id');//id作为键
               if(isset($new_arr[$_data['cid']])){
                    $data['name'] = $new_arr[$_data['cid']]['name'];
                }else{
                    $data['name'] = '';
                }
            }else{
                if(isset($new_arr[$_data['pid']])){
                    $data['name'] = $new_arr[$_data['pid']]['name'];
                }else{
                    $data['name'] = '';
                }
            }
            $data['count'] = count($pid_content);
            $data['content'] = array_splice($pid_content,$start,$num);
        }else{
            if($num>0){
                foreach ($data as $kt=>$vt) {
                    $data[$kt] = array_splice($vt,$start,$num);
                }
            }
        }
        return $data;
    }

    /**
     * 获取本记录下的前后各一条数据
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function getStartEnd($id){
        if(!$id){
            return false;
        }
        $sql = "SELECT id,title,pid,cid FROM c_content WHERE id in (SELECT case when SIGN(id-{$id})>0 THEN MIN(id) when SIGN(id-{$id})<0 THEN MAX(id) end FROM c_content WHERE id !={$id} GROUP BY SIGN(id-{$id}) ORDER BY SIGN(id-{$id})) ORDER BY id";
        $res = $this->db(1,DB_NAME)->query($sql);
        $start = array();
        $end = array();
        if($res){
            if(isset($res['0'])){
                if($res['0']['id']>$id){
                    $end = $res['0'];
                }else{
                    $start = $res['0'];
                    if(isset($res['1'])){
                        $end = $res['1'];
                    }
                }
            }
        }

        return array('start'=>$start,'end'=>$end);
    }
}