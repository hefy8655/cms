<?php
namespace Home\Model;
use Think\Model\RelationModel;

class CategoryModel extends RelationModel{
     /**
     * 处理查询数据
     * @param  
     */
    public function listCate($cid='null'){
        if(!$cid){
            return false;
        }
        $where['id'] = $cid; 
        $DB_PREFIX = C('DB_PREFIX');
        $result = $this
                ->db(1,DB_NAME)
                ->join('LEFT JOIN '.$DB_PREFIX.'category cate ON '.$DB_PREFIX.'category.cid = cate.id')
                ->field('cate.name name1,'.$DB_PREFIX.'category.name name2')
                ->find();
        
        return $result;
    }

    /**
     * 首页分类列表
     */
    public function getCate(){
        if(S('r_category_'.DB_NAME)){
        // if(false){
            $_data = S('r_category_'.DB_NAME);
        }else{
            $catelist = $this
                        ->db(1,DB_NAME)
                        ->order('order_number desc,createtime desc,id desc')
                        ->field('order_number,id,name,createtime,pid')
                        ->select();
            $_data = array();
            if($catelist){
                $catelist = catTree($catelist);
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
                foreach ($data as $key => $value) {
                    $_data[] = $value;
                }
                unset($data);
            }
            S('r_category_'.DB_NAME,$_data);
        }
        return $_data;
    }
}