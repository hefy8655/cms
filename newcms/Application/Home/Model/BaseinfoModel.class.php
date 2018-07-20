<?php
namespace Home\Model;
use Think\Model\RelationModel;

class BaseinfoModel extends RelationModel{
     /**
     * 处理查询数据
     * @param  
     */
    public function getCate(){
    	if(S('r_baseinfo_'.DB_NAME)){
            $_data = S('r_baseinfo_'.DB_NAME);
        }else{
	    	$_data = $this->db(1,DB_NAME)->find();
	        S('r_baseinfo_'.DB_NAME,$_data);
	    }
	    return $_data;
    }
}