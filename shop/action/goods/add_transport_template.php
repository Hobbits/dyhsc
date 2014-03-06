<?php
	/*
	***********************************************
	*$ID:csv_export
	*$NAME:csv_export
	*$AUTHOR:E.T.Wei
	*DATE:Wed Mar 24 10:31:49 CST 2010
	***********************************************
	*/
	if(!$IWEB_SHOP_IN) {
		die('Hacking attempt');
	}
	//文件引入
	require("foundation/module_goods.php");
	//引入语言包
	$m_langpackage=new moduleslp;
	//数据表定义区
	$t_transport_template = $tablePreStr."goods_transport";
	$t_transport = $tablePreStr."transport";
	//读写分类定义方法
	$dbo = new dbex;
	dbtarget("w",$dbServs);
	
	
	$shop_id = intval(get_args('shop_id'));
	$post = $_POST;
	if (!isset($post['transport_type'])) {
		action_return(0,$m_langpackage->m_search_type."!","modules.php?app=goods_list");
		exit;
	}
	$arr = array();
	$info['transport_name']=$post['transport_name'];
	$info['description'] = $post['description'];
	foreach ($post['transport_type'] as $k=>$v){
		$arr[$v]=array();
	}
	//查询开启的配送方式
	$sql = "select * from $t_transport where ifopen=1";
	$tran_list=$dbo->getRs($sql);
	//循环获得前台传来的值，通过tranid字段作为数组下标
	foreach ($tran_list as $val){
		$arr[$val['tranid']]['frist']=$post['frist'.$val['tranid']];
		$arr[$val['tranid']]['second']=$post['second'.$val['tranid']];
		if(isset($post['ord_item_dest'.$val['tranid']])){
			foreach ($post['ord_item_dest'.$val['tranid']] as $k=>$v){
				$v = substr($v,0,-1);
				$areaarr = explode(",",$v);
				foreach ($areaarr as $key=>$value){
					$arr[$val['tranid']][$value]=array("frist"=>$post['ord_area_frist'.$val['tranid']][$k],"second"=>$post['ord_area_second'.$val['tranid']][$k]);
				}
			}
		}
	}
	$info['shop_id']= get_sess_shop_id();
	$info['content'] = serialize($arr);
	if ($dbo->createbyarr($info,$t_transport_template)) {
		action_return(1,$m_langpackage->m_add_success."！","modules.php?app=goods_list");
	}else{
		echo "no";
	}
?>