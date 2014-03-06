<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
//定义数据表
$t_tag = $tablePreStr."tag";

$tag_id=intval(get_args('tag_id'));
$tagcommend=intval(get_args('tagcommend'));

$sql="update $t_tag set is_recommend=$tagcommend where tag_id=$tag_id";

//定义写操作
dbtarget('w',$dbServs);
$dbo=new dbex;
$val="";
if($dbo->exeUpdate($sql)){
	if($tagcommend){
		$val= 'yes';
	}else{
		$val= 'no';
	}
}else{
if($tagcommend){
		$val= 'no';
	}else{
		$val= 'yes';
	}
}
$sql="select count(*) from $t_tag where is_recommend='1'";
$row=$dbo->getRow($sql);
echo $val.".".$row[0];
exit;
?>