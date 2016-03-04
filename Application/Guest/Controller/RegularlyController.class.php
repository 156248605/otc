<?php 
namespace Guest\Controller;

use Think\Controller;

/**
 * 自动脚本控制器
 * Class ProductController
 * @package Guest\Controller
 * @author by shenjian
 */
class RegularlyController extends Controller {
	//取消60分钟 未确认申购的 订单
	public function cancelInvest(){
		$map['cod_ivs_status'] = 0;
		$map['dat_create'] = array('LT',date("Y-m-d H:i:s",time()-60*60));
		$list = M('cf_ivs')->field('id')->where($map)->select();
		// print_r($map);
		// print_r($list);
		foreach($list as $v){
			D('cf_ivs')->cancelInvest($v['id'],0);
		}
		echo date("Y-m-d H:i:s",time());
		echo "Auto Close Ivs_data is OK! ";
		echo "回收60分钟未签署的记录脚本.\n\r";
	}
	
	/**
	*发送确权文件  
	* param $type integer 1确权开始   2入金确权拾回和过户确权拾回   3赎回确权
	*/
	public function sendConfirm($type=1){ 
		ignore_user_abort(false);
		set_time_limit(0);
		header("Content-type: text/html;charset=utf-8");
		//无确权记录的交易记录  
		$datetime =date("Y-m-d H:i:s",time());
		$limit="2000";
		if($type==2){
			
			
			//过户准备（入金成功）的交易记录   
			$list = D('CfIvs')
								->field('t1.*')
								->table('__' . strtoupper('Cf_ivs'). '__ as t1')
								->join('__' . strtoupper('cf_ivs_right'). '__ as t2 ON  t1.id=t2.cf_ivs_id','left') 
								->where("(t2.step = 4   ) and t1.cod_ivs_status=1 and t1.operating = 1 ") //or t2.step = 9 过户失败状态
								->order()->select();  
			
			if(!empty($list)){
				foreach( array_chunk($list,$limit) as $key=>$val ){ 
					$ghreturn =  D('Cf_ivs_right')->startIvsRightByGh($val,0);
					if($ghreturn)echo "对".count($val)."条交易记录进行OTC发起确权过户提交<br/>";
				}
			}
			
			
			//入金准备（开户成功）的交易记录   
			$list = D('CfIvs')
								->field('t1.*')
								->table('__' . strtoupper('Cf_ivs'). '__ as t1')
								->join('__' . strtoupper('cf_ivs_right'). '__ as t2 ON  t1.id=t2.cf_ivs_id','left') 
								->where("( t2.step = 11   ) and t1.cod_ivs_status=1  and t1.operating = 1 ") //or t2.step = 14 入金失败状态
								->order()->select();  
			
			if(!empty($list)){
				foreach( array_chunk($list,$limit) as $key=>$val ){
					$rjreturn = D('Cf_ivs_right')->startIvsRightByRj($val,0);
					if($rjreturn)echo "对".count($val)."条交易记录进行OTC发起确权入金提交<br/>";
				}
				
			}
		}
		
		if($type==1){
			$list = D('CfIvs')
								->field('t1.*')
								->table('__' . strtoupper('Cf_ivs'). '__ as t1')
								->join('__' . strtoupper('cf_ivs_right'). '__ as t2 ON  t1.id=t2.cf_ivs_id','left') 
								->where("(t2.id is null or t2.step = 1 ) and t1.cod_ivs_status=1  and t1.operating = 1") //or t2.step = 5 开户失败状态
								->order()->select();  
			
			if(!empty($list)){ 
				$tempCust = array();
				foreach( array_chunk($list,$limit) as $key=>$val ){
					$khreturn = D('Cf_ivs_right')->startIvsRightByKh($val,0,$tempCust); 
					$tempCust=$khreturn["tempCust"];
					if($khreturn["status"])echo "对".count($val)."条交易记录进行OTC发起确权开户提交<br/>";
				}
			}
		}
		
		if($type==3){
			$list = D('CfIvs')
								->field('b.*')
								->table('__' . strtoupper('Cf_ivs'). '__ as a')
								->join('__' . strtoupper('cf_ivs_redemption'). '__ as b ON  a.id = b.cod_cf_ivs_id','left') 
								->join('__' . strtoupper('cf_ivs_right'). '__ as c ON  a.id = c.cf_ivs_id and c.step = 8 ','inner') 
								
								->where("a.cod_ivs_status=2  and a.operating = 1") //or t2.step = 5 开户失败状态
								->order()->select();  
			
			if(!empty($list)){
				foreach( array_chunk($list,$limit) as $key=>$val ){
					$rjreturn = D('Cf_ivs_right')->startIvsRightByRj($val,0,2);
					if($rjreturn)echo "对".count($val)."条交易记录进行OTC发起赎回确权入金提交<br/>";
				}
				
			}
		}
		
	}
	
	
	
}


?>