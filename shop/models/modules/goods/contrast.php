<?php
	/*
	***********************************************
	*$ID:
	*$NAME:
	*$AUTHOR:E.T.Wei
	*DATE:Tue Mar 30 09:58:29 CST 2010
	***********************************************
	*/
	if(!$IWEB_SHOP_IN) {
		trigger_error('Hacking attempt');
	}
	//文件引入
	require("foundation/module_goods.php");
	require("foundation/module_category.php");
	/* 用户信息处理 */
	if(get_sess_user_id()) {
		$USER['login'] = 1;
		$USER['user_name'] = get_sess_user_name();
		$USER['user_id'] = get_sess_user_id();
		$USER['user_email'] = get_sess_user_email();
		$USER['shop_id'] = get_sess_shop_id();
	} else {
		$USER['login'] = 0;
		$USER['user_name'] = '';
		$USER['user_id'] = '';
		$USER['user_email'] = '';
		$USER['shop_id'] = '';
	}
	//定义数据表
	$t_goods = $tablePreStr."goods";
	$t_brand= $tablePreStr."brand";
	$t_category= $tablePreStr."category";
	$t_shop_info = $tablePreStr."shop_info";
	//读写分类定义方法
	$dbo=new dbex;
	dbtarget('r',$dbServs);
	//引入语言包
	$m_langpackage=new moduleslp;
	$i_langpackage=new indexlp;
	$s_langpackage=new shoplp;
	//操作
	$id = short_check(get_args("id"));
	$goods_ids = substr(short_check(get_args("contrast_goods_id")),0,-1);

	if ($goods_ids){
		$goods_ids = $goods_ids;
	}else if($id) {
		$goods_ids = $id;
	}else {
		trigger_error($m_langpackage->m_page_request_error);
	}
	$sql=" SELECT shop_id,goods_name,goods_thumb,goods_id,goods_price,brand_id,favpv,cat_id,transport_price,transport_template_price FROM $t_goods WHERE goods_id IN ($goods_ids) ";
	$goods_list = $dbo->getRs($sql);
	/* 获得商品分类 */
	$sub_category=get_parent_cats($goods_list[0]['cat_id'],$dbo,$t_category);

	foreach ($goods_list as $key=>$value){
		$row=$dbo->getRow("SELECT brand_name FROM $t_brand WHERE brand_id='{$value['brand_id']}'");
		$shop_name = $dbo->getRow("select shop_name from $t_shop_info where shop_id='$value[shop_id]'");
		$goods_list[$key]['brand_name']=$row['brand_name'];
		$goods_list[$key]['shop_name']=$shop_name['shop_name'];
	}
	$header['title'] = $m_langpackage->m_goods_pk;
?>
