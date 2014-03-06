<?php
if(!$IWEB_SHOP_IN) {
	trigger_error('Hacking attempt');
}

require("foundation/module_shop.php");
require("foundation/module_shop_category.php");
require("foundation/module_areas.php");

$t_shop_categories = $tablePreStr."shop_categories";
$t_shop_payment = $tablePreStr."shop_payment";
$t_areas = $tablePreStr."areas";
$callback = isset( $_GET[ 'callback' ] ) ? $_GET[ 'callback' ] : 'callback';
$t_shop_info = $tablePreStr."shop_info";
//读写分离定义方法
$dbo=new dbex;
dbtarget('r',$dbServs);
$shop_id = $_GET['shopid'];
//未读消息
if ($shop_id){
	$chatsql = "select count(*) num from $user_chat where toid= $shop_id and isshow = 0";
	if ($dbo->getRow($chatsql)){
		$chatcount = $dbo->getRow($chatsql);
		if ($allcount){
			$recordnums =array('records_num' => $chatcount['num']) ;
		}else{
			$recordnums = array('records_num' => '0') ;
		}
	}
}else{
	$recordnums = array('records_num' => '0') ;
}
//判断是否存在店铺
$shopsql = "select shop_id from $t_shop_info where user_id='$shop_id'";

//if ($isshop_info['shop_id']){
if($dbo->getRow($shopsql)){
	$isshop_info = $dbo->getRow($shopsql);
	$shop_info = get_shop_info($dbo,$t_shop_info,$shop_id);
	$shop_info = $shop_info[0];
	$result = array();
	$kvalue = array('shop_id','shop_name','logo_thumb','shop_contact','telphone','shop_email','shop_province','shop_city','shop_address','shop_logo','shop_management','shop_intro','shop_creat_time','shop_categories','map_x','map_y');
//	print_r($shop_info);exit;
	if ($shop_info){
		foreach ($shop_info as $key=>$value){
			if ($key!= '0' || $key != 0){
			if (in_array($key, $kvalue)){	
				if ($key == 'shop_categories'){ 
					 $result[$key] = $value;
					//父分类
					if ($value){
						$shop_categories_info = get_categories_info_catid($dbo,$t_shop_categories,$value);
						$result['shop_categoriesname'] = $shop_categories_info['cat_name'];
						$result['shop_maincategories'] = $shop_categories_info['parent_id'];
						$pre = get_categories_info_catid($dbo,$t_shop_categories,$result['shop_maincategories']);
						$result['shop_maincategoriesname'] = $pre['cat_name'];
					}
				}elseif ($key == 'map_x'){
					if ($value){
						$result['coords']['longitude'] = $value;
					}
				}elseif ($key == 'map_y'){
					if ($value){
						$result['coords']['latitude'] = $value ;
					}
				}elseif ($key == 'shop_province'){
					$result[$key] = $value;
					$pname = getarea($dbo,$t_areas,$value);
					$result['provincename'] = $pname['area_name'];
				}elseif ($key == 'shop_city'){
					$result[$key] = $value;
					$cname = getarea($dbo,$t_areas,$value);
					$result['cityname'] = $cname['area_name'];
				}else{
					$result[$key] = $value;
				}
			}
			}
		}
	//返回支付宝信息
	   $apliaysql = "select * from `$t_shop_payment` where shop_id = $shop_id ";
	   $apliay = $dbo->getRsassoc($apliaysql);
	   if ($apliay[0]){
	   	 	if ($sessionuserid && $shop_id == $sessionuserid ){
	   	 		
	   	 		$apliays = unserialize($apliay[0]['pay_config']);
	   	 		$apliays['intro'] = $apliay[0]['pay_desc'];
	   	 	}
	   	 	if ($apliay[0]['enabled']){
	   	 		$apliays['alipayOn'] = true;
	   	 	}else{
	   	 		$apliays['alipayOn'] = false;
	   	 	}
	   }else{
	   		$apliays['alipayOn'] = false;
	   }
		
	   $result['alipay'] = $apliays;
	}

	$r =  new returnobj('ok',$result,$recordnums);
	$res =  $callback . '(' . json_encode( $r ) . ')';
	print_r($res);
}else{
	$r =  new returnobj('-1','未创建店铺');
	$result =  $callback . '(' . json_encode( $r ) . ')';
	print_r($result);
}

