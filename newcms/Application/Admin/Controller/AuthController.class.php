<?php
namespace Admin\Controller;
use Think\Controller;

class AuthController extends BaseController {
//******************角色管理***********************   
    //角色管理(角色列表)
    public function admin_group(){
        if(IS_AJAX){
            $data = I('get.');
            $data['where'] = 'title|status|create_time';
            $data['orderArr'] = array(0=>'id', 1=>'title', 2=>'create_time', 3=>'status');
            $list = D('AuthGroup')->getData($data);
            $this->ajaxReturn($list);
        }
        $this->display();
    }

    //添加角色
    public function admin_group_add(){
        if(IS_AJAX){
            $data = I('post.');
            $data['create_time'] = time();
            $ajaxReturn = getAddData('auth_group',$data);
            $this->ajaxReturn($ajaxReturn);
        }else{
            $this->display();
        }
    }

    //角色删除
    public function admin_group_delete(){
        if(IS_AJAX){
            $id = I('post.id');
            $state = M('auth_group')->db(1,DB_NAME)->where('id='.$id)->getField('status');
            if($state){
                $ajaxReturn['info'] = '请先关闭启用';
                $ajaxReturn['status'] = 0;
            }else{
                $ajaxReturn = getDeleteData('auth_group',$id);
            }
            $this->ajaxReturn($ajaxReturn);
        }
    }

    //角色编辑
    public function admin_group_upload(){
        if(IS_AJAX){
            $data = I('post.');
            $ajaxReturn = getSaveData('auth_group',$data);
            $this->ajaxReturn($ajaxReturn);
        }else{
            $this->RuleList = M('auth_group')->find(I('get.id'));
            $this->display();
        }    
    }
//******************角色管理*********************** 

//******************权限管理*********************** 
    //权限列表
    public function admin_rule(){
        if(IS_AJAX){
            $data = I('get.');
            $data['defaultOrder'] = 'order_number';
            $data['handleData'] = 'catTree';
            $list = D('AuthRule')->getData($data);
            $this->ajaxReturn($list);
        }
        $AuthRuleList = M('AuthRule')->db(1,DB_NAME)->order('order_number')->select();
        $AuthRuleList = catTree($AuthRuleList);
        $this->assign('AuthRuleList',$AuthRuleList);
        $this->display();
    }

    //修改状态和名字和排序和全部信息
    public function admin_rule_upload(){
        if(IS_AJAX){
            $intdata = I('post.');

            if($intdata['upload_type'] == 'ALL'){
                $data = $intdata;
                $text = '修改权限信息成功';                 
            }else{
                if($intdata['status'] != -1){
                    $data['status'] = $intdata['status'] == 1 ? 0 : 1;
                    $text = $data['status'] == 1 ? '启用成功' : '禁用成功';
                }else{
                    unset($intdata['status']);
                    $data = $intdata;
                    $text = '修改成功';
                }
                $data['id'] = I('post.id');
            }

            $is_success = getSaveData('auth_rule',$data);
            if($is_success['status'] == 1){
                D('AuthRule')->saveChildNumber();
                $ajaxReturn['info'] = $text;
                $ajaxReturn['type'] = $data['status'];
                $ajaxReturn['status'] = 1;         
            }else{
                $ajaxReturn['info'] = $is_success['info'];
                $ajaxReturn['status'] = 0;
            }
            $this->ajaxReturn($ajaxReturn);
        }else{
            $AuthRuleList = M('AuthRule')->db(1,DB_NAME)->select();
            $AuthRuleList = catTree($AuthRuleList);
            $this->assign('AuthRuleList',$AuthRuleList);
            $this->RuleList = M('AuthRule')->db(1,DB_NAME)->find(I('get.id'));
            $this->display();
        }
    }

    //删除
    public function admin_rule_delete(){
        if(IS_AJAX){
            $id = I('post.id');
            $list = M('AuthRule')->db(1,DB_NAME)->field('id,pid,status,title')->find($id);

            $child = M('AuthRule')->db(1,DB_NAME)->where('pid='.$list['id'])->count();
            if($list['status'] == 1){
                $ajaxReturn['info'] = $list['title'].'权限启用中，无法删除！';
                $ajaxReturn['status'] = 0;
            }elseif($child > 0){
                $ajaxReturn['info'] = $list['title'].'权限中含有子权限<br/>请先删除它的子权限！';
                $ajaxReturn['status'] = 0;
            }else{
                $ajaxReturn = getDeleteData('AuthRule',$id);
                D('AuthRule')->saveChildNumber();
            }
            
            $this->ajaxReturn($ajaxReturn);
        }
    }

    //添加权限
    public function admin_rule_add(){
        if(IS_AJAX){
            $data = I('post.');
            $ajaxReturn = getAddData('AuthRule',$data);
            $ajaxReturn['data'] = $data;
            D('AuthRule')->saveChildNumber();
            $this->ajaxReturn($ajaxReturn);
        }else{
            $this->display();
        }
    }
//******************权限管理***********************

//******************为角色分配权限***********************
    public function admin_rule_group(){
        if(IS_AJAX){
            $data = I('post.');
            $data['rules'] = implode(',', $data['rule_ids']);
            //去除键值首位空格
            foreach ($data as $k => $v) {
                $data[$k]=trim($v);
            }
            unset($data['rule_ids']);
            if(D('AuthGroup')->save($data)){
                $ajaxReturn['info'] = '设置成功！';
                $ajaxReturn['status'] = 1;
            }else{
                $ajaxReturn['info'] = '设置失败！';
                $ajaxReturn['status'] = 0;
            }
            $this->ajaxReturn($ajaxReturn);
        }else{
            $id = I('get.id');
            // 获取用户组数据
            $group_data=M('Auth_group')->db(1,DB_NAME)->where(array('id'=>$id))->find();
            $group_data['rules']=explode(',', $group_data['rules']);
            // 获取规则数据
            $rule_data=D('AuthRule')->getTreeData('level','order_number','title');
            $assign=array(
                'group_data'=>$group_data,
                'rule_data'=>$rule_data
            );
            $this->assign($assign);
            $this->display();
        }
    }
//******************为角色分配权限***********************

//******************管理员管理*********************** 
    public function admin_list(){
        if(IS_AJAX){
            $data = I('get.');
            $data['where'] = 'username|create_time|group_id|state';
            $data['orderArr'] = array(0=>'id', 1=>'username', 2=>'group_id', 3=>'create_time');
            $data['field'] = 'id,username,create_time,state,group_id';
            $data['getField'] = array('AuthGroup|id,title');
            $list = D('admin')->getData($data);
            $this->ajaxReturn($list);
        }
        $where['id'] = array('gt',1);
        $this->AuthGroupList = M('AuthGroup')->db(1,DB_NAME)->where($where)->select();
        $this->display();
    }

    //添加
    public function admin_add(){
        if(IS_AJAX){
            $data = I('post.');
            $data['password'] = md5($data['password']);
            $data['create_time'] = time();
            $ajaxReturn = getAddData('admin',$data);
            if($ajaxReturn['status'] == 1){
                $access['uid'] = $ajaxReturn['ReturnID'];
                $access['group_id'] = $data['group_id'];
                getAddData('AuthGroupAccess',$access);
            }
            $this->ajaxReturn($ajaxReturn);
        }
    }

    //批量删除多个或者一个
    public function admin_delete(){
        if(IS_AJAX){
            $id = I('post.id');
            $where['id'] = array('eq',$id);
            $state = M('admin')->db(1,DB_NAME)->where($where)->getField('state');
            if($state == 0){
                M('AuthGroupAccess')->db(1,DB_NAME)->where("uid={$id}")->delete();
                $ajaxReturn = getDeleteData('admin',$id);
            }else{
                $ajaxReturn['info'] = '请先关闭启用';
                $ajaxReturn['status'] = 0;
            }
            $this->ajaxReturn($ajaxReturn);
        }
    }

    //修改资料
    public function admin_upload(){
        if(IS_AJAX){
            $data = I('post.');
            $admin = M('admin')->db(1,DB_NAME)->find($data['id']);
            if($data['upload_type'] == 'ALL'){
                if(!$admin){
                    $this->error('不存在该管理员！');
                }elseif($data['pass'] == $data['password']){
                    $this->error('密码未做任何修改！');
                }elseif(md5($data['pass']) != $admin['password']){
                    $this->error('原密码错误！');
                }else{
                    $AuthGroupAccess['uid'] = $data['id'];
                    if(M('AuthGroupAccess')->db(1,DB_NAME)->where($AuthGroupAccess)->delete()){
                        $access['uid'] = $data['id'];
                        $access['group_id'] = $data['group_id'];
                        getAddData('AuthGroupAccess',$access);
                    }

                    unset($data['pass'],$data['newpassword2']);
                    $data['password'] = md5($data['password']);
                    $is_success = M('admin')->db(1,DB_NAME)->save($data);

                    if(!$is_success)
                        $this->error('修改失败！');

                    if($data['id'] == $_SESSION['admin']['id']){
                        unset($_SESSION['admin']);//清除后台session
                        $ajaxReturn['info'] = '修改成功！';
                        $ajaxReturn['status'] = 2;
                    }else{
                        $ajaxReturn['info'] = '修改成功！';
                        $ajaxReturn['status'] = 1;
                    }
                }
            }else{
                $data['id'] = I('post.id');
                $data['state'] = I('post.state') == 1 ? 0 : 1;
                $text = $data['state'] == 1 ? '启用成功' : '禁用成功';

                $is_success = M('admin')->db(1,DB_NAME)->save($data);
                if($is_success){
                    $ajaxReturn['info'] = $text;
                    $ajaxReturn['status'] = 1;         
                }else{
                    $ajaxReturn['info'] = '状态修改失败';
                    $ajaxReturn['status'] = 0;
                }
            }
            
            $this->ajaxReturn($ajaxReturn);
        }else{
            $id = I('get.id');
            $this->adminList = M('admin')->db(1,DB_NAME)->field('id,group_id')->find($id);
            $where['id'] = array('gt',1);
            $this->AuthGroupList = M('AuthGroup')->db(1,DB_NAME)->where($where)->select();
            $this->display(); 
        }
    }
//******************管理员管理*********************** 
}