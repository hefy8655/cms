<?php
namespace Admin\Controller;
use Think\Controller;

class ContentController extends BaseController {
//******************域名管理*********************** 
    //域名列表
    public function content_index(){
        $create_time = date_range(I('get.datemin'),I('get.datemax'));
        if(!empty($create_time))
            $where['create_time'] = $create_time;
        
        $title = I('get.title');
        if(!empty($title))
            $where['title'] = array('like','%'.$title.'%');
        
        $pid = I('get.pid');
        if(!empty($pid))
            $where['cate2.id'] = $pid;
            
        $DB_PREFIX = C('DB_PREFIX');
        $list = M('content')
                ->db(1,DB_NAME)
                ->join('LEFT JOIN '.$DB_PREFIX.'category cate ON '.$DB_PREFIX.'content.cid = cate.id')
                ->join('LEFT JOIN '.$DB_PREFIX.'category cate2 ON cate.pid = cate2.id')
                ->where($where)
                ->field($DB_PREFIX.'content.title,cate.name as small_name,cate2.name as big_name,'.$DB_PREFIX.'content.create_time,'.$DB_PREFIX.'content.id')
                ->order($DB_PREFIX.'content.create_time DESC')
                ->select();
        $cate = M('Category')->db(1,DB_NAME)->where(['pid'=>0])->field('id,name')->select();
                
        $count = count($list);
        $this->assign('list',$list);
        $this->assign('count',$count);
        $this->assign('title',$title);
        $this->assign('pid',$pid);
        $this->assign('cate',$cate);
        $this->display();
    }

    //修改状态和名字和排序和全部信息
    public function content_upload(){
        if(IS_AJAX){
            $data = I('post.');
            $result = getUploadsAdd('Content');
            if($result['status'] == 1){
                $data['cover'] = $result['info'][0];
            }else{
                unset($data['cover']);
            }
            $data['create_time'] = time();
            $data['content'] = trim($_POST['content']);
            $ajaxReturn = getSaveData('Content',$data);
            $this->ajaxReturn($ajaxReturn);
        }else{
            $catelist = M('Category')->db(1,DB_NAME)->select();
            $catelist = catTree($catelist);
            $this->assign('catelist',$catelist);

            $list = M('Content')->db(1,DB_NAME)->find(I('get.id'));
            $this->assign('list',$list);
            $this->display();
        }
    }

    //删除
    public function content_delete(){
        if(IS_AJAX){
            $id = I('post.id');
            $list = M('Content')->db(1,DB_NAME)->field('state,content')->find($id);
            if($list['state'] == 1){
                $ajaxReturn['info'] = $list['content'].'域名启用中，无法删除！';
                $ajaxReturn['status'] = 0;
            }else{
                D('Content')->db(1,DB_NAME)->setRedis();
                $ajaxReturn = getDeleteData('content',$id);
            }
            
            $this->ajaxReturn($ajaxReturn);
        }
    }

    //添加域名
    public function content_add(){
        if(IS_AJAX){
            $i = 0;
            $j = 0;
            $arr = array();
            $content = explode("\n",I('post.addcontent'));
            if($content){
                foreach ($content as $v){
                    $data['content'] = $v;
                    $result = D('Content')->db(1,DB_NAME)->uniquire($v);
                    if($result){
                        $arr[] = $v;
                        $j++;
                    }else {
                        $data['content'] = $v;
                        $data['create_time'] = time();
                        $data['state'] = 1;
                        $res = getAddData('content',$data);;
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
                D('Content')->db(1,DB_NAME)->setRedis();
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