<?php
namespace Guest\Model;

use Think\Log;
use Think\Model;

class CfIvsRightModel extends Model{
	public $status=array(
		"1"=>"开户准备",  //脚本自动跑 需要开户状态记录 （确认签署后 开户确权  or 开户失败）
		"2"=>"开户资料提交",   //KH文件发送成功后状态
		"3"=>"待开户",  //OTC确认KH文件收到后状态
		"11"=>"入金准备（开户成功）", //OTC脚本自动KB   开户成功后状态    脚本自动跑  需要入金状态记录  （OTC开户成功后 准备入金 or 入金失败）
		"5"=>"开户失败", //OTC脚本自动KB   开户失败后状态
		"12"=>"入金资料提交", //RJ文件发送成功后状态
		"13"=>"待入金", //OTC确认RJ文件收到后状态
		"14"=>"入金失败", //OTC脚本自动RB   入金失败后状态
		"4"=>"过户准备（入金成功）", //OTC脚本自动RB   开户成功后状态    脚本自动跑  需要过户状态记录  （OTC开户成功后 准备过户 or 过户失败）
		"6"=>"过户资料提交", 	//GH文件发送成功后状态
		"7"=>"待过户", //OTC确认GH文件收到后状态
		"8"=>"待对账(过户成功)",   //OTC脚本自动GB   过户成功后状态
		"9"=>"过户失败",  //OTC脚本自动GB    过户失败后状态
		"10"=>"确权成功", //OTC脚本自动DZ    对账成功后状态
	);
	static $right_status=array(
		'0'=>'待确权',
		'1'=>'确权中',
		'2'=>'确权成功',
		'3'=>'确权失败'
		);
	/*
	//创建确权记录
	// @param list  多条交易记录
	// $param mid   业务员操作ID 
	public function createIvsRight($list,$mid){
		//获取KH文件序号
		$kh_file_no = D('kh_dbf')->getFileNo();
		//获取GH文件序号
		// $gh_file_no = D('gh_dbf')->getFileNo();
		
		foreach($list as $cf_ivs_list){
			$data = array(
				'cf_ivs_id'=>$cf_ivs_list['id'],
				'status'=>1,
				'qqh_file'=>'',
				'usr_create'=>$mid,
				'dat_create'=>date("Y-m-d H:i:s",time()),
				'usr_modify'=>$mid,
				'dat_modify'=>date("Y-m-d H:i:s",time()),
			);
			$cf_ivs_right_id = $this->add($data);
			
			//获取用户信息
			$map['cod_cust_id'] = $cf_ivs_list['cod_cust_id'];
			$user = M('cust_person')->where($map)->find();
			
			//获取用户额外信息
			$info = M('cust_crm')->where($map)->find();
			
			//处理KHDBF
			$kh_dbf_id = D('kh_dbf')->createDbf($cf_ivs_list,$cf_ivs_right_id,$user,$info,$kh_file_no);
			//处理GHDEF
			$gh_dbf_id = D('gh_dbf')->createDbf($cf_ivs_list,$cf_ivs_right_id,$user,$info,$gh_file_no);
		}
		if($kh_dbf_id) D("Admin/Token")->ftp_upload($kh_dbf_id,"kh");
		if($gh_dbf_id) D("Admin/Token")->ftp_upload($gh_dbf_id,"gh");
	} */
	/* //创建确权记录
	// @param list  多条交易记录
	// $param mid   业务员操作ID 
	public function createIvsRight($list,$mid){
		//获取KH文件序号
		$kh_file_no = D('kh_dbf')->getFileNo(); 
		
		foreach($list as $cf_ivs_list){
			$data = array(
				'cf_ivs_id'=>$cf_ivs_list['id'],
				'status'=>1,
				'qqh_file'=>'',
				'usr_create'=>$mid,
				'dat_create'=>date("Y-m-d H:i:s",time()),
				'usr_modify'=>$mid,
				'dat_modify'=>date("Y-m-d H:i:s",time()),
			);
			$cf_ivs_right_id = $this->add($data);
			
			//获取用户信息
			$map['cod_cust_id'] = $cf_ivs_list['cod_cust_id'];
			$user = M('cust_person')->where($map)->find();
			
			//获取用户额外信息
			$info = M('cust_crm')->where($map)->find();
			 
			//处理KHDBF
			$kh_dbf_id = D('kh_dbf')->createDbf($cf_ivs_list,$cf_ivs_right_id,$user,$info,$kh_file_no); 
		}
		if($kh_dbf_id) D("Admin/Token")->ftp_upload($kh_dbf_id,"kh"); 
	} 
	//创建确权记录
	// @param list  多条交易记录
	// $param mid   业务员操作ID 
	public function createIvsRight_GH($list,$mid){ 
		//获取GH文件序号
		$gh_file_no = D('gh_dbf')->getFileNo();
		
		foreach($list as $cf_ivs_list){ 
			$ivs_right_result= $this->field("id,step")->where(array('cf_ivs_id'=>$cf_ivs_list['id']))->find();
			if($ivs_right_result){//已有确权记录 
				 $cf_ivs_right_id = $ivs_right_result['id']; 
			}else{ 
				continue;
			} 
			
			
			
			//获取用户信息
			$map['cod_cust_id'] = $cf_ivs_list['cod_cust_id'];
			$user = M('cust_person')->where($map)->find();
			
			//获取用户额外信息
			$info = M('cust_crm')->where($map)->find();
			 
			//处理GHDEF
			$gh_dbf_id = D('gh_dbf')->createDbf($cf_ivs_list,$cf_ivs_right_id,$user,$info,$gh_file_no);
		}
		if($gh_dbf_id) D("Admin/Token")->ftp_upload($gh_dbf_id,"gh");
	} */
	
