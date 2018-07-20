<?php
namespace Admin\Model;
use Think\Model\RelationModel;

class GetDataModel extends RelationModel{
     /**
     * 处理查询数据
     * @param  array $data 一维数组
     *         额外数据
     *         $data['where'] = 'username|create_time|group_id';//搜索条件
     *         $data['orderArr'] = array(1=>'id', 2=>'username', 3=>'group_id', 4=>'create_time');//排序条件
     *         $data['field'] = 'id,username,create_time,state,group_id';//显示字段
     *         $data['fieldType'] = false;//字段排除
     *         $data['getField'] = array('AuthGroup|id,title');//额外匹配数据
     *         $data['defaultOrder'] = 'create_time';//默认排序字段
     *         $data['handleData'] = 'catTree';//特殊处理方法
     * @return array       数据集
     */   
    public function getData($data){
        //获取Datatables发送的参数 必要
        $draw = $data['draw'];    //这个值直接返回给前台
        //获取时间区间
        $timeArr['mintime'] = $data['mintime'];
        $timeArr['maxtime'] = $data['maxtime'];
        $where = $this->dealTime($timeArr);
        //搜索框
        $search = $this->getSearch($data['search']['value'],$data['key']);   //获取前台传过来的过滤条件
        if(strlen($search) > 0) {
            // $where[$data['where']] = array('like','%'.$search.'%');
            $where[$data['where']] = array('eq',$search);
        }
        //定义查询数据总记录数sql
        $recordsTotal = $this->count();
        //定义过滤条件查询过滤后的记录数sql
        $recordsFiltered =  $this->where($where)->count();
        //排序条件
        $orderArr = $data['orderArr'];
        //设置默认排序字段
        $defaultOrder = empty($data['defaultOrder']) ? 'id' : $data['defaultOrder'];
        //获取要排序的字段
        $orderField = (empty($orderArr[$data['order']['0']['column']])) ? $defaultOrder : $orderArr[$data['order']['0']['column']];
        //需要空格,防止字符串连接在一块
        $order = $orderField.' '.$data['order']['0']['dir'];
        //按条件过滤找出记录
        $result = array();
        //备注:$data['start']起始条数    $data['length']查询长度
        $data['fieldType'] = $data['fieldType'] == true ? true : false;//字段排除
        $result = $this
                   ->db(1,DB_NAME)
                   ->field($data['field'],$data['fieldType'])
                   ->where($where)
                   ->order($order)
                   ->limit(intval($data['start']), intval($data['length']))
                   ->select();

        //使用特殊方法处理数据
        $result = (empty($data['handleData'])) ? $result : $this->getHandleData($result,$data['handleData']);

        //处理数据
        if(!empty($result)) {
            foreach ($result as $key => $value) {
                $result[$key]['create_time'] = empty($value['create_time']) ? '无' : date("Y-m-d H:i:s",$value['create_time']);
                $result[$key]['getField'] = $this->getStrip($data['getField']);
                $result[$key]['recordsFiltered'] = $recordsFiltered;
            }
        }

        //拼接要返回的数据
        $list = array(
            "draw" => intval($draw),
            "recordsTotal" => intval($recordsTotal),
            "recordsFiltered"=>intval($recordsFiltered),
            "data" => $result,
        );
        return $list;
    }

    /**
     * 处理查询时间段
     * @param  array $data 时间段
     * @return array       搜索时间段
     */
    private function dealTime($data){
        //处理最小时间
        if($data['mintime'] == '') $data['mintime'] = 0; else $data['mintime'] = strtotime($data['mintime']);
        //处理最大时间(当前时间)
        if ($data['maxtime'] == '') $data['maxtime'] = time(); else $data['maxtime'] = strtotime($data['maxtime'])+3600*24;
        $data['create_time'] = array('between', array($data['mintime'], $data['maxtime']));
        //清除没用的东西(防止条件报错)
        unset($data['mintime']);
        unset($data['maxtime']);
        return $data;
    }

    /**
     * 返回额外的数据
     * @param  array $data 格式 array('数据表1|字段1,字段2','数据表2|字段1,字段2');
     * @return array       数据集
     */   
    private function getStrip($data){
        $cacheArray = array();
        for ($i=0; $i < count($data); $i++) {
            if(!empty(strstr($data[$i], '|'))){
                $getExplode = explode('|', $data[$i]);
                $cacheArray[$getExplode[0]] = (!empty($getExplode[0]) && !empty($getExplode[1])) ? M($getExplode[0])->getField($getExplode[1],true) : array();
            }else{
                continue;
            }
        }
        return $cacheArray;
    }

    /**
     * 处理查询条件
     * @param  string $data 搜索值
     * @return string       处理后的值
     */
    private function getSearch($data,$key){
        $getSearch = F('getSearch');
        //是否有缓存文件，是否有这个键
        return (!empty($getSearch[$key]) && array_key_exists($data,$getSearch[$key])) ? trim($getSearch[$key][$data]) : trim($data);
    }


    /**
     * 使用特殊方法处理数据
     * @param  array    $result 原本数据
     * @param  string   $type   处理方法名
     * @return array    返回新的数据
     */
    private function getHandleData($result,$type){
        switch ($type) {
            //处理无限极分类
            case 'catTree':
                $getHandleData = catTree($result);
                break;
            default:
                $getHandleData = $result;
                break;
        }
        return $getHandleData;
    }

}