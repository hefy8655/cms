<?php
namespace Admin\Controller;
use Think\Controller;

class BaseController extends Controller{
    //验证是否登陆
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

        $admin = session('admin');

        if(!$admin) redirect(U('Login/login'));
        $this->assign('AdminInfo',$admin);
        
        $auth = new \Think\Auth();
        $rule_name = MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME;
        $result = $auth->check($rule_name,$_SESSION['admin']['id']);
        if(!$result && $admin['id'] != 1){
            $this->error('您的权限不足');
        }
    }
}