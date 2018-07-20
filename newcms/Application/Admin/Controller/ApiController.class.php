<?php
namespace Admin\Controller;
use Think\Controller;

class ApiController extends Controller {

    /**
     * domain
     * content
     * source
     * title
     * keywords
     * description
     * big_type
     * small_type
     * @return [type] [description]
     */
    public function saveData(){
        $data = json_decode(file_get_contents('php://input'),true); 
        $category = D('Category');
        if(!isset($data['content']) || !isset($data['source'])){//内容和来源
            echo $category->encode_json(['code'=>'没有内容或来源数据']);
            exit;
        }

        if(!isset($data['title']) || !isset($data['keywords']) || !isset($data['description']) || !isset($data['big_type'])){//内容和来源
            echo $category->encode_json(['code'=>'没有内容或来源数据']);
            exit;
        }

        switch ($data['big_type']) {
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
        $where['name'] = $data['small_type'];
        $db_name = 'cms_'.str_replace('.','_',trim($_SERVER['HTTP_HOST']));
        $this->setDomain($db_name);//检测db_name数据库是否已存在，不存在则创建
        $continue = 'mysql://'.C('DB_USER').':'.C('DB_PWD').'@'.C('DB_HOST').':'.C('DB_PORT').'/'.$db_name;

        /**判断小分类里是否存在，不存在则保存小分类 --- 开始*/
        $cate_res = $category->db(3,$continue)->field('id')->where($where)->find();
        if($cate_res){
            $data['cid'] = $cate_res['id'];
        }else{
            $arr['pid'] = $where['pid'];
            $arr['name'] = $data['small_type'];
            $arr['order_number'] = '1';
            $arr['num'] = 0;
            $arr['createtime'] = time();
            $res = $category->db(3,$continue)->add($arr);
            if($res){
                $data['cid'] = $res;
            }else{
                echo $category->encode_json(['code'=>'小分类不存在,录入失败']);
                exit;
            }
        }
        unset($data['small_type']);
        unset($data['big_type']);
        $data['pid'] = $where['pid'];
        /**判断小分类里是否存在，不存在则保存小分类 --- 结束*/

        $model = M('content')->db(3,$continue);
        /**判断数据源是否已存在 --- 开始*/
        $res = $model->where("source='{$data['source']}'")->count();
        if($res>0){
            echo $category->encode_json(['code'=>'该数据来源已存在,录入失败']);
            exit;
        }
        /**判断数据源是否已存在 --- 结束*/

        /**图片，[img][video]转换*/
        $data['content'] = $category->extract_attrib($data['content']);
         /**保存图片*/
        $data['cover'] = $category->downloadImage($data['cover_img']);
        $data['create_time'] = time();
        $res = $model->add($data);
        unset($data['domain']);
        unset($data['cover_img']);
        if($res){
            /**分类字段num加一*/
            $category->db(3,$continue)->where(['id'=>$data['cid']])->setInc('num');
            echo $category->encode_json(['code'=>'ok']);
        }else{
            echo $category->encode_json(['code'=>'录入失败']);
        }
    }

    /**
     * 每个域名自动生成一个数据库
     */
    public function setDomain($db_name){
        $DB_HOST = C('DB_HOST');//地址
        $DB_USER = C('DB_USER');//用户
        $DB_PWD  = C('DB_PWD');//密码
        $DB_PORT = C('DB_PORT');//端口 

        $con=mysql_connect($DB_HOST,$DB_USER,$DB_PWD)or die("无法连接数据库服务器！");
        if(!mysql_select_db($db_name,$con)) {
            mysql_query("CREATE DATABASE ".$db_name)or die('创建数据库失败'.mysql_error());
            if(mysql_select_db($db_name,$con)){
                $_sql = file_get_contents('./Application/Admin/Conf/cscms.sql');
                $_arr = explode(';', $_sql);
                if($_arr){
                    foreach ($_arr as $v) {
                        if(!empty($v) && !mysql_query($v.';')){
                            echo '数据库创建失败;'.mysql_error();
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
            // $this->redirect('Login/login');
        // }else{
        //     echo $_SERVER['SERVER_NAME'].'域名下的数据库已存在';
        //     exit;
        }
    }

    /**
     * 获取系统信息
     * @return array 返回系统信息
     */
    public function get_sys_info(){
        $sys_info['post']           = $_SERVER['SERVER_PORT'];
        $sys_info['os']             = PHP_OS;//检查php运行环境
        $sys_info['zlib']           = function_exists('gzclose') ? 'YES' : 'NO';//zlib
        $sys_info['safe_mode']      = (boolean) ini_get('safe_mode') ? 'YES' : 'NO';//safe_mode = Off  php.ini是没有打开安全模式     
        $sys_info['timezone']       = function_exists("date_default_timezone_get") ? date_default_timezone_get() : "no_timezone";//返回脚本中所有日期/时间
        $sys_info['curl']           = function_exists('curl_init') ? 'YES' : 'NO';  
        $sys_info['web_server']     = $_SERVER['SERVER_SOFTWARE'];//服务器标识的字串 
        $sys_info['phpv']           = phpversion();
        $sys_info['ip']             = GetHostByName($_SERVER['SERVER_NAME']);
        $sys_info['fileupload']     = @ini_get('file_uploads') ? ini_get('upload_max_filesize') :'unknown';
        $sys_info['max_ex_time']    = @ini_get("max_execution_time").'s'; //脚本最大执行时间
        $sys_info['set_time_limit'] = function_exists("set_time_limit") ? true : false;
        $sys_info['domain']         = $_SERVER['HTTP_HOST'];
        $sys_info['memory_limit']   = ini_get('memory_limit');      
        $sys_info['version']        = file_get_contents('./Application/Admin/Conf/version.txt');
        $mysqlinfo = M()->query("SELECT VERSION() as version");
        $sys_info['mysql_version']  = $mysqlinfo[0]['version'];//数据库版本
        if(function_exists("gd_info")){//取得当前安装的 GD 库的信息
            $gd = gd_info();
            $sys_info['gdinfo']     = $gd['GD Version'];
        }else {
            $sys_info['gdinfo']     = "未知";
        }
        return $sys_info;
    }

    /**
     * 优化因没有session在右侧出新登录页面
     * @return array 状态值
     */
    public function login_session(){
        $admin = session('admin');
        if(!$admin)
            $this->ajaxReturn(array('status'=>1));
    }

    /**
     * 右下角提示框
     * @return html
     */
    public function tips(){
        $this->display('Index/tips');
    }

    /**
     * 生成查询缓存文件,用于GetDataModel->getSearch
     */
    public function addSearch(){
        //拼接键值对搜索条件
        $initial = array();

        //角色管理
        $authGroupTitle['启用'] = 1;
        $authGroupTitle['禁用'] = 0;
        $initial['auth_group'] = $authGroupTitle;

        //账户管理
        $adminTitle = M('AuthGroup')->getField('title,id',true); 
        $adminTitle['启用'] = 1;
        $adminTitle['禁用'] = 0;
        $initial['admin'] = $adminTitle;
        F('getSearch',$initial);
    }

}