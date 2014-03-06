<?php
	/*
	***********************************************
	*$ID:categories_import
	*$NAME:categories_import
	*$AUTHOR:kane
	*DATE:2010-10-27
	***********************************************
	*/
	if(!$IWEB_SHOP_IN) {
		die('Hacking attempt');
	}
	require_once("../foundation/module_shop_category.php");
	//引入语言包
	$a_langpackage=new adminlp;
	//数据表定义区
	$shop_categories_table = $tablePreStr."shop_categories";
	//读写分类定义方法
	$dbo = new dbex;
	dbtarget("w",$dbServs);

	//取得上传的csv文件
	$res = fopen($_FILES['filename']['tmp_name'],"r");

	while ($arr2 = fgetcsv($res,50000)) {
		$arr[]=$arr2;
	}
	$arrobj = new arrayiconv();
	if (short_check(get_args("chast"))=='utf-8') {
		
	}else{
		$arr = $arrobj->Conversion($arr,short_check(get_args("chast")),"utf-8");
	}
	array_shift($arr);//删除第一行
	$errstr="";
	foreach ($arr as $k=> $value){
		$str_arr = $value;

		$info['cat_name']=$str_arr[1];
		$info['parent_id']=$str_arr[2];
		$info['sort_order']=$str_arr[3];
		$info['shops_num']=$str_arr[4];
		insert_category_info($dbo,$shop_categories_table,$info);
	}
	$errstr= substr($errstr,0,-1);
	if (empty($errstr)) {
		action_return(1,$a_langpackage->a_import_file_success,"m.php?app=shop_categories_list");
	}else{
		action_return(1,$a_langpackage->a_import_file_error.$errstr,"m.php?app=shop_categories_list");
	}

class arrayiconv    
{    
static protected $in;    
static protected $out;    
/**   
  * 静态方法,该方法输入数组并返回数组   
  *   
  * @param unknown_type $array 输入的数组   
  * @param unknown_type $in 输入数组的编码   
  * @param unknown_type $out 返回数组的编码   
  * @return unknown 返回的数组   
  */   
static public function Conversion($array,$in,$out)    
{    
  self::$in=$in;    
  self::$out=$out;    
  return self::arraymyicov($array);    
}    
/**   
  * 内部方法,循环数组   
  *   
  * @param unknown_type $array   
  * @return unknown   
  */   
static private function arraymyicov($array)    
{    
  foreach ($array as $key=>$value)    
  {    
   $key=self::myiconv($key);    
   if (!is_array($value)) {    
    $value=self::myiconv($value);    
   }else {    
    $value=self::arraymyicov($value);    
   }    
   $temparray[$key]=$value;    
  }    
  return $temparray;    
}    
/**   
  * 替换数组编码   
  *   
  * @param unknown_type $str   
  * @return unknown   
  */   
static private function myiconv($str)    
{    
  return iconv(self::$in,self::$out,$str);    
}    
}

?>