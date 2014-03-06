<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
require("foundation/module_img_size.php");
require("foundation/module_shop.php");
require("foundation/module_gallery.php");
	//	语言包引入
	$m_langpackage=new moduleslp;

    $upload_name = "Filedata";
    $uploadErrors = array(
        0=>"文件上传成功",
        1=>"上传的文件超过了 php.ini 文件中的 upload_max_filesize directive 里的设置",
        2=>"上传的文件超过了 HTML form 文件中的 MAX_FILE_SIZE directive 里的设置",
        3=>"上传的文件仅为部分文件",
        4=>"没有文件上传",
        6=>"缺少临时文件夹"
	);
    
	if (!isset($_FILES[$upload_name])) {
		HandleError("没有发现文件 ");
		exit(0);
	} else if (isset($_FILES[$upload_name]["error"][0]) && $_FILES[$upload_name]["error"][0] != 0) {
		HandleError($uploadErrors[$_FILES[$upload_name]["error"][0]]);
		exit(0);
	} else if (!isset($_FILES[$upload_name]['name'][0])) {
		HandleError("文件无名称");
		exit(0);
	}
	
	
	$t_shop_info=$tablePreStr."shop_info";
	$t_img_size=$tablePreStr."img_size";
	$t_tmp_img=$tablePreStr."tmp_img";
	$t_goods=$tablePreStr."goods";
	$t_goods_gallery = $tablePreStr."goods_gallery";
	
	$dbo=new dbex();
	dbtarget('r',$dbServs);
	$file_name=explode(".",$_FILES[$upload_name]['name'][0]);
	/** 根据图片名称获取相应的商品id,是否首图 */
	$tmpsql="select goods_id,is_set,id from $t_tmp_img where img='".$file_name[0]."'";
    $tmpimg= $dbo->getRow($tmpsql);
	if(!isset($tmpimg['goods_id'])||!$tmpimg['goods_id']){
		HandleError("此文件不在csv上传列表中");
		exit;
	}
	
	$up = new upload('jpg|gif|png|jpge',$maxsize = 1024, $field = 'Filedata');
	$up->set_dir($webRoot.'uploadfiles/goods/','{y}/{m}/{d}');
	
	
	$setthumb = array(
	'width' => array($SYSINFO['width1'],$SYSINFO['width2']),
	'height' => array($SYSINFO['height1'],$SYSINFO['height2']),
	'name' => array('thumb','m')
	);
	$up->set_thumb($setthumb);
	
	$fs=$up->execute();//上传图片
	
	$realtxt=$fs[0];

	
	$row=get_shop_info($dbo,$t_shop_info,$shop_id);
	$img_size=unserialize(get_sess_privilege());
	$img_size_m=$img_size['8'];
	$img_size_k=$img_size_m*1024*1024;
	if($row['count_imgsize']>$img_size_k){
		HandleError("上传图片已超过会员限定数，请清理后上传");
	}else if($realtxt['flag']==1){
		dbtarget('w',$dbServs);
		$fileSrcStr=str_replace($webRoot,"",$realtxt['dir']).$realtxt['name'];
		if($tmpimg['is_set']){//修改商品首图
	        $gsql="update $t_goods set goods_thumb='".str_replace($webRoot,"",$realtxt['dir'].$realtxt['thumb'])."',is_set_image='1' where goods_id=".$tmpimg['goods_id'];
	        $dbo->exeUpdate($gsql);
		}
		$insert_array[0]['img_url'] = str_replace($webRoot,"",$realtxt['dir'].$realtxt['m']);
		$insert_array[0]['thumb_url'] = str_replace($webRoot,"",$realtxt['dir'].$realtxt['thumb']);
		$insert_array[0]['img_original'] = str_replace($webRoot,"",$realtxt['dir'].$realtxt['name']);
		$insert_array[0]['is_set'] = $tmpimg['is_set'];
		insert_gallery_info($dbo,$t_goods_gallery,$tmpimg['goods_id'],$insert_array);//增加产品相册
		
		$post[0]['uid']=$user_id;
		$post[0]['img_size']=$realtxt['size'];
		$post[0]['upl_time'] = $ctime->long_time();
		$post[0]['img_url'] = $fileSrcStr;
		$id=img_size($dbo,$t_img_size,$post,$t_shop_info,$row['count_imgsize'],$shop_id);//增加图片表
		
		$tisql="delete from $t_tmp_img where id=".$tmpimg['id'];
	    $dbo->exeUpdate($tisql);//删除临时img表记录
		
        echo $id.":".$fileSrcStr;
	}else if($realtxt[flag]==-1||$realtxt[flag]==-2){
		HandleError($m_langpackage->m_upl_lose);
	}


exit;
?>



