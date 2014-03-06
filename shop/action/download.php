<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
$t_code = $tablePreStr."code";

//定义读操作
dbtarget('r',$dbServs);
$dbo=new dbex;

$shopid = $_GET['shopid'];
//获取二维码图片
$sql = "select * from $t_code where shop_id='$shopid' ";
$code = $dbo->getRow($sql);
$pic= $webRoot.$code['filesrc'];
$file_name = basename($code['filesrc']);

$file = fopen($pic,"r"); // 打开文件
// 输入文件标签
Header("Content-type: application/octet-stream");
Header("Accept-Ranges: bytes");
Header("Accept-Length: ".filesize($pic));
Header("Content-Disposition: attachment; filename=" . $file_name);
// 输出文件内容
echo fread($file,filesize($pic));
fclose($file);
exit();

