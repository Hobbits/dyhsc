<?php
	/*
	***********************************************
	*$ID:categories_export
	*$NAME:categories_export
	*$AUTHOR:kane
	*DATE:2010-10-27
	***********************************************
	*/
	if(!$IWEB_SHOP_IN) {
		die('Hacking attempt');
	}

	//引入语言包
	$a_langpackage=new adminlp;
	//数据表定义区
	$shop_categories_table = $tablePreStr."shop_categories";
	//读写分类定义方法
	$dbo = new dbex;
	dbtarget("r",$dbServs);

	$chast = 'gbk';
	$file_name = get_args("filename");
	if (empty($file_name)) {
		$file_name=date("YmdHis");
	}
	$file_name .=".csv";
	$file_name =iconv("utf-8",$chast,$file_name);
	$sql = "SELECT * FROM $shop_categories_table ";
	$categories_list = $dbo->getRs($sql);
	header( "Cache-Control: public" );
    header( "Pragma: public" );
	header("Content-type:application/vnd.ms-excel");
    header("Content-Disposition:attachment;filename=".$file_name);
    header('Content-Type:APPLICATION/OCTET-STREAM');
	ob_start();
	$header_str = iconv("utf-8",$chast,$a_langpackage->a_iconv_str);
    
	$file_str="";
	foreach ($categories_list as $value){
		$cat_name_pos = strpos($value['cat_name'],",");//商品名称

		$value['cat_name']=str_replace("/r","","{$value['cat_name']}");
		$value['cat_name']=str_replace('"','""',"{$value['cat_name']}");
		$value['cat_name']=str_replace("/n","","{$value['cat_name']}");
		
	    if ($cat_name_pos === false) {
			$cat_name = iconv("utf-8",$chast,$value['cat_name']);
	    }else{
	    	$cat_name ="\"".iconv("utf-8",$chast,$value['cat_name'])."\"";
	    }//商品名称
	   
	  
		$file_str .=$value['cat_id'].",".$cat_name.",".$value['parent_id'].",".$value['sort_order'].",".$value['shops_num']."\n";
	}
	ob_end_clean();
	echo $header_str;
	echo $file_str;
	
?>