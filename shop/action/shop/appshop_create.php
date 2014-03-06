<?php
echo header("Access-Control-Allow-Origin: *");
echo header("Access-Control-Allow-Headers: *");

if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}


//引入模块公共方法文件
require("foundation/module_shop.php");

//数据库操作
dbtarget('w',$dbServs);
$dbo=new dbex();
//定义文件表
$t_shop_info = $tablePreStr."shop_info";
$t_shop_payment = $tablePreStr."shop_payment";

// 处理post变量
$allposts = file_get_contents("php://input");
$all = json_decode($allposts);

$user_id =  $all->userid;

//判断是否已创建shop
$shopsql = "select shop_id,shop_name from $t_shop_info where user_id='$user_id'";
$shop_info = $dbo->getRow($shopsql);
$sid = $shop_info['shop_id'];
$post['shop_name'] = $all->shopname;    


$post['shop_email'] =$all->email;
$post['shop_contact'] =$all->contact;
$post['telphone'] = $all->tel; 
$post['shop_address'] =$all->address ;
$post['shop_country'] = '1';
$post['shop_province'] =$all->province;  

$post['shop_city'] = $all->city;

if ($all->coords){  
	//$post['map_x'] = number_format($all->coords->longitude,14);
	//$post['map_y'] = number_format($all->coords->latitude,14);
	$post['map_x'] =$all->coords->longitude;
	$post['map_y'] = $all->coords->latitude;
}else{
	$post['map_x'] ='';
	$post['map_y'] ='';
}

$post['shop_intro'] = $all->introduction; 
$post['shop_management'] =$all->management; 
$post['user_id'] = $user_id;
$post['shop_id'] = $user_id;
$post['shop_creat_time'] = $ctime->long_time();
$post['shop_categories'] =$all->categories; 
if (empty($post['shop_name'])){
	$r =  new returnobj('-1','请填写店铺名');
	print_r(json_encode( $r ));
	exit;
}
if (empty($post['shop_contact'])){
	$r =  new returnobj('-1','请填写联系人');
	print_r(json_encode( $r ));
	exit;
}
if (empty($post['shop_email'])){
	$r =  new returnobj('-1','请填写电子邮箱');
	print_r(json_encode( $r ));
	exit;
}

//支付宝信息
$alipay = $all->alipay;

$imagetype = $all->imageType; 
$type = split('/', $imagetype);
if ($type[1]){
	$t = strtolower($type[1]);
	if (!in_array($t, array('gif','jpg','jpeg','png'))){
		$r =  new returnobj('-1','图片类型不正确');
		print_r(json_encode( $r ));
		exit;
	}
}
if (empty($all->shopname)){
	echo '-3';
	exit;
}
//判断商铺名称是否重复
if (!$shop_info ||  ($shop_info && $post['shop_name'] != $shop_info['shop_name'] )){
	$sql = "select * from $t_shop_info where shop_name='{$post['shop_name']}'";
	$array = $dbo->getRs($sql);
	if($array){
		$result = '2';
		echo $result;
		exit;
	}
}
 $pic =$all->logo;  
    function set_dir($basedir,$filedir = '') {
		$dir = $basedir;
		!is_dir($dir) && @mkdir($dir,0777);
		if (!empty($filedir)) {
			$filedir = str_replace(array('{y}','{m}','{d}'),array(date('Y',time()),date('m',time()),date('d',time())),strtolower($filedir));
			$dirs = explode('/',$filedir);
			foreach ($dirs as $d) {
				!empty($d) && $dir .= $d.'/';
				!is_dir($dir) && @mkdir($dir,0777);
			}
		}
		return $dir;
	}
	if ($pic){
	   $picdir = set_dir("uploadfiles/","shop/{y}/{m}/{d}");	  
    	$s = base64_decode(str_replace('data:image/'.$type[1].';base64,', '', $pic));
    	$filename = date('Ymdhis',time()).mt_rand(10,99);


	    $newFilePath=$picdir.$filename.'.'.$type[1];  
	    file_put_contents($newFilePath, $s);
	    $post['shop_logo'] = $newFilePath;
	    //生成缩略图
	    $ni=imagecreatetruecolor('128','128');
	   
	   $picsrc = $webRoot.$newFilePath;
	  list($width, $height, $itype, $attr) = getimagesize($picsrc);
		switch ($itype) {
			case 1: $im = imagecreatefromgif($picsrc); break;
			case 2: $im = imagecreatefromjpeg($picsrc); break;
			case 3: $im = imagecreatefrompng($picsrc); break;
		}
		imagecopyresampled($ni,$im,0,0,0,0,'128','128',$width,$height);
		$dstFile =  $webRoot.$picdir.'thumb'.$filename.'.'.$type[1]; 
		ImageJpeg($ni,$dstFile);
	    
	    //$post['goods_thumb'] = $newFilePath;
	    $post['logo_thumb'] = $picdir.'thumb'.$filename.'.'.$type[1];
	}else{
		if (!$shop_info){
			$post['shop_logo'] = $shopimg;
			$post['logo_thumb'] = $shopthumbimg;
		}
	}
    
if ($shop_info){
	if ($sessionuserid == $user_id){
		if(update_shop_info($dbo,$t_shop_info,$post,$user_id)){
			
			if (!$post['shop_logo']){
				$shop_info = get_shop_info($dbo,$t_shop_info,$user_id);
				$post['shop_logo'] = $shop_info['shop_logo'];
			}
			//查看是否存在支付宝信息
			$apliaysql = "select * from `$t_shop_payment` where shop_id = $sid ";
	   		$apliay = $dbo->getRsassoc($apliaysql);
			if ($alipay->alipayOn){
				$alipays['enabled'] = $alipay->alipayOn;
				$alipays['shop_id'] = $sid;
				$alipays['pay_id'] = '1';
				$alipays['pay_desc'] = $alipay->intro;
				$newarray['account'] = $alipay->account;
				$newarray['partner'] = $alipay->partner;
				$newarray['certCode'] = $alipay->certCode;
				$alipays['pay_config'] = serialize($newarray);
				if ($apliay[0]){
					$item_sql1 = get_update_item($alipays);
					$aasql = "update `$t_shop_payment` set $item_sql1 where shop_id='$sid'";
					$dbo->getRow($aasql);
					$post['alipayOn'] = true;
				}else{

					$item_sql2 = get_insert_item($alipays);
					$asql = "insert `$t_shop_payment` $item_sql2";
					$dbo->getRow($asql);
					$post['alipayOn'] = true;
				}
			}else {
				if ($apliay[0]){
					$dsql = "update `$t_shop_payment` set  enabled = '0' where shop_id='$sid'";
					$dbo->getRow($dsql);
				}
				$post['alipayOn'] = false;
			}
			
			echo json_encode($post);
			exit;
		}
	}else{
		$r = new returnobj('401','');
		echo  json_encode( $r ) ;
		exit;
	}
}else {
		$shopid = insert_shop_info($dbo,$t_shop_info,$post);
		if ($shopid){
		//添加支付宝信息
			if ($alipay->alipayOn){
				$alipays['shop_id'] = $shopid;
				$alipays['pay_id'] = '1';
				$alipays['enabled'] = $alipay->alipayOn;
				$newarray['account'] = $alipay->account;
				$newarray['partner'] = $alipay->partner;
				$newarray['certCode'] = $alipay->certCode;
				$alipays['pay_config'] = serialize($newarray);
				$alipays['pay_desc'] = $alipay->intro;			
				
				$item_sql = get_insert_item($alipays);
				$asql = "insert `$t_shop_payment` $item_sql";
				$dbo->getRow($asql);
				$post['alipayOn'] = true;
				$post['intro'] = $alipay->intro;
				$post['account'] = $alipay->account;
				$post['partner'] = $alipay->partner;
				$post['certCode'] = $alipay->certCode;
			}else{
				$post['alipayOn'] = false;
			}
			
			echo json_encode($post);
			exit;
		}else{
			echo '-1';
			exit;
		}
}


?>