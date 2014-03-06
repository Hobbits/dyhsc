<?php
echo header("Access-Control-Allow-Origin: * ");
echo header("Access-Control-Allow-Headers: * ");
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

//引入模块公共方法文件
require("foundation/module_goods.php");
//require("foundation/module_category.php");

//定义文件表
$t_goods = $tablePreStr."goods";
$t_goods_attachment = $tablePreStr."goods_attachment";
$t_category = $tablePreStr."category";
//数据库操作
$dbo=new dbex();
dbtarget('r',$dbServs);


$allposts2 = file_get_contents("php://input");
$all = json_decode($allposts2);

//判断有没有创建店铺
if (!$all->shopid){
	$re = new returnobj('-2','未创建店铺');
	print_r(json_encode($re));
	exit;
}

$post['shop_id'] = $all->shopid;
//获取店主id
if ($sessionuserid == $post['shop_id']){

$goodsid = $all->goodid; 
$post['goods_name'] = $all->name; 
$post['cat_id'] = $all->category;  
$post['goods_intro'] = $all->introduction;
$post['goods_price'] = $all->price; 
$post['telphone'] = $all->telphone; 
$post['email'] = $all->email;  
$post['address'] = $all->address;  
if (empty($post['goods_name'])){
	$r =  new returnobj('-1','请填写商品名');
	print_r(json_encode( $r ));
	exit;
}

if($goodsid){
	$post['goods_id'] = $goodsid;
}

$post['add_time'] = $ctime->long_time();
if ($all->picture){
$imagetype = $all->picture->imageType;    //get_args('imageType');
$type = split('/', $imagetype);
if ($type[1]){
	$t = strtolower($type[1]);
	if (!in_array($t, array('gif','jpg','jpeg','png'))){
		$r =  new returnobj('-1','图片类型不正确');
		print_r(json_encode( $r ));
		exit;
	}
}

 $pic =$all->picture->code;   
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
	   $picdir = set_dir("uploadfiles/","goods/{y}/{m}/{d}");	  
    	$s = base64_decode(str_replace('data:image/'.$type[1].';base64,', '', $pic));
    	$filename = date('Ymdhis',time()).mt_rand(10,99);

        
	    $newFilePath=$picdir.$filename.'.'.$type[1]; 
	    file_put_contents($newFilePath, $s);
	    
	    //生成缩略图
	    $ni=imagecreatetruecolor('128','128');
	   
	   $picsrc = $webRoot.$newFilePath;
	  list($width, $height, $itype, $attr) = getimagesize($picsrc);
		switch ($itype) {
			case 1: $im = imagecreatefromgif($picsrc); break;
			case 2: $im = imagecreatefromjpeg($picsrc); break;
			case 3: $im = imagecreatefrompng($picsrc); break;
		}
		//print_r($im);exit;
		imagecopyresampled($ni,$im,0,0,0,0,'128','128',$width,$height);
		$dstFile =  $webRoot.$picdir.'thumb'.$filename.'.'.$type[1]; 
		ImageJpeg($ni,$dstFile);
	    
	    //$post['goods_thumb'] = $newFilePath;
	    $pt['img_url'] = $newFilePath;
	    $pt['img_thumb'] = $picdir.'thumb'.$filename.'.'.$type[1];
	}else{
		if (!$goodsid){
			$pt['img_url'] = $goodimg;
	    	$pt['img_thumb'] =$goodthumbimg;
		}
	}
}


//数据库操作
dbtarget('w',$dbServs);
if($goodsid){
	 $goods = update_goods_info($dbo,$t_goods,$post,$goodsid,$post['shop_id']);
	 if ($pic){
	 	$is = is_goods_imgs($dbo,$t_goods_attachment,$goodsid);
	 	if($is){
	 		//修改
	 		$imgurl = $pt['img_url'];
	 		$thumb = $pt['img_thumb'];
	 		$sql="UPDATE $t_goods_attachment SET img_url='$imgurl' and img_thumb='$thumb' WHERE goods_id=$goodsid ";
			$return = $dbo->exeUpdate($sql);
			if ($return){
				if($goods){
					$r = new returnobj('ok',$goodsid);
					print_r(json_encode($r));
					exit;
				}else{
					$r = new returnobj('-1','商品编辑失败');
					print_r(json_encode($r));
					exit;
				}
			}else{
				 $r1 = new returnobj('-2','图片编辑失败');
				 print_r(json_encode($r1));
				 exit;
			}
	 	}
	 	
	 }else{
	 
		if($goods){
			$r = new returnobj('ok',$goodsid,$chatnums);
			print_r(json_encode($r));
			exit;
		}else{
			$r = new returnobj('-1','商品编辑失败');
			print_r(json_encode($r));
			exit;
		}
	 }
	
}else{
	
if($goods_id = insert_goods_info($dbo,$t_goods,$post)) {
	//更新分类下的产品数量
	$flag = true;
	$preid = $post['cat_id'];
	while($flag){
		$gsql = "update $t_category set goods_num=goods_num+1 where cat_id=$preid";
		$dbo->exeUpdate($gsql);
		$sql1 = "select * from $t_category where cat_id=$preid";
		$row = $dbo->getRow($sql1);
		if($row['parent_id']!=0){
			$preid=$row['parent_id'];
		}else{
			$flag = false;
		}
	}
	if ($pic){
     $pt['goods_id'] = $goods_id;
     $pt['main_img'] = 1;
	 $id = insert_goods_imgs($dbo,$t_goods_attachment,$pt);
	 if($id){
	 	$r1 = new returnobj('ok',$goods_id,$chatnums);
		print_r(json_encode($r1));
	    exit;
	 }else{
	   $r1 = new returnobj('-2','图片上传失败');
	   print_r(json_encode($r1));
	   exit;
	 }
	}else{
		$r1 = new returnobj('ok',$goods_id,$chatnums);
		print_r(json_encode($r1));
	    exit;	
	}
} else {
	$r = new returnobj('-1','商品添加失败',$chatnums);
	print_r(json_encode($r));
	exit;
}
}
}else{
	$r = new returnobj('401','');
	print_r( json_encode( $r ));
	exit;
}
?>
