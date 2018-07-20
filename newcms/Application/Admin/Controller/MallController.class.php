<?php
namespace Admin\Controller;
use Think\Controller;

class MallController extends BaseController {
    public function admin_list(){
        $create_time = date_range(I('post.datemin'),I('post.datemax'));
        if(!empty($create_time))
            $where['create_time'] = $create_time;
        $username = I('post.username');
        if(!empty($username))
            $where['username'] = array('like','%'.$username.'%');

        $admin_list = M('admin')->db(1,DB_NAME)->where($where)->select();
        $count = count($admin_list);
        $this->assign('admin_list',$admin_list);
        $this->assign('count',$count);
        $this->display();
    }

    //添加
    public function admin_add(){
    	if(IS_POST){
    		$data = I('post.');
            $data['password'] = md5($data['password']);
            $data['create_time'] = time();

            $Adminbum = getUploadsAdd('Adminbum');
            if($Adminbum['status'] == 1){
                $data['image'] = $Adminbum['info'][0];
            }

            $is_success = M('admin')->db(1,DB_NAME)->add($data);
            if($is_success){
                $this->success('添加成功');
            }else{
                $this->error('添加失败');
            }
    		
    	}else{
    		$this->display();
    	}
    }

    //批量删除多个或者一个
    public function admin_delete(){
    	if(IS_AJAX){
    		$id = I('post.id');
            $state = M('admin')->db(1,DB_NAME)->where('id='.$id)->getField('state');
            if($state == 0){
                $ajaxReturn = getDeleteData('admin',$id);
            }else{
                $ajaxReturn['info'] = '请先关闭启用';
                $ajaxReturn['status'] = 0;
            }
            $this->ajaxReturn($ajaxReturn);
    	}
    }

    //修改状态
    public function admin_state(){
        if(IS_AJAX){
            $data['id'] = I('post.id');
            $data['state'] = I('post.state') == 1 ? 0 : 1;
            $text = $data['state'] == 1 ? '启用成功' : '禁用成功';

            $is_success = M('admin')->db(1,DB_NAME)->save($data);
            if($is_success){
                $ajaxReturn['info'] = $text;
                $ajaxReturn['state'] = $data['state'];
                $ajaxReturn['status'] = 1;         
            }else{
                $ajaxReturn['info'] = '状态修改失败';
                $ajaxReturn['status'] = 0;
            }
            $this->ajaxReturn($ajaxReturn);
        }
    }

    //修改密码
    public function admin_upload(){
        if(IS_AJAX){
            $data = I('post.');
            $admin = M('admin')->db(1,DB_NAME)->find($data['id']);
            if(!$admin){
                $this->error('不存在该管理员！');
            }elseif($data['pass'] == $data['password']){
                $this->error('密码未做任何修改！');
            }elseif(md5($data['pass']) != $admin['password']){
                $this->error('原密码错误！');
            }else{
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
            
            $this->ajaxReturn($ajaxReturn);
        }else{
            $this->id = I('get.id');
            $this->display(); 
        }
    }
}