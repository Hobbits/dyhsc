<?php
header("content-type:text/html;charset=utf-8");
$IWEB_SHOP_IN = true;

require("foundation/module_goods.php");

/* 数据库操作 */
dbtarget('r',$dbServs);
$dbo=new dbex();
//$k = 'anchora';
//$search_type = 'shop';

$callback = isset( $_GET[ 'callback' ] ) ? $_GET[ 'callback' ] : 'callback';
$k=$_GET['k'];

$search_type = short_check(get_args("search_type"));
$search_type = !empty($search_type)?$search_type:'good';
$province = $_GET['province']?$_GET['province']:'';
$city = $_GET['city']?$_GET['city']:'';
$categoryid = $_GET['categoryid']?$_GET['categoryid']:'';

//数据库表
$t_goods = $tablePreStr."goods";
$t_shop_info = $tablePreStr."shop_info";
$t_category = $tablePreStr."category";

$t_shop_categories = $tablePreStr."shop_categories";
$t_goods_attachment = $tablePreStr."goods_attachment";


if ($search_type=='good') {
	require("foundation/module_category.php");
	/* 列表处理 */
	//搜商品
	$sql="SELECT g.goods_id,g.goods_name,g.goods_price,g.goods_intro,s.shop_province,s.shop_city
					FROM `$t_goods` AS g,`$t_shop_info` As s WHERE is_delete = 1 AND g.shop_id = s.shop_id ";

    if ($categoryid){
    	//判断是否是主分类
    	$info = get_info_category($dbo,$t_category,$categoryid);
    	//print_r($info);exit;
    	if ($info[0]['parent_id'] && $info[0]['parent_id']!=0 && $info[0]['parent_id'] != '0'){
	    	$sql.=" AND g.cat_id='$categoryid'";
    	}else{
    		$subs = get_sub_category($dbo,$t_category,$categoryid);
	    	//print_r($subs);exit;
	    	if ($subs){
	    		$str = '(';
	    		foreach ($subs as $sub){
	    			$str .= $sub['cat_id'].',';
	    		}
	    		$str = substr($str,0,strlen($str)-1);
	    		$fstr = $str.')';
	    		$sql.=" AND g.cat_id in $fstr ";
	    	}
    		
    	}
    }
	if ($province) {
		$sql.=" AND s.shop_province='$province'";
	}
	
	if ($city) {
		$sql.=" AND s.shop_city='$city'";
	}
	
	if ($k) {
		
		$k=str_replace("　"," ",$k);
		$k=str_replace("'","\'",$k);
		$k=str_replace("\"","\\\"",$k);
		$k=str_replace("%","\%",$k);
		$k=str_replace("#","\#",$k);
		$k=addslashes($k);
		//$ks = explode(' ', $k);
		
		$sql.= " AND g.goods_name like '%$k%' ";
	}
		$result1 = $dbo->getRs($sql);

		$return1 = array();
		if ($result1){
			foreach ($result1 as $v){
				$pic = '';
				$rid = '';
				$return1[$v['goods_id']]['goodsid'] = $v['goods_id'];
				$return1[$v['goods_id']]['goodsname'] = $v['goods_name'];
				$return1[$v['goods_id']]['price'] = $v['goods_price'];
				$return1[$v['goods_id']]['intro'] = $v['goods_intro'];
				$rid = $v['goods_id'];
				$pic = is_goods_imgs($dbo,$t_goods_attachment,$rid);
				if ($pic){
					$re[$pic['aid']]['main_img'] = $pic['main_img'];
					$re[$pic['aid']]['imgid'] = $pic['aid'];
					$re[$pic['aid']]['img_url'] = $pic['img_url'];
					$re[$pic['aid']]['img_thumb'] = $pic['img_thumb'];
				    $picsrc = $webRoot.$pic['img_url'];
				  	list($width, $height, $type, $attr) = getimagesize($picsrc);
					$re[$pic['aid']]['orwidth'] = $width;
					$re[$pic['aid']]['orheight'] = $height ;
					if ($re){
			 			foreach ($re as $v){
			 			$rt[] = $v;
			 			}
	 				}
	 				$return1[$rid]['img'] = $rt;
				}
				
			}
			if ($return1){
				foreach ($return1 as $r){
					//$back1['good'][] = $r;
					$back1[] = $r;
				}
			}
			
			$final = array('good' =>$back1 ,'shop' => '');
			//返回数据
				if ($back1){
					$b = new returnobj('ok',$final);
					print_r($callback . '(' . json_encode( $b ) . ')');
					exit;
				}
			}else{
				$res = array('good' => '','shop' => '');
				$b = new returnobj('ok',$res);
				print_r($callback . '(' . json_encode( $b ) . ')');
				exit;
			}
			
}elseif ($search_type == 'shop'){
	require("foundation/module_shop_category.php");
	//搜店铺
	$sql="SELECT s.shop_id,s.shop_name,s.logo_thumb,s.shop_logo,s.shop_management,s.shop_categories
					FROM `$t_shop_info` AS s WHERE open_flg <> 1  ";
	
	if ($province) {
		$sql.=" AND s.shop_province='$province'";
	}

	if ($city) {
		$sql.=" AND s.shop_city='$city'";
	}
	if($categoryid){
		//判断是否是主分类
		$info = get_categories_info_catid($dbo,$t_shop_categories,$categoryid);
		if($info[0]['parent_id'] && $info[0]['parent_id']!=0 && $info[0]['parent_id'] != '0'){
				$sql.=" AND s.shop_categories='$categoryid'";
	    	}else{
	    		$subs = get_categories_item_parentid($dbo,$t_shop_categories,$categoryid);
				$str = '(';
	    		foreach ($subs as $sub){
	    			$str .= $sub['cat_id'].',';
	    		}
	    		$str = substr($str,0,strlen($str)-1);
	    		$fstr = $str.')';
	    		$sql.=" AND s.shop_categories in $fstr ";
    		}
		}
	

	if ($k) {
		
		$k=str_replace("　"," ",$k);
		$k=str_replace("'","\'",$k);
		$k=str_replace("\"","\\\"",$k);
		$k=str_replace("%","\%",$k);
		$k=str_replace("#","\#",$k);
		$k=addslashes($k);
		//$ks = explode(' ', $k);
		
		$sql.= " AND s.shop_name like '%$k%'";
	}
		$result = $dbo->getRs($sql);
		$return = array();
		if ($result){
			foreach ($result as $value){
				$return[$value['shop_id']]['shopid'] = $value['shop_id'];
				$return[$value['shop_id']]['shopname'] = $value['shop_name'];
				$return[$value['shop_id']]['logo'] = $value['shop_logo'];
				if ($value['logo_thumb']){
					$return[$value['shop_id']]['thumb_logo'] = $value['logo_thumb'];
				}else{
					$return[$value['shop_id']]['thumb_logo'] = $shopthumbimg;
				}
				$return[$value['shop_id']]['shopmanagement'] = $value['shop_management'];
				//获取分类
			if(isset($value['shop_categories'])){
				$shop_categories_info = get_categories_info_catid($dbo,$t_shop_categories,$value['shop_categories']);
				$return[$value['shop_id']]['shopcategory'] = $shop_categories_info['cat_name'];
				}
			}
			if ($return){
				foreach ($return as $s){
					//$back['shop'][] = $s;
					$back[] = $s;
				}
				$final = array('good' => '','shop' => $back);
				//fanhui
				if ($back){
					$b = new returnobj('ok',$final);
					print_r($callback . '(' . json_encode( $b ) . ')');
					exit;
				}
			}
		}else{
			$res = array('good' => '','shop'=> '');
			$b = new returnobj('ok',$res,$chatnums);
			print_r($callback . '(' . json_encode( $b ) . ')');
			exit;
		}		
}