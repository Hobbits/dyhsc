<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

//引入语言包
$a_langpackage=new adminlp;
require("../foundation/asystem_info.php");
// require("../foundation/module_remind.php");
$verifycode =  unserialize($SYSINFO['verifycode']);

//require ("a/updateJsAjax.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link rel="stylesheet" type="text/css" href="skin/css/admin.css">
<link rel="stylesheet" type="text/css" href="skin/css/main.css">
<style>

</style>
</head>
<body>
<div id="maincontent">
	<div class="wrap">
	<div class="crumbs"><?php echo $a_langpackage->a_location; ?> &gt;&gt; <?php echo $a_langpackage->a_global_settings; ?> &gt;&gt; <?php echo $a_langpackage->a_verifycode_setting; ?></div>
        <hr />
	<div class="infobox">
	<h3><?php echo $a_langpackage->a_verifycode_setting; ?></h3>
    <div class="content2">
		<table class="list_table" style="font-size:12px;">
			<thead>
				<tr style="text-align:center;">
					<th align="left"><?php echo $a_langpackage->a_verifycode_module; ?></th>
					<th align="right" width="80px" colspan="2"><?php echo $a_langpackage->a_verifycode_status; ?></th>
				</tr>
			</thead>
			<tbody>
			<tr style="text-align:center;">
				<td id="type_1" align="left"><?php echo $a_langpackage->a_verifycode_login ?></td>
			
			
				<td width="" align="right" id="now_status_1"><?php if($verifycode['1']==1) {echo "<span style='color:green;'>".$a_langpackage->a_open."</span>";} else {echo "<span style='color:red;'>".$a_langpackage->a_close."</span>";} ?></td>
				<td width="40px" align="right" onclick="toggle(this,1)" style="cursor:pointer;text-decoration:underline;"><?php if($verifycode['1']) {echo $a_langpackage->a_close;} else {echo $a_langpackage->a_open;} ?></td>
				
			</tr>
			
				<tr style="text-align:center;">
				<td id="type_2" align="left"><?php echo $a_langpackage->a_verifycode_register ?></td>
			
			
				<td width="" align="right" id="now_status_2"><?php if($verifycode['2']==1) {echo "<span style='color:green;'>".$a_langpackage->a_open."</span>";} else {echo "<span style='color:red;'>".$a_langpackage->a_close."</span>";} ?></td>
				<td width="40px" align="right" onclick="toggle(this,2)" style="cursor:pointer;text-decoration:underline;"><?php if($verifycode['2']) {echo $a_langpackage->a_close;} else {echo $a_langpackage->a_open;} ?></td>
				
			</tr>
				<tr style="text-align:center;">
				<td id="type_3" align="left"><?php echo $a_langpackage->a_verifycode_leave_msg ?></td>
				<td width="" align="right" id="now_status_3"><?php if($verifycode['3']==1) {echo "<span style='color:green;'>".$a_langpackage->a_open."</span>";} else {echo "<span style='color:red;'>".$a_langpackage->a_close."</span>";} ?></td>
				<td width="40px" align="right" onclick="toggle(this,3)" style="cursor:pointer;text-decoration:underline;"><?php if($verifycode['3']) {echo $a_langpackage->a_close;} else {echo $a_langpackage->a_open;} ?></td>
				
			</tr>
			
			<tr style="text-align:center;">
				<td id="type_4" align="left"><?php echo $a_langpackage->a_verifycode_goods_tag ?></td>
				<td width="" align="right" id="now_status_4"><?php if($verifycode['4']==1) {echo "<span style='color:green;'>".$a_langpackage->a_open."</span>";} else {echo "<span style='color:red;'>".$a_langpackage->a_close."</span>";} ?></td>
				<td width="40px" align="right" onclick="toggle(this,4)" style="cursor:pointer;text-decoration:underline;"><?php if($verifycode['4']) {echo $a_langpackage->a_close;} else {echo $a_langpackage->a_open;} ?></td>
				
			</tr>
			
			</tbody>
		</table>
	  </div>
	  </div>
	</div>
</div>

<script language="JavaScript" src="../servtools/ajax_client/ajax.js"></script>
<script language="JavaScript">
function toggle(obj,id) {
	var v = 1;
	if(obj.innerHTML=='<?php echo $a_langpackage->a_close; ?>') {
		v = 0;
	}
	ajax("./a.php?act=verifycode_status","POST","v="+v+"&id="+id,function(data){
		if(data=='1') {
			var now_status = document.getElementById("now_status_"+id);
			if(v) {
				obj.innerHTML = '<?php echo $a_langpackage->a_close; ?>';
				now_status.innerHTML = "<span style='color:green;'><?php echo $a_langpackage->a_open; ?></span>";
			} else {
					obj.innerHTML = '<?php echo $a_langpackage->a_open; ?>';
					now_status.innerHTML = "<span style='color:red;'><?php echo $a_langpackage->a_close; ?></span>";
			}
		}
	});
}
</script>
</body>
</html>