	//  确权开始 开户操作
	// @param list  多条交易记录
	// $param mid   业务员操作ID 
	public function startIvsRightByKh($list,$mid,$tempCust=array()){
		//获取KH文件序号
		$kh_file_no = D('kh_dbf')->getFileNo(); 
		
		foreach($list as $item=> $cf_ivs_list){
			$ivs_right_result= $this->field("id,step")->where(array('cf_ivs_id'=>$cf_ivs_list['id']))->find();
			if($ivs_right_result){//已有确权记录 
				if($ivs_right_result['step'] ==1||$ivs_right_result['step'] ==5){ //处于过户准备状态 或者过户失败
					$cf_ivs_right_id = $ivs_right_result['id'];
				}else{ //跳过非开户准备的记录
					continue;
				}
			}else{//新确权
				$data = array(
					'cf_ivs_id'=>$cf_ivs_list['id'],
					'status'=>1,
					'step'=>1,
					'qqh_file'=>'',
					'usr_create'=>$mid,
					'dat_create'=>date("Y-m-d H:i:s",time()),
					'usr_modify'=>$mid,
					'dat_modify'=>date("Y-m-d H:i:s",time()),
				);
				$cf_ivs_right_id = $this->add($data);
			}
			//清楚历史开户的作废记录
			// D("KhDbf")->clearGhData($cf_ivs_right_id,1);
			
			//获取客户信息
			$map['cod_cust_id'] = $cf_ivs_list['cod_cust_id'];
			$user = M('cust_person')->where($map)->find();
			//获取客户额外信息
			$info = M('cust_crm')->where($map)->find();
			
			$isupdate=false;
			if(in_array($cf_ivs_list['cod_cust_id'],$tempCust)){
				$isupdate=true;
			}else{
				$tempCust[] = $cf_ivs_list['cod_cust_id'];
			}
			// echo $item;
			// echo "<br/>";
			//处理KHDBF
			$temp_kh_dbf_id = D('kh_dbf')->createDbf($cf_ivs_list,$cf_ivs_right_id,$user,$info,$kh_file_no,$isupdate); 
			$kh_dbf_id = $temp_kh_dbf_id?$temp_kh_dbf_id:$kh_dbf_id; 
		} 
		// echo "<hr>";
		if($kh_dbf_id){
			return ["status"=>D("Admin/Token")->ftp_upload($kh_dbf_id,"kh"),"tempCust"=>$tempCust];
		}else{
			return ["status"=>false,"tempCust"=>$tempCust];
		}
		 
	} 
	
	// 确权开始 入金操作
	// @param list  多条交易记录
	// $param mid   业务员操作ID 
	// $param type   1 投资确权  2赎回确权 
	public function startIvsRightByRj($list,$mid,$type=1){
		// dump($list);
		
		//获取KH文件序号
		$gh_file_no = D('rj_dbf')->getFileNo(); 
		
		foreach($list as $cf_ivs_list){
			if($type==2){
				$ivs_right_result= $this->field("id,step")->where(array('cf_ivs_id'=>$cf_ivs_list['cod_cf_ivs_id']))->find();
			}else{
				$ivs_right_result= $this->field("id,step")->where(array('cf_ivs_id'=>$cf_ivs_list['id']))->find();
			}
			
			 			
			
			if($ivs_right_result){//已有确权记录 
				if($type==1&&($ivs_right_result['step'] ==11||$ivs_right_result['step'] ==14)){ //处于入金准备状态 或者入金失败
					$cf_ivs_right_id = $ivs_right_result['id'];
				}else if($type==2&&($ivs_right_result['step'] ==8)){ //处于入金准备状态 或者入金失败
					$this->where(array('id'=>$ivs_right_result['id'],'cf_ivs_id'=>$cf_ivs_list['cod_cf_ivs_id']))->save(array("cf_ivs_redemption_id"=>$cf_ivs_list['id']));
					$cf_ivs_right_id = $ivs_right_result['id'];
				}else{ //跳过非过户准备的记录
					continue;
				} 
			}else{  
				continue;
			}
			//清楚历史过户的作废记录
			// D("RjDbf")->clearGhData($cf_ivs_right_id,1);
			
			//获取客户信息
			$map['cod_cust_id'] = $cf_ivs_list['cod_cust_id'];
			$user = M('cust_person')->where($map)->find();
			
			//获取客户额外信息
			$info = M('cust_crm')->where($map)->find();
			//处理GHDEF
			$temp_rj_dbf_id = D('rj_dbf')->createDbf($cf_ivs_list,$cf_ivs_right_id,$user,$info,$gh_file_no,$type);
			$rj_dbf_id = $temp_rj_dbf_id?$temp_rj_dbf_id:$rj_dbf_id; 
		} 
		// dump($rj_dbf_id);
		// exit;
		if($rj_dbf_id){
			return D("Admin/Token")->ftp_upload($rj_dbf_id,"rj",$type);
		}else{
			return false;
		}
	} 
	
	// 确权开始 过户操作
	// @param list  多条交易记录
	// $param mid   业务员操作ID 
	public function startIvsRightByGh($list,$mid,$type=1){
		//获取KH文件序号
		$gh_file_no = D('gh_dbf')->getFileNo(); 
		
		foreach($list as $cf_ivs_list){
			if($type==2){
				$ivs_right_result= $this->field("id,step")->where(array('cf_ivs_id'=>$cf_ivs_list['cod_cf_ivs_id']))->find();
			}else{
				$ivs_right_result= $this->field("id,step")->where(array('cf_ivs_id'=>$cf_ivs_list['id']))->find();
			}
			 
			if($ivs_right_result){//已有确权记录 
				if($ivs_right_result['step'] ==4||$ivs_right_result['step'] ==9){ //处于过户准备状态 或者过户失败
					$cf_ivs_right_id = $ivs_right_result['id'];
				}else{ //跳过非过户准备的记录
					continue;
				} 
			}else{  
				continue;
			}
			//清楚历史过户的作废记录
			// D("GhDbf")->clearGhData($cf_ivs_right_id,1);
			
			//获取客户信息
			$map['cod_cust_id'] = $cf_ivs_list['cod_cust_id'];
			$user = M('cust_person')->where($map)->find();
			
			//获取客户额外信息
			$info = M('cust_crm')->where($map)->find();
			 
			//处理GHDEF
			$temp_gh_dbf_id = D('gh_dbf')->createDbf($cf_ivs_list,$cf_ivs_right_id,$user,$info,$gh_file_no,$type);
			$gh_dbf_id = $temp_gh_dbf_id?$temp_gh_dbf_id:$gh_dbf_id; 
		}
		if($gh_dbf_id){
			return D("Admin/Token")->ftp_upload($gh_dbf_id,"gh",$type);
		}else{
			return false;
		}
	} 
	
	
		/**
	 * 获取确权列表
	 */

	public function getRightList($condition,$curpage,$limit){
		$data['total'] =M('cf_ivs')
			->alias('a')->field('od.name as department_name,ou.realname as user_name,
		a.id,a.cod_ctl_id,cod_period,a.amt_ivs,a.ctl_ivs_cnt,a.amt_int_total,
		a.amt_fee_total,a.pos_order,a_right.status,e.step,a.dat_modify,IFNULL(e.cf_ivs_redemption_id,0) as cf_ivs_redemption_id,
		c.title,c.code,d.cod_period,b.nam_cust_real,b.cod_cust_id_no')
			->join('__CUST_PERSON__ b on a.cod_cust_id=b.cod_cust_id')
			->join('__CF_MAST__ c on a.cod_cf_id=c.id')
			->join('__CF_CTL__ d on a.cod_ctl_id=d.id','left')
			->join('__CF_IVS_RIGHT__ e on a.id=e.cf_ivs_id','left')
			->join('__USER__ as ou on ou.id=a.usr_create')//查用户名
			->join('__DEPARTMENT__ as od on ou.department_id= od.id')
			->where($condition)
			->count();
	$data['items'] = M('cf_ivs')
		->alias('a')->field('od.name as department_name,ou.realname as user_name,
		a.id,a.cod_ctl_id,cod_period,a.amt_ivs,a.ctl_ivs_cnt,a.amt_int_total,
		a.amt_fee_total,a.pos_order,e.status,e.step,a.dat_modify,e.qqh_file,IFNULL(e.cf_ivs_redemption_id,0) as cf_ivs_redemption_id,
		c.title,c.code,d.cod_period,b.nam_cust_real,b.cod_cust_id_no')
		->join('__CUST_PERSON__ b on a.cod_cust_id=b.cod_cust_id')
		->join('__CF_MAST__ c on a.cod_cf_id=c.id')
		->join('__CF_CTL__ d on a.cod_ctl_id=d.id','left')
		->join('__CF_IVS_RIGHT__ e on a.id=e.cf_ivs_id','left')
		->join('__USER__ as ou on ou.id=a.usr_create')//查用户名
		->join('__DEPARTMENT__ as od on ou.department_id= od.id')
		->order('a.dat_modify desc')
		->where($condition)
		->page($curpage,$limit)
		->select();
//	 $data['sql']=M()->_sql();
		foreach($data['items'] as $k=>$v){
    		$data['items'][$k]['product_code']=$data['items'][$k]['title'].$data['items'][$k]['cod_period']."期";
			if(is_null($data['items'][$k]['status']))
			{
				$data['items'][$k]['status']=0;
			}
			if(is_null($data['items'][$k]['step']))
				$data['items'][$k]['step']=0;
    		}
		

		return $data;
	}
	
	
	
}

?>