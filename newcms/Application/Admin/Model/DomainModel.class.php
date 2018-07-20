<?php
namespace Admin\Model;
use Think\Model;

class DomainModel extends GetDataModel{
    protected $_validate = array(
        // array(验证字段1,验证规则,错误提示,[验证条件,附加规则,验证时间]),
        array('domain',  'require',  '域名不能为空!',     0),
        array('domain',  '',         '域名已经存在！',    0,  'unique',   1),
    );
    
    public function uniquire($data,$id='null'){
        $where['domain'] = ['eq',$data];
        if($id){
            $where['id'] = ['neq',$id];
        }
        $res = $this->where($where)->find();
        if($res){
            $res = true;
        }else{
            $res = false;
        }
        return $res;
    }
    
    /**
     * 鏇存柊redis
     */
    public function setRedis(){
        $list = $this->where(['state'=>1])
                    ->order('create_time desc,id desc,domain desc')
                    ->field('domain,id,create_time')
                    ->find();
       S('r_domain_'.DB_NAME,$list);
    }
}