<?php
header("content-type:text/html;charset=utf-8");
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
define(EARTH_RADIUS, 6371);//地球半径，平均半径为6371km
//搜附近的店铺

//获取自己店铺的地址到市
//读写分离定义方法
$dbo=new dbex;
dbtarget('r',$dbServs);
$t_shop_info = $tablePreStr."shop_info";
$callback = isset( $_GET[ 'callback' ] ) ? $_GET[ 'callback' ] : 'callback';
$userid = $_GET['userid'];
$lng = $_GET['longitude'];
$lat = $_GET['latitude'];
$distance = $_GET['distance'];

 /**

 *计算某个经纬度的周围某段距离的正方形的四个点
 *
 *@param lng float 经度
 *@param lat float 纬度
 *@param distance float 该点所在圆的半径，该圆与此正方形内切，默认值为0.5千米
 *@return array 正方形的四个点的经纬度坐标
 */

 function returnSquarePoint($lng, $lat,$distance = 5){
 	//$lng = number_format($lng,14);
 	//$lat = number_format($lat,14);
 	
    $dlng =  2 * asin(sin($distance / (2 * EARTH_RADIUS)) / cos(deg2rad($lat)));
    $dlng = rad2deg($dlng); 
    $dlat = $distance/EARTH_RADIUS;
    $dlat = rad2deg($dlat);
    return array(
                'left-top'=>array('lat'=>$lat + $dlat,'lng'=>$lng-$dlng),
                'right-top'=>array('lat'=>$lat + $dlat, 'lng'=>$lng + $dlng),
                'left-bottom'=>array('lat'=>$lat - $dlat, 'lng'=>$lng - $dlng),
                'right-bottom'=>array('lat'=>$lat - $dlat, 'lng'=>$lng + $dlng)
    			//'dlng' => $dlng
                );
 	}

//使用此函数计算得到结果后，带入sql查询。

$squares = returnSquarePoint($lng, $lat,$distance);
if ($userid){
	$info_sql = "select shop_id,shop_name,shop_management,logo_thumb from $t_shop_info where map_y<>0 and map_y>={$squares['right-bottom']['lat']} and map_y<={$squares['left-top']['lat']} and map_x>={$squares['left-top']['lng']} and map_x<={$squares['right-bottom']['lng']} and shop_id <> $userid"; 
}else{
	$info_sql = "select shop_id,shop_name,shop_management,logo_thumb from $t_shop_info where map_y<>0 and map_y>={$squares['right-bottom']['lat']} and map_y<={$squares['left-top']['lat']} and map_x>={$squares['left-top']['lng']} and map_x<={$squares['right-bottom']['lng']} "; 
}
	$result = $dbo->getRs($info_sql);
	
	if ($result){
		foreach ($result as $value){
			$return[$value['shop_id']]['shop_id'] = $value['shop_id'];
			$return[$value['shop_id']]['shop_name'] = $value['shop_name'];
			if ($value['logo_thumb']){
				$return[$value['shop_id']]['logo_thumb'] = $value['logo_thumb'];
			}else{
				$return[$value['shop_id']]['logo_thumb'] = $shopthumbimg;
			}
			$return[$value['shop_id']]['shop_management'] = $value['shop_management'];
		}
		if ($return){
			foreach ($return as $v){
				$fback[] = $v;
			}
		}
		$r = new returnobj('ok',$fback,$chatnums);
		print_r($callback . '(' . json_encode( $r ) . ')');
	    exit;
	}else{
		$r = new returnobj('ok',array(),$chatnums);
		print_r($callback . '(' . json_encode( $r ) . ')');
	    exit;
	}
