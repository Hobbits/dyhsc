<?php
	/*
	***********************************************
	*$ID:eidt_transport_template
	*$NAME:eidt_transport_template
	*$AUTHOR:E.T.Wei
	*DATE:Sat Apr 03 10:40:43 CST 2010
	***********************************************
	*/
	if(!$IWEB_SHOP_IN) {
		trigger_error('Hacking attempt');
	}

	//文件引入
	require("foundation/module_goods.php");
	require("foundation/module_areas.php");
	//引入语言包
	$m_langpackage = new moduleslp;
	$i_langpackage=new indexlp;
	//数据表定义区
	$t_areas = $tablePreStr."areas";
	$t_transport_template = $tablePreStr."goods_transport";
	$t_transport = $tablePreStr."transport";
	//读写分类定义方法
	$dbo = new dbex;
	dbtarget("r",$dbServs);
	$id = intval(get_args("id"));
	$sql = "SELECT * FROM $t_transport_template WHERE id='$id'";
	$transport_template_info = $dbo->getRow($sql);
	$transport_type = unserialize($transport_template_info['content']);
	foreach ($transport_type as $value){
		$transport_type[]=$value;
	}
	$arr = unserialize($transport_template_info['content']);
	//查询开启的配送方式
	$sql = "SELECT * FROM $t_transport WHERE ifopen='1'";
	$arr_list=$dbo->getRs($sql);
	
	//循环查出开启的配送方式中，保存的相应的方式
	$type_list = array();
	foreach ($arr_list as $v){
		$tran_type=$v['tranid'];
		$type_list[$v['tranid']]="";	//注:该变量根据$v['tranid']的值的改变而变，通过循环定义
		if (isset($arr[$tran_type])&&count($arr[$tran_type])>1) {
			$emsarea=array();
			foreach ($arr[$tran_type] as $key=>$value){
				if(is_numeric($key)){
					$emsarea["{$value['frist']},{$value['second']}"][]=$key;
				}
			}
			$idlist="";
			$area_name_list="";
			$num=0;
			foreach ($emsarea as $key=>$value){
				foreach ($value as $k=>$v){
					$idlist.=$v.",";
					$sql="SELECT area_name FROM $t_areas WHERE area_id='$v'";
					$area_info = $dbo->getRow($sql);
					$area_name_list.=$area_info['area_name'].",";
				}
				$num++;
				$key_str = explode(",",$key);
				$type_list[$v['tranid']].="&nbsp;&nbsp;&nbsp;&nbsp;<li>至<input type='text' name='ord_item_word'.$tran_type.'[]' value='$area_name_list' onclick=\"eidtarea('$tran_type','$idlist','$num')\" id='item$num'  />
					<input type='hidden' id='itemvalue$num' name='ord_item_dest'.$tran_type.'[]' value='$idlist' />的";
				$type_list[$v['tranid']].=$m_langpackage->m_transport_template_frist;
				$type_list[$v['tranid']].="<input type='text' name='ord_area_frist'.$tran_type.'[]' value='{$key_str[0]}' />".$m_langpackage->m_transport_template_second.
					"<input type='text' name='ord_area_second'.$tran_type.'[]' value='{$key_str[1]}' /></li>";
				$idlist="";
				$area_name_list="";
			}
		}
	}
	//循环生成json
	$post=array();
	foreach ($arr_list as $v){
		if(isset($transport_type[$v['tranid']])){
			$post[$v['tranid']]=json_encode($transport_type[$v['tranid']]);
		}
	}
	$area_list = get_area_list_bytype($dbo,$t_areas,1);
?>