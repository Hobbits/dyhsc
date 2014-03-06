<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
require_once("../foundation/module_admin_logs.php");
//定义文件表
$t_index_images = $tablePreStr."index_images";
$t_admin_log = $tablePreStr."admin_log";

//语言包引入
$a_langpackage=new adminlp;

//权限管理
$right=check_rights("image_upload");
if(!$right){
	action_return(0,$a_langpackage->a_privilege_mess,'m.php?app=error');
}
//数据库操作
dbtarget('w',$dbServs);
$dbo=new dbex();
//统计首页图片的总数量
$sql="select count(*) from $t_index_images where status=1";
$row = $dbo->getRow($sql);
$index_images_num = $row[0];
// 图片上传处理
$cupload = new upload('jpg');
$cupload->set_dir("../uploadfiles/index/","{y}/{m}/{d}");
$file = $cupload->execute();

$img_name = array();
foreach(get_args('img_name') as $k=>$v) {
	$img_name[$k] = short_check($v);
}

$img_link = array();
foreach(get_args('img_link') as $k=>$v) {
	$img_link[$k] = short_check($v);
}
$img='';
if($file) {
	$insert_array = array();
	foreach($file as $k=>$v) {
		if($v['flag']==1) {
			$v['dir'] = str_replace('../','./',$v['dir']);
			$insert_array[$k]['images_url'] = $v['dir'].$v['name'];
			if($img_link[$k]==''){
				//$img_link[$k]='http://';
			}
			$insert_array[$k]['images_link'] = $img_link[$k];

			$insert_array[$k]['name'] = $img_name[$k];
			$insert_array[$k]['add_time'] = $ctime->long_time();
			if($index_images_num < 6){
				$insert_array[$k]['status'] = 1;
				$index_images_num++;
			}else{
				$insert_array[$k]['status'] = 0;
			}
		}elseif($v['flag']==-1){
			$img.= $v['name']." ";
		}
	}
	insert_index_images($dbo,$t_index_images,$insert_array);
}
if($img==''){
	/** 添加log */
	$admin_log =$a_langpackage->a_upload_index_img;
	admin_log($dbo,$t_admin_log,$admin_log);

	action_return(1);
}else{
	action_return(1,$a_langpackage->a_file.$img.$a_langpackage->a_upload_fail);
}
function insert_index_images(&$dbo,$table,$insert_array) {
	if(empty($insert_array)) { return false;}
	$i = 0;
	foreach($insert_array as $v) {
		$insert_items = $v;
		$item_sql = get_insert_item($insert_items);
		$sql = "insert `$table` $item_sql";
		if($dbo->exeUpdate($sql)) {
			$i++;
		}
	}
	return $i;
}
?>