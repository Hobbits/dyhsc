<?php
	/*
	***********************************************
	*$ID:
	*$NAME:
	*$AUTHOR:E.T.Wei
	*DATE:Wed Mar 24 14:33:23 CST 2010
	***********************************************
	*/
	if(!$IWEB_SHOP_IN) {
		die('Hacking attempt');
	}
define('THUMB_WIDTH', 300);
define('THUMB_HEIGHT', 300);
define('THUMB_QUALITY', 85);

/* 淘宝助理CSV字段编号 */
define('FIELD_NUM',            41); // 字段总数
define('FIELD_GOODS_NAME',      0); // 商品名称
define('FIELD_PRICE',              7); // 商品价格
define('FIELD_STOCK',              9); // 库存
define('FIELD_IF_SHOW',        20); // 是否上架
define('FIELD_RECOMMENDED', 21); // 推荐
define('FIELD_ADD_TIME',       22); // 发布时间
define('FIELD_DESCRIPTION', 24); // 商品描述
define('FIELD_LAST_UPDATE', 31); // 更新时间
define('FIELD_GOODS_IMAGE', 35); // 商品图片
define('FIELD_GOODS_ATTR',  26); // 商品属性
define('FIELD_SALE_ATTR',      36); // 销售属性（规格）
define('FIELD_CID',                   1); // 商品类目cid
/* 品牌申请状态 */
define('BRAND_PASSED', 1);
define('BRAND_REFUSE', 0);

	//文件引入
	require("foundation/module_goods.php");
	require("foundation/module_shop.php");
	//引入语言包
	$m_langpackage=new moduleslp;
	//数据表定义区
	$t_goods = $tablePreStr."goods";
	$img_table = $tablePreStr."goods_gallery";
	$img_tmp_table = $tablePreStr."tmp_img";
	$t_shop_info=$tablePreStr."shop_info";
	$cat_id=intval(get_args("cat_id"));
	//读写分类定义方法
	$dbo = new dbex;
	dbtarget("w",$dbServs);
	
	$row=get_shop_info($dbo,$t_shop_info,$shop_id);
	//取得上传的csv文件
	$arr=get_csv_date($_FILES['filename']['tmp_name']);
	
	$errstr="";
	$goods_num=$row['goods_num'];
	foreach ($arr as $k=> $value){
		$sql="insert into $t_goods (shop_id,goods_name,cat_id,ucat_id,type_id,goods_intro,goods_number,goods_price,is_delete,is_best,is_new,is_hot,is_promote,is_on_sale,is_set_image,goods_thumb,add_time,last_update_time,lock_flg) values ";
	    $sql.="('$shop_id','".$value['goods_name']."','$cat_id','0','1','".$value['goods_intro']."','".$value['goods_number']."','".$value['goods_price']."',
	              '1','0','0','0','0','1','0','','".date("Y-m-d H:i:s")."','".date("Y-m-d H:i:s")."','0')";
	    $up=$dbo->exeUpdate($sql);
	    if($up){
		    $ids=mysql_insert_id();
		    $imgarr=get_img($value['image']);
		    $Date_1=date("Y-m-d"); 
		    $imgsql="insert into $img_tmp_table (img,goods_id,add_time,is_set) values ";
		    foreach ($imgarr as $k=> $v){
		    	$is_set=$k=='0'?"1":"0";
		    	$imgsql.="('$v','$ids','$Date_1','$is_set'),";
		    }
		    $imgsql=substr($imgsql,0,strlen($imgsql)-1);

		    $dbo->exeUpdate($imgsql);
	    }else{
	    	$errstr.=($k+1).",";
	    }
	    	
	    	$goods_num=$goods_num+1;
			$sql="update $t_shop_info set goods_num=$goods_num where shop_id=$shop_id";
			$dbo->exeUpdate($sql);
	}

	if (!$errstr) {
		action_return(1,"导入成功！","modules.php?app=csv_taobao_img");
	}else{
		action_return(1,"第".$errstr."行导入失败！","modules.php?app=csv_taobao_img");
	}
  function unicodeToUtf8($str,$order="little")
    {
        $utf8string ="";
        $n=strlen($str);
        for ($i=0;$i<$n ;$i++ )
        {
            if ($order=="little")
            {
                $val = str_pad(dechex(ord($str[$i+1])), 2, 0, STR_PAD_LEFT) .
                       str_pad(dechex(ord($str[$i])),      2, 0, STR_PAD_LEFT);
            }
            else
            {
                $val = str_pad(dechex(ord($str[$i])),      2, 0, STR_PAD_LEFT) .
                       str_pad(dechex(ord($str[$i+1])), 2, 0, STR_PAD_LEFT);
            }
            $val = intval($val,16); // 由于上次的.连接，导致$val变为字符串，这里得转回来。
            $i++; // 两个字节表示一个unicode字符。
            $c = "";
            if($val < 0x7F)
            { // 0000-007F
                $c .= chr($val);
            }
            elseif($val < 0x800)
            { // 0080-07F0
                $c .= chr(0xC0 | ($val / 64));
                $c .= chr(0x80 | ($val % 64));
            }
            else
            { // 0800-FFFF
                $c .= chr(0xE0 | (($val / 64) / 64));
                $c .= chr(0x80 | (($val / 64) % 64));
                $c .= chr(0x80 | ($val % 64));
            }
            $utf8string .= $c;
        }
        /* 去除bom标记 才能使内置的iconv函数正确转换 */
        if (ord(substr($utf8string,0,1)) == 0xEF && ord(substr($utf8string,1,2)) == 0xBB && ord(substr($utf8string,2,1)) == 0xBF)
        {
            $utf8string = substr($utf8string,3);
        }
        return $utf8string;
    }

    
    
    /**
	 * 解析csv文件
	 */
	function get_csv_date($file_name){
		$str = file_get_contents($file_name);
        if($str{0} != "\xFF" || $str{1} != "\xFE"){
            return false;
        }
        //转码
        $str = unicodeToUtf8(substr($str, 2));
        //切割字符串
        $str = preg_replace('/\t\"([^\t]+?)\"\t/es', "'\t\"' . stripslashes(str_replace(\"\n\", \"\", '\\1')) . '\"\t'", $str);
        $csv_array = explode("\n", $str);
        unset($csv_array[count($csv_array) -1]);
        unset($csv_array[0]);
        $product_array = array();
        if (!empty($csv_array)){
        	
        	foreach ($csv_array as $k => $v){
//        		if ($k > $this->product_batch_num){//判断上传数量不能大于指定数量
//        			break;
//        		}
        		$tmp = explode("\t", $v);
        		//商品名称
        		$tmp['goods_name'] = str_replace("'",'',str_replace('"','',$tmp[0]));
        		//库存
        		$tmp['goods_number'] = intval($tmp[9]);
        		//商品价格
        		$tmp['goods_price'] = number_format($tmp[7],2);
        		
        		if(trim($tmp[35],'"') != ''){
					//图片
					$tmp['image'] = trim($tmp[35],'"');
				}
				//商品简介
        		$tmp['goods_intro'] = str_replace("'",'',str_replace('"','',$tmp[24]));
        		$product_array[] = $tmp;
        	}
        }
        return $product_array;
	}
	
	function get_img($imgstring){
		if($imgstring=="")return false;
		$a1= explode(';',$imgstring);
		if(is_array($a1)){
		    foreach ($a1 as $v){
		    	$a2=explode(":",$v);
		    	if($a2[0]!=""){
		    		$array[]=$a2[0];
		    	}
		    }
		}
		return $array;
	}

?>