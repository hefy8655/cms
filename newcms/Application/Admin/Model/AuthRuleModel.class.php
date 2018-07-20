<?php
namespace Admin\Model;
use Think\Model;

class AuthRuleModel extends GetDataModel{
    protected $_validate = array(
        // array(验证字段1,验证规则,错误提示,[验证条件,附加规则,验证时间]),
        array('name',  'require',  '权限路径不能为空!',     0),
        array('name',  '',         '权限路径已经存在！',    0,  'unique',   1),
        array('title', 'require',  '权限名不能为空!',       0),
        array('title', '',         '权限名已经存在！',      0,  'unique',   3),
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
            $data['child_number'] = count($ids);
            $this->where($where)->save($data);
        }
    }
}