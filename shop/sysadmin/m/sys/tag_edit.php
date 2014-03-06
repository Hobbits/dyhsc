<?php
	/*
	***********************************************
	*$ID:tag_eidt
	*$NAME:tag_eidt
	*$AUTHOR:E.T.Wei
	*DATE:Mon Jun 07 10:17:18 CST 2010
	***********************************************
	*/
	if(!$IWEB_SHOP_IN) {
		die('Hacking attempt');
	}
	
	//文件引入
	require("../foundation/module_tag.php");
	//引入语言包
	$a_langpackage=new adminlp;
	//数据表定义区
	$t_tag = $tablePreStr."tag";
	$t_goods = $tablePreStr."goods";	
	$right_array=array(
		"tag_del"    =>   "0",
	    "tag_eidt"    =>   "0",
	);
	foreach($right_array as $key => $value){
		$right_array[$key]=check_rights($key);
	}
	//读写分类定义方法
	$dbo = new dbex;
	dbtarget("r",$dbServs);
	$tag_id = intval(get_args("tag_id"));
	if (!$tag_id) {
		trigger_error($a_langpackage->a_error);
	}
	$tag_info = get_tag_info($dbo,$t_tag,$t_goods,$tag_id);
//	print_r($tag_info);
	
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
	<div class="wrap">
	<div class="crumbs"><?php echo $a_langpackage->a_location; ?> &gt;&gt; <?php echo $a_langpackage->a_m_aboutgoods_management; ?> &gt;&gt; <?php echo $a_langpackage->a_tag_list; ?></div>
        <hr />
	<div class="infobox">
	<h3><span class="left"><?php echo $a_langpackage->a_update_tag; ?></span> <span class="right" style="margin-right:15px;"><a href="m.php?app=tag_list" style="float:right;"><?php echo $a_langpackage->a_tag_list; ?></a></span></h3>
    <div class="content2">
			<form action="a.php?act=tag_edit" method="post" onsubmit="return checkform();" enctype="multipart/form-data">
			<table class="form-table">
			<tr>
				<td width="63px;"><?php echo $a_langpackage->a_tag_goods; ?>：</td>
				<td><input class="small-text" type="text" name="tag_name" value="<?php echo $tag_info['tag_name']; ?>" /> <span>*</span></td>
			</tr>
			<tr>
				<td><?php echo $a_langpackage->a_tag_goods; ?>：</td>
				<td><?php echo $tag_info['goods_name'];?></td>
			</tr>
			<tr>
				<td><?php echo $a_langpackage->a_tag_color; ?>：</td>
				<td>
					<input type="text" style="background:#<?php echo $tag_info['tag_color'];?>" name="tag_color" value="#<?php echo $tag_info['tag_color']?>" onclick="coloropen(event)" id="inputcolor" />
					<div id="colorpane" style="position:absolute;z-index:999;display:none;"></div> 
				</td>
			</tr>
			<td><?php echo $a_langpackage->a_whether_bold; ?></td>
			<td>
				<input type="checkbox"  name="is_blod" value="1"  <?php if ($tag_info['is_blod']==1) {echo "checked";}?>>
			</td>
			<tr>
				<td><?php echo $a_langpackage->a_sort; ?>：</td>
				<td><input type="text" name="short_order" value="<?php echo $tag_info['short_order']?>" /></td>
			</tr>
			<tr>
				<input type="hidden" name="tag_id" value="<?php echo $tag_id; ?>" />
				<td colspan="2"><span class="button-container"><input class="regular-button" type="submit" name="submit" value="<?php echo $a_langpackage->a_submit2; ?>" /></td>
			</tr>
			</table>
			</form>
		  </div>
		 </div>
		</div>
	</div>
</body>
</html>
<script type="text/javascript" language="javascript"> 
<!-- 
var ColorHex=new Array('00','33','66','99','CC','FF') 
var SpColorHex=new Array('FF0000','00FF00','0000FF','FFFF00','00FFFF','FF00FF') 
var current=null 
function initcolor(evt) 
{ 
var colorTable='' 
for (i=0;i<2;i++) 
{ 
for (j=0;j<6;j++) 
{ 
colorTable=colorTable+'<tr height=15>' 
colorTable=colorTable+'<td width=10 style="background-color:#000000">' 
if (i==0){ 
colorTable=colorTable+'<td width=10 style="cursor:pointer;background-color:#'+ColorHex[j]+ColorHex[j]+ColorHex[j]+'" onclick="doclick(this.style.backgroundColor)">'} 
else{ 
colorTable=colorTable+'<td width=10 style="cursor:pointer;background-color:#'+SpColorHex[j]+'" onclick="doclick(this.style.backgroundColor)">'} 
colorTable=colorTable+'<td width=10 style="background-color:#000000">' 
for (k=0;k<3;k++) 
{ 
for (l=0;l<6;l++) 
{ 
colorTable=colorTable+'<td width=10 style="cursor:pointer;background-color:#'+ColorHex[k+i*3]+ColorHex[l]+ColorHex[j]+'" onclick="doclick(this.style.backgroundColor)">' 
} 
} 
} 
} 
colorTable='<table border="0" cellspacing="0" cellpadding="0" style="border:1px #000000 solid;border-bottom:none;border-collapse: collapse;width:200px;" bordercolor="000000">' 
+'<tr height=20><td colspan=21 bgcolor=#ffffff style="font:12px tahoma;padding-left:2px;">' 
+'<span style="float:left;color:#999999;">点击颜色选取</span>' 
+'<span style="float:right;padding-right:3px;cursor:pointer;" onclick="colorclose()">×关闭</span>' 
+'</td></table>' 
+'<table border="1" cellspacing="0" cellpadding="0" style="border-collapse: collapse" bordercolor="000000" style="cursor:pointer;">' 
+colorTable+'</table>'; 
document.getElementById("colorpane").innerHTML=colorTable; 
var current_x = document.getElementById("inputcolor").offsetLeft; 
var current_y = document.getElementById("inputcolor").offsetTop; 
//alert(current_x + "-" + current_y) 
document.getElementById("colorpane").style.left = current_x + "px"; 
document.getElementById("colorpane").style.top = current_y + "px"; 
} 
function doclick(obj){ 
	document.getElementById('inputcolor').value=obj;
	document.getElementById('inputcolor').style.background=obj;
	colorclose();
} 
function colorclose(){ 
document.getElementById("colorpane").style.display = "none"; 
} 
function coloropen(){ 
document.getElementById("colorpane").style.display = ""; 
} 
window.onload = initcolor; 
</script> 