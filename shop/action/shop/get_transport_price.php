<?php
	/*
	***********************************************
	*$ID:get_transport_price
	*$NAME:get_transport_price
	*$AUTHOR:E.T.Wei
	*DATE:Tue Apr 06 14:56:31 CST 2010
	***********************************************
	*/
	if(!$IWEB_SHOP_IN) {
		die('Hacking attempt');
	}
	
	//语言包引入
	$m_langpackage=new moduleslp;
	/* post 数据处理 */
	$goods_id = intval(get_args('goods_id'));
	$area_id = intval(get_args("area_id"));
	//数据表定义区
	$t_goods=$tablePreStr."goods";
	$t_transport_template = $tablePreStr."goods_transport";
	$t_areas = $tablePreStr."areas";
	$t_transport = $tablePreStr."transport";
	//定义写操作
	dbtarget('r',$dbServs);
	$dbo=new dbex;
	$goodsinfo=$dbo->getRow("SELECT is_transport_template,transport_price,transport_template_id,shop_id FROM $t_goods WHERE goods_id='$goods_id'");
	$sql = "SELECT content FROM $t_transport_template WHERE id=(SELECT transport_template_id FROM $t_goods WHERE goods_id='$goods_id')";
	//echo $sql;
	$arr = $dbo->getRow($sql);
	//查询地区名称
//	$sql = "select * from $t_areas where area_id=$area_id";
//	$arearry = $dbo->getRow($sql);
	//查询开启的配送方式
	$sql = "select * from $t_transport where ifopen=1";
	$tran_list=$dbo->getRs($sql);
	
	$str="";
	$default_transport_price="";
	if (isset($arr['content'])) {
		$transport_arr = unserialize($arr['content']);
		foreach ($tran_list as $val){
			if($transport_arr[$val['tranid']]['frist']!=0){
				if(empty($transport_arr[$val['tranid']][$area_id]['frist'])){
					$str.=$val['tran_name'].":".intval($transport_arr[$val['tranid']]['frist']).$m_langpackage->m_yuan;
				}else{
					$str.=$val['tran_name'].":".$transport_arr[$val['tranid']][$area_id]['frist'].$m_langpackage->m_yuan;
				}
			}
		}
	}else{
		$str.=$goodsinfo['transport_price'].$m_langpackage->m_yuan;
	}
	echo $str;
	
?>