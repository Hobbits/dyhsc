<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
require("foundation/module_img_size.php");
require("foundation/module_shop.php");
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
	$dbo=new dbex();
	dbtarget('r',$dbServs);
	$t_shop_info=$tablePreStr."shop_info";
	$t_img_size=$tablePreStr."img_size";
	$row=get_shop_info($dbo,$t_shop_info,$shop_id);
	
	$img_size=unserialize(get_sess_privilege());
	$img_size_m=$img_size['8'];
	$img_size_k=$img_size_m*1024*1024;
	if($row['count_imgsize']>$img_size_k){
		HandleError("上传图片已超过会员限定数，请清理后上传");
		exit;
	}
	$up = new upload('jpg|gif|png|jpge',$maxsize = 1024, $field = 'Filedata');
	$up->set_dir($webRoot.'uploadfiles/goods/','{y}/{m}/{d}');
	$fs=$up->execute();
	
	$realtxt=$fs[0];

	if($realtxt['flag']==1){
		dbtarget('w',$dbServs);

		$fileSrcStr=str_replace($webRoot,"",$realtxt['dir']).$realtxt['name'];
		$post[0]['uid']=$user_id;
		$post[0]['img_size']=$realtxt['size'];
		$post[0]['upl_time'] = $ctime->long_time();
		$post[0]['img_url'] = $fileSrcStr;
		$post[0]['is_intro_img']='1';
        if(get_args("gid")){
        	$post[0]['goods_id'] = intval(get_args("gid"));
        }
		$id=img_size($dbo,$t_img_size,$post,$t_shop_info,$row['count_imgsize'],$shop_id);
        echo $id.":".$fileSrcStr;
	}else if($realtxt[flag]==-1||$realtxt[flag]==-2){
		HandleError($m_langpackage->m_upl_lose);
	}


exit;
?>