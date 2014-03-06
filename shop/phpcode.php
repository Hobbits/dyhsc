<?php    
/*
 * PHP QR Code encoder
 */
    header("content-type:text/html;charset=utf-8");
    require("foundation/module_shop.php");
    
    $t_shop_info = $tablePreStr."shop_info";
    /* 数据库操作 */
	dbtarget('w',$dbServs);
	$dbo=new dbex();
	
	$t_code = $tablePreStr."code";
	
	$callback = isset( $_GET[ 'callback' ] ) ? $_GET[ 'callback' ] : 'callback';
	 $shopid = $_GET['shopid'];
	 //判断二维码是否存在
	$sql1 = "select * from `$t_code` where shop_id='$shopid' ";
	$code = $dbo->getRow($sql1);
	//判断图片地址是否存在
	if ($code && file_exists($webRoot.$code['filesrc'])){
		$return['codeurl']= $PNG_WEB_DIR.$code['filesrc'];
		$return['downloadurl'] = 'appdo.php?act=download&shopid='.$shopid;
		$re = new returnobj('ok',$return,$chatnums);
		$result =  $callback . '(' . json_encode( $re ) . ')';
		print_r($result);
	}else{
	
	
    //set it to writable location, a place for temp generated PNG files
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'uploadfiles'.DIRECTORY_SEPARATOR.'code'.DIRECTORY_SEPARATOR;
    
  //  echo $PNG_TEMP_DIR;exit;
    
    //html PNG location prefix
    $PNG_WEB_DIR = 'uploadfiles/code/';

    include "qrlib.php";    
    $errorCorrectionLevel = 'L';
   

    $matrixPointSize = 16;
    
   
   //$shopid = 15;
    //获取店铺名
    $shopsql = "select shop_name from $t_shop_info where shop_id='$shopid'";
	$shopname = $dbo->getRow($shopsql);
	//print_r($shopname);exit;
	
    $_REQUEST['data'] = $shopname['shop_name'].':'.''.$baseUrl.'shop.php?shopid='.$shopid;
    $filename = $PNG_TEMP_DIR.'test'.md5($_REQUEST['data'].'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
    if (!file_exists($filename)){
    
    QRcode::png($_REQUEST['data'], $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
    }  
        
    $post['shop_id'] = $shopid;
    $post['filesrc'] = $PNG_WEB_DIR.basename($filename);
    $item_sql = get_insert_item($post);
   
	
		$sql = "insert `$t_code` $item_sql";
		if($dbo->exeUpdate($sql)) {
			$return['codeurl']= $post['filesrc'];
			$return['downloadurl'] = 'appdo.php?act=download&shopid='.$shopid;
			$re = new returnobj('ok',$return,$chatnums);
			$result =  $callback . '(' . json_encode( $re ) . ')';
			print_r($result);
		} else {
			$re = new returnobj('-1','未生成二维码');
			$result =  $callback . '(' . json_encode( $re ) . ')';
			print_r($result);
		}
	}
        
    // benchmark
   // QRtools::timeBenchmark();    

    
