<?php
namespace Admin\Controller;
use Think\Controller;

class DomainController extends BaseController {
//******************域名管理*********************** 
    //域名列表
    public function domain_index(){
        if(IS_AJAX){
            $data = I('get.');
            $data['where'] = json_decode(str_replace("&quot;", "\"", $data['where']),true);
            $data['orderArr'] = array(0=>'id', 1=>'domain', 2=>'create_time', 3=>'state');
            $list = D('Domain')->getData($data);
            $this->ajaxReturn($list);
        }
        $this->display();
    }

    //修改状态和名字和排序和全部信息
    public function domain_upload(){
        if(IS_AJAX){
            $intdata = I('post.');

            if($intdata['upload_type'] == 'ALL'){
                $data = $intdata;
                $text = '修改域名信息成功';                 
            }else{
                if($intdata['status'] != -1){
                    $data['state'] = $intdata['status'] == 1 ? 0 : 1;
                    $text = $data['state'] == 1 ? '启用成功' : '禁用成功';
                }else{
                    $res = D("domain")->db(1,DB_NAME)->uniquire($intdata['id'],$intdata['domain']);
                    if($res){
                        $ajaxReturn['info'] = '域名已存在';
                        $ajaxReturn['status'] = 0;
                        $this->ajaxReturn($ajaxReturn);
                    }
                    unset($intdata['status']);
                    $data = $intdata;
                    $text = '修改成功';
                }
                $data['create_time'] = time();
                $data['id'] = I('post.id');
            }
            $is_success = getSaveData('Domain',$data);
            if($is_success['status'] == 1){
                D('Domain')->db(1,DB_NAME)->setRedis();
                $ajaxReturn['info'] = $text;
                $ajaxReturn['type'] = $data['state'];
                $ajaxReturn['status'] = 1;         
            }else{
                $ajaxReturn['info'] = $is_success['info'];
                $ajaxReturn['status'] = 0;
            }
            $this->ajaxReturn($ajaxReturn);
        }else{
            $list = M('Domain')->db(1,DB_NAME)->find(I('get.id'));
            $this->assign('list',$list);
            $this->display();
        }
    }

    //删除
    public function domain_delete(){
        if(IS_AJAX){
            $id = I('post.id');
            $list = M('Domain')->db(1,DB_NAME)->field('state,domain')->find($id);
            if($list['state'] == 1){
                $ajaxReturn['info'] = $list['domain'].'域名启用中，无法删除！';
                $ajaxReturn['status'] = 0;
            }else{
                D('Domain')->db(1,DB_NAME)->setRedis();
                $ajaxReturn = getDeleteData('Domain',$id);
            }
            
            $this->ajaxReturn($ajaxReturn);
        }
    }

    //添加域名
    public function domain_add(){
        if(IS_AJAX){
            $i = 0;
            $j = 0;
            $arr = array();
            $domain = explode("\n",I('post.adddomain'));
            if($domain){
                foreach ($domain as $v){
                    $data['domain'] = $v;
                    $result = D('domain')->db(1,DB_NAME)->uniquire($v);
                    if($result){
                        $arr[] = $v;
                        $j++;
                    }else {
                        $data['domain'] = $v;
                        $data['create_time'] = time();
                        $data['state'] = 1;
                        $res = getAddData('Domain',$data);;
                        if($res){
                            $i++;
                        }else{
                            $j++;
                        }
                    }
                }
            }
            $info  = ($j>0)?',添加失败的描述如下：'.implode(',',$arr):'';
            if($i>0){
                D('Domain')->db(1,DB_NAME)->setRedis();
                $ajaxReturn = array('status'=>1,'info'=>'添加成功，一共添加了'.$i.'条数据，添加失败数据'.$j.'条'.$info);
            }else{
                $ajaxReturn = array('status'=>0,'info'=>'添加失败，添加失败数据'.$j.'条'.$info);
            }
            $this->ajaxReturn($ajaxReturn);
        }else{
            $this->display();
        }
    }
}