<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

require("../foundation/module_payment.php");
//引入语言包
$a_langpackage=new adminlp;
//定义读操作
dbtarget('r',$dbServs);
$dbo=new dbex;

//数据表定义区
$t_transport = $tablePreStr."transport";

$sql="select * from $t_transport";
$array = $dbo->getRs($sql);
$right_array=array(
	"remind_oper"    =>   "0",
    "remind_update"    =>   "0",
);
foreach($right_array as $key => $value){
	$right_array[$key]=check_rights($key);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link rel="stylesheet" type="text/css" href="skin/css/admin.css">
<link rel="stylesheet" type="text/css" href="skin/css/main.css">
<style>
td span {color:red;}
</style>
</head>
<body>
<div id="maincontent">
 <?php  include("messagebox.php");?>
	<div class="wrap">
	<div class="crumbs"><?php echo $a_langpackage->a_location; ?> &gt;&gt; <?php echo $a_langpackage->a_m_order_mengament;?> &gt;&gt; <?php echo $a_langpackage->a_shipp;?></div>
        <hr />
	<div class="infobox">
	<h3><span class="left"><?php echo $a_langpackage->a_ship_method; ?></span><span class="right" style="margin-right:15px;"><a href="m.php?app=method_add" style="float:right;"><?php echo $a_langpackage->a_add_method; ?></a></span></h3>
    <div class="content2">
		<table class="list_table">
		 <thead>
			<tr style="text-align:center;"><input type="hidden" id="remind_oper" value="<?php echo $right_array['remind_oper'];?>">
				<th width="80px" align="middle"><?php echo $a_langpackage->a_shipp;?></th>
				<th width="90px"><?php echo $a_langpackage->a_describe;?></th>
				<th style="width:60px;"><?php echo $a_langpackage->a_now_status;?></th>
				<th style="width:60px;"><?php echo $a_langpackage->a_operate;?></th>
			</tr>
		  </thead>
		  <tbody>
		<?php foreach($array as $value) { ?>
			<tr style="text-align:center;">
				<td align="left"><?php echo $value['tran_name'];?></td>
				<td align="left"><?php echo $value['content'];?></td>
				<td width="40px" align="center" id="now_status_<?php echo $value['tranid'];?>"><?php if($value['ifopen']==1) {echo "<span style='color:green;'>".$a_langpackage->a_open."</span>";} else {echo "<span style='color:red;'>".$a_langpackage->a_close."</span>";} ?></td>
				<td width="40px" align="center" style="cursor:pointer;text-decoration:underline;"><a href="javascript:;"  onclick="toggle(this,<?php echo $value['tranid'];?>)"><?php if($value['ifopen']) {echo $a_langpackage->a_close;} else {echo $a_langpackage->a_open;} ?></a><br /><a href="m.php?app=method_edit&id=<?php echo $value['tranid'];?>"><?php echo $a_langpackage->a_update;?></a></td>
			</tr>
		<?php } ?>
		</tbody>
		<tbody>
			<tr><td colspan="7"><?php echo $a_langpackage->a_notice1;?>
			<br />　　　<?php echo $a_langpackage->a_notice2;?>
			<br />　　　<?php echo $a_langpackage->a_notice3;?></td></tr></tbody>
		</table>
		</div>
	</div>
</div></div>
<script language="JavaScript" src="../servtools/ajax_client/ajax.js"></script>
<script language="JavaScript">
<!--
function toggle(obj,id) {
	var right=document.getElementById("remind_oper").value;
	if(right !=0){
		var v = 1;
		var d = new Date();
		var t = d.getTime();
		if(obj.innerHTML=='<?php echo $a_langpackage->a_close;?>') {
			v = 0;
		}
		ajax("./a.php?act=ship_method_toggle&t="+t,"POST","v="+v+"&id="+id,function(data){
			if(data=='1') {
				var now_status = document.getElementById("now_status_"+id);
				if(v) {
					obj.innerHTML = '<?php echo $a_langpackage->a_close;?>';
					now_status.innerHTML = "<span style='color:green;'><?php echo $a_langpackage->a_open;?></span>";
				} else {
					obj.innerHTML = '<?php echo $a_langpackage->a_open;?>';
					now_status.innerHTML = "<span style='color:red;'><?php echo $a_langpackage->a_close;?></span>";
				}
			}
		});
	}else{
		ShowMessageBox("<?php echo $a_langpackage->a_a_m_popedom; ?>",'m.php?app=error"');
		// location.href="m.php?app=error";
	}
}
//-->
</script>
</body>
</html>