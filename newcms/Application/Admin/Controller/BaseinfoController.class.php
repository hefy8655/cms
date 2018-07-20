<?php
namespace Admin\Controller;
use Think\Controller;

class BaseinfoController extends BaseController {

    public function base_index(){
        $basicList = M('Baseinfo')->db(1,DB_NAME)->find();
        $this->assign('basicList',$basicList);
        $this->display();
    }

    public function save(){
        if(IS_AJAX){
            $data = I('post.');
            switch ($data['type']) {
                case 0:
                    $info = M('Baseinfo');
                    $res = $info->db(1,DB_NAME)->find();
                    if($res){
                        $data['id'] = $res['id'];
                        $is_success = getSaveData('baseinfo',$data);
                        if($is_success['status']==1){
                            $res = M('baseinfo')->db(1,DB_NAME)->find();
                            S('r_baseinfo_'.DB_NAME,$res);
                            $is_success = true;
                        }else{
                            $is_success = false;
                        }
                    }else{
                        $is_success = $info->add($data);
                    }
                    if($is_success){
                        S('r_baseinfo_'.DB_NAME,$data);
                        $ajaxReturn['info'] = '提交成功';
                        $ajaxReturn['status'] = 1;
                    }else{
                        $ajaxReturn['info'] = '提交失败';
                        $ajaxReturn['status'] = 0;
                    }
                    break;
                case 1:
                    // $video_num = isset($data['video'])?htmlspecialchars(trim($data['video'])):0;
                    // $img_num   = isset($data['img'])?htmlspecialchars(trim($data['img'])):0;
                    // $story_num = isset($data['story'])?htmlspecialchars(trim($data['story'])):0;
                    // $DB_HOST   = '127.0.0.1';//htmlspecialchars(trim($data['IP']));
                    // $DB_USER   = 'root';//htmlspecialchars(trim($data['user']));
                    // $DB_PWD    = 'root';//htmlspecialchars(trim($data['password']));
                    // $DB_PORT   = 3306;

                    // $db_name = 'fileset';
                    // $data = array();
                    // if($video_num>0){
                    //     $model = M('video','f_','mysql://'.$DB_USER.':'.$DB_PWD.'@'.$DB_HOST.':'.$DB_PORT.'/'.$db_name);
                    //     $count_video = $model->count();  
                    //     if($count_video>0){
                    //         $data = array();
                    //         $mintime = date('Y-m-d H:i:s',strtotime('-1 month'));
                    //         $res = $model->field('source,content,title,keywords,description,cover_img')
                    //                 // ->where(['createtime'=>['EGT',$mintime]])->order('rand()')
                    //                 ->order('createtime desc')->limit($video_num)->select();
                    //         $data = array_merge($res,$data);
                    //     }
                    // }

                    // if($img_num>0){
                    //     $model = M('img','f_','mysql://'.$DB_USER.':'.$DB_PWD.'@'.$DB_HOST.':'.$DB_PORT.'/'.$db_name);
                    //     $count_img = $model->count();  
                    //     if($count_img>0){
                    //         $data = array();
                    //         $mintime = date('Y-m-d H:i:s',strtotime('-1 month'));
                    //         $res = $model->field('source,content,title,keywords,description')
                    //                 // ->where(['createtime'=>['EGT',$mintime]])->order('rand()')
                    //                 ->order('createtime desc')->limit($img_num)->select();
                    //         $data = array_merge($res,$data);
                    //     }
                    // }

                    // if($story_num>0){
                    //     $model = M('story','f_','mysql://'.$DB_USER.':'.$DB_PWD.'@'.$DB_HOST.':'.$DB_PORT.'/'.$db_name);
                    //     $count_img = $model->count();
                    //     if($count_img>0){
                    //         $data = array();
                    //         $mintime = date('Y-m-d H:i:s',strtotime('-1 month'));
                    //         $res = $model->field('source,content,title,keywords,description')
                    //                 // ->where(['createtime'=>['EGT',$mintime]])->order('rand()')
                    //                 ->order('createtime desc')->limit($story_num)->select();
                    //         $data = array_merge($res,$data);
                    //     }
                    // }
                    //将数据循环存入数据库
                    if($data){
                        $cate = M('Category');
                        foreach ($data as $v) {
                            switch ($v['big_type']) {
                                case '小说':
                                    $where['pid'] = 1;
                                    break;
                                case '视频':
                                    $where['pid'] = 2;
                                    break;
                                case '图片':
                                    $where['pid'] = 3;
                                    break;
                            }
                            $where['name'] = $v['small_type'];
                            $cate_res = $cate->field('id')->where($where)->find();
                            if($cate_res){
                                $v['cid'] = $cate_res['id'];
                                $v['pid'] = $where['pid'];
                                unset($v['small_type']);
                                unset($v['big_type']);
                                //保存图片，[img][video]转换
                                $v['content'] = extract_attrib($v['content']);
                                //<video src="https://gslb.miaopai.com/stream/jehV5Qxc2sQMFIwG1FqT4AD1BptWQSVV~IZEmQ__.mp4" controls="controls" style="width:80%">您的浏览器不支持 video 标签。</video>
                                $v['cover'] = isset($v['cover_img'])?downloadImage($v['cover_img']):'';
                                unset($v['cover_img']);

                                getAddData('content',$v);
                            }
                        }
                    }
                    break;
            }
            $this->ajaxReturn($ajaxReturn);
        }
    }

    /**
     * 从数据库中获取数据，每天获取一次
     * @return [type] [description]
     */
    public function getContent(){
        //第一步，判断数据库类型(story、img、video),连接数据集库并获取数据，用db()
        //第二步，将获取到的数据存进数据库并更新缓存
    }
}