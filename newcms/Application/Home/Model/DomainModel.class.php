<?php
namespace Home\Model;
use Think\Model\RelationModel;

class DomainModel extends RelationModel{

	public function getCache(){
		if(S('r_domain_'.DB_NAME)){
			$domain = S('r_domain_'.DB_NAME);
		}else{
			$domain = $this
					->db(1,DB_NAME)
					->where(['state'=>1])
                    ->order('create_time desc,id desc,domain desc')
                    ->field('domain,id,create_time')
                    ->find();
       		S('r_domain_'.DB_NAME,$domain);
		}
		if($domain){
			return [
				'info'=>$domain['domain'],
				'errorcode'=>0
			];
		}else{
			return ['errorcode'=>1001];
		}
	}
}