<?php
namespace Admin\Model;
use Think\Model;

class AdminNavModel extends GetDataModel{
    protected $_validate = array(
        // array(验证字段1,验证规则,错误提示,[验证条件,附加规则,验证时间]),
        array('name',  'require',  '菜单名不能为空!',     0),
        array('name',  '',         '菜单名已经存在！',    0,  'unique',   3),
        array('url',   'require',  '链接名不能为空!',     0),
        array('url',   '',         '链接名已经存在！',    0,  'unique',   1),
    );
    

    /**
     * 获取全部菜单
     * @param  string $type tree获取树形结构 level获取层级结构
     * @return array        结构数据
     */
    public function getTreeData($type='tree',$order=''){
        // 判断是否需要排序
        if(empty($order)){
            $data=$this->select();
        }else{
            $data=$this->order($order.' is null,'.$order)->select();
        }
        // 获取树形或者结构数据
        if($type=='tree'){
            $data=\Org\Nx\Data::tree($data,'name','id','pid');
        }elseif($type="level"){
            $data=\Org\Nx\Data::channelLevel($data,0,'&nbsp;','id');
            // 显示有权限的菜单
            $auth=new \Think\Auth();
            foreach ($data as $k => $v) {
                if ($auth->check($v['url'],$_SESSION['admin']['id']) || $_SESSION['admin']['id']==1) {
                    foreach ($v['_data'] as $m => $n) {
                        if(!$auth->check($n['url'],$_SESSION['admin']['id']) && $_SESSION['admin']['id']!=1){
                            unset($data[$k]['_data'][$m]);
                        }
                    }
                }else{
                    // 删除无权限的菜单
                    unset($data[$k]);
                }
            }
        }
        // dump($data);die;
        return $data;
    }


    /**
     * 更新子集数量
     * @return [type] [description]
     */
    public function saveChildNumber(){
        $AdminNavList = $this->select();
        foreach ($AdminNavList as $key => $value) {
            $ids = getChildList($AdminNavList,$value['id']);
            $where['id'] = $value['id'];
            $data['child_number'] = count($ids);
            $this->where($where)->save($data);
        }
    }
}