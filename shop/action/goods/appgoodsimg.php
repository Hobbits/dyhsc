<?php
echo header("Access-Control-Allow-Origin:*");
echo header("Access-Control-Allow-Headers: *");
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}


require("foundation/module_goods.php");
//定义文件表
$t_goods = $tablePreStr."goods_attachment";
$t_g = $tablePreStr."goods";
$t_s = $tablePreStr."shop_info";

//数据库操作
$dbo=new dbex();
dbtarget('w',$dbServs);



//$callback = isset( $_GET[ 'callback' ] ) ? $_GET[ 'callback' ] : 'callback';
/* 图片上传处理 */

$content = file_get_contents("php://input");
$all = json_decode($content);
$goodid = $all->goodsid;

//获取店铺id
$sql = "select s.user_id from `$t_g` AS g,`$t_s` AS s where g.goods_id =$goodid and s.shop_id = g.shop_id ";
$shopuser = $dbo->getRow($sql);

if ($sessionuserid == $shopuser['user_id']){
$imagetype = $all->img->imageType;   
$type = split('/', $imagetype);
if ($type[1]){
	$t = strtolower($type[1]);
	if (!in_array($t, array('gif','jpg','jpeg','png'))){
		$r =  new returnobj('-1','图片类型不正确');
		print_r(json_encode( $r ));
		exit;
	}
}
$pic =$all->img->code; 
 
if ($goodid && $pic){
	   $picdir = set_picdir("uploadfiles/","goods/{y}/{m}/{d}");	  
    	$s = base64_decode(str_replace('data:image/'.$type[1].';base64,', '', $pic));
    	$filename = date('Ymdhis',time()).mt_rand(10,99);

        
	    $newFilePath=$picdir.$filename.'.'.$type[1]; 
	    file_put_contents($newFilePath, $s);
	   
	   
	    
	    //生成缩略图
	    $picsrc = $webRoot.$newFilePath;
	  	list($width, $height, $itype, $attr) = getimagesize($picsrc);
	 
	    $ni=imagecreatetruecolor('128','128');
	   
	   
		switch ($itype) {
			case 1: $im = imagecreatefromgif($picsrc); break;
			case 2: $im = imagecreatefromjpeg($picsrc); break;
			case 3: $im = imagecreatefrompng($picsrc); break;
		}
		//原图压缩  > 1M
		if ($all->img->size >= 1024*1024){
			ImageJpeg($im,$picsrc,2);
		}
		
		imagecopyresampled($ni,$im,0,0,0,0,'128','128',$width,$height);
		$dstFile =  $webRoot.$picdir.'thumb'.$filename.'.'.$type[1]; 
		ImageJpeg($ni,$dstFile);
	    
	    $post['img_url'] = $newFilePath;
	    $post['goods_id'] = $goodid;
	    $post['img_thumb'] = $picdir.'thumb'.$filename.'.'.$type[1];
		$id = insert_goods_imgs($dbo,$t_goods,$post);
		if ($id){
			$r =  new returnobj('ok',$id,$chatnums);
			print_r(json_encode( $r ));
		}
	    
	}
}else{
		$r = new returnobj('401','');
		print_r( json_encode( $r ) );
		exit;	
}
//$cupload = new upload('jpg|gif|png', $maxsize = 9999, 'avatar', $time = '');
////print_r($cupload);
//$cupload->set_dir("uploadfiles/goods/","{y}/{m}/{d}");
//$setthumb = array(
//	'width' => array('128'),
//	'height' => array('128'),
//	'name' => array('thumb')
//);
//$cupload->set_thumb($setthumb);
//
//$file = $cupload->execute();
//if ($file){
//	if(count($file)) {
//		foreach($file as $k=>$v) {
//			if($v['flag']==1) {				
//				$post['goods_id'] = $goodid;
//				$post['img_url'] = $v['dir'].$v['name'];
//				$post['img_thumb'] = $v['dir'].$v['thumb'];
//				insert_goods_imgs($dbo,$t_goods,$post);
//			}
//		}
//	}
//}
