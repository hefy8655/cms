<?php
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller {

	public function _initialize(){
        $DB_HOST = C('DB_HOST');//地址
        $DB_USER = C('DB_USER');//用户
        $DB_PWD  = C('DB_PWD');//密码
        $DB_PORT = C('DB_PORT');//端口 
        $db_name = 'cms_'.str_replace('.','_',trim($_SERVER['SERVER_NAME']));
        define('DB_NAME', 'mysql://'.$DB_USER.':'.$DB_PWD.'@'.$DB_HOST.':'.$DB_PORT.'/'.$db_name);
        $con=mysql_connect($DB_HOST,$DB_USER,$DB_PWD)or die("无法连接数据库服务器！");
        if(!mysql_select_db($db_name,$con)) {
            mysql_query("CREATE DATABASE ".$db_name)or die('创建数据库失败'.mysql_error());
            if(mysql_select_db($db_name,$con)){
                $_sql = file_get_contents('./Application/Admin/Conf/cscms.sql');
                $_arr = explode(';', $_sql);
                if($_arr){
                    foreach ($_arr as $v) {
                        if(!empty($v) && !mysql_query($v.';')){
                            echo '数据库创建失败----------------'.mysql_error();
                            $sql = 'DROP DATABASE '.$db_name;
                            $retval = mysql_query( $sql, $con );
                            if(! $retval )
                            {
                              die('Could not delete database: ' . mysql_error());
                            }
                            exit;
                        }
                    }
                }
            }
        }
    }
	//登录页面
	public function login(){
		if(IS_AJAX){
			$is_success = D('Admin')->db(1,DB_NAME)->login(I('post.username'),I('post.password'),I('post.captcha'));
			if($is_success['status']==1){
				$model = M('Baseinfo')->db(1,DB_NAME);
				$base = $model->find();
				$data['last_ip'] = $base['now_ip']?$base['now_ip']:'';
				$data['now_ip'] = $_SERVER['SERVER_ADDR'];
				$data['last_time'] = $base['now_time']?$base['now_time']:date('Y-m-d H:i:s',time());
				$data['now_time'] = date('Y-m-d H:i:s',time());
				$data['domain'] = $_SERVER['SERVER_NAME'];
				$data['login_num'] = $base['login_num']+1;
				if(isset($base['id'])){
					$data['id'] = $base['id'];
					$data['create_time'] = time();
	                $model->save($data);
				}else{
					$res = getAddData('baseinfo', $data);
				}
			}
			$this->ajaxReturn($is_success);
		}else{
			$this->display();
		}
	}

	//生成验证码
	public function VerifyCode(){
		$config = array(
			'fontSize' => 30,    // 验证码字体大小    
			'length'   => 3,     // 验证码位数   
			'useNoise' => false, // 关闭验证码杂点
			'useCurve' => false, // 是否使用混淆曲线 默认为true
		);
		$Verify = new \Think\Verify($config);
		$Verify->entry();
	}

	//退出
	public function LoginOut(){
		unset($_SESSION['admin']);//清除后台session
		redirect(U('Login/login'));
	}
}