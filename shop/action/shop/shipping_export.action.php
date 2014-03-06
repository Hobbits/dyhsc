<?php

	/*
		-----------------------------------------
		文件：receiv_export.php。
		功能: 商铺发货单导出处理。
		日期：2010-11-11
		-----------------------------------------
	*/
	
	if(!$IWEB_SHOP_IN) {
		die('Hacking attempt');
	}
	
	//引入语言包
	$m_langpackage=new moduleslp;
	
	//数据表定义区
	$shipping_list_table = $tablePreStr."shipping_list";

	//读写分类定义方法
	$dbo = new dbex;
	dbtarget("r",$dbServs);
	
	$shop_id = intval(get_args('shop_id'));

	$chast = get_args("chast");
	$file_name = get_args("filename");
	if (empty($file_name)) {
		$file_name=date("YmdHis");
	}
	$file_name .=".csv";
	$file_name =iconv("utf-8",$chast,$file_name);

	$sql = "SELECT * FROM $shipping_list_table WHERE shop_id = $shop_id order by add_date";
	$receiv_list = $dbo->getRs($sql);
	
	header( "Cache-Control: public" );
    header( "Pragma: public" );
	header("Content-type:application/vnd.ms-excel");
    header("Content-Disposition:attachment;filename=".$file_name);
    header('Content-Type:APPLICATION/OCTET-STREAM');
	ob_start();
	$header_str = iconv("utf-8",$chast,$m_langpackage->m_iconv_shipping);
    
	$file_str="";
	foreach ($receiv_list as $value){
		
		$pay_sn_pos = strpos($value['pay_sn'],",");
		$shipping_type_pos = strpos($value['shipping_type'],",");
		$shipping_company_pos = strpos($value['shipping_company'],",");
		$shipping_no_pos = strpos($value['shipping_no'],",");
		$consignee_pos = strpos($value['consignee'],",");

		$consignee_address_pos = strpos($value['consignee_address'],",");
		$consignee_tel_pos = strpos($value['consignee_tel'],",");
		$operator_pos = strpos($value['operator'],",");
		
	    if ($pay_sn_pos === false) {
			$pay_sn = iconv("utf-8",$chast,$value['pay_sn']);
	    }else{
	    	$pay_sn ="\"".iconv("utf-8",$chast,$value['pay_sn'])."\"";
	    }
		
		if ($shipping_type_pos === false) {
			$shipping_type = iconv("utf-8",$chast,$value['shipping_type']);
	    }else{
	    	$shipping_type ="\"".iconv("utf-8",$chast,$value['shipping_type'])."\"";
	    }
		
		if ($shipping_company_pos === false) {
			$shipping_company = iconv("utf-8",$chast,$value['shipping_company']);
	    }else{
	    	$shipping_company ="\"".iconv("utf-8",$chast,$value['shipping_company'])."\"";
	    }
		
		if ($shipping_no_pos === false) {
			$shipping_no = iconv("utf-8",$chast,$value['shipping_no']);
	    }else{
	    	$shipping_no ="\"".iconv("utf-8",$chast,$value['shipping_no'])."\"";
	    }
		
		if ($consignee_pos === false) {
			$consignee = iconv("utf-8",$chast,$value['consignee']);
	    }else{
	    	$consignee ="\"".iconv("utf-8",$chast,$value['consignee'])."\"";
	    }
		
		
		if ($consignee_address_pos === false) {
			$consignee_address = iconv("utf-8",$chast,$value['consignee_address']);
	    }else{
	    	$consignee_address ="\"".iconv("utf-8",$chast,$value['consignee_address'])."\"";
	    }
		
		if ($consignee_tel_pos === false) {
			$consignee_tel = iconv("utf-8",$chast,$value['consignee_tel']);
	    }else{
	    	$consignee_tel ="\"".iconv("utf-8",$chast,$value['consignee_tel'])."\"";
	    }
		
		if ($operator_pos === false) {
			$operator = iconv("utf-8",$chast,$value['operator']);
	    }else{
	    	$operator ="\"".iconv("utf-8",$chast,$value['operator'])."\"";
	    }
		
		$file_str .=$value['shipping_id'].",".$value['order_id'].",".$pay_sn.",".$value['shop_id'].",".$shipping_type.",".$shipping_company.",".$shipping_no.",".$value['add_date'].",".$consignee.",".$consignee_address.",".$consignee_tel.",".$operator."\n";
	}
	ob_end_clean();
	echo $header_str;
	echo $file_str;
	
?>