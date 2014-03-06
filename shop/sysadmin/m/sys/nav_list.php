<?php
	/*
	***********************************************
	*$ID:nav_list
	*$NAME:nav_list
	*$AUTHOR:E.T.Wei
	*DATE:Sun Jun 13 16:43:05 CST 2010
	***********************************************
	*/
	if(!$IWEB_SHOP_IN) {
		die('Hacking attempt');
	}
	//文件引入
	require("../foundation/module_nav.php");
	//引入语言包
	$a_langpackage=new adminlp;
	//数据表定义区
	$t_nav = $tablePreStr."nav";
	//读写分类定义方法
	$dbo = new dbex;
	dbtarget("r",$dbServs);
	$sql = "SELECT * FROM $t_nav ";
	$result = $dbo->fetch_page($sql,10);
	$right_update=check_rights("nav_eidt");
	
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
.green {color:green;}
.red {color:red;}
td img {cursor:pointer;}
</style>
<?php require ("a/updateJsAjax.php"); ?>
</head>
<body>
 <?php  include("messagebox.php");?>
<input type="hidden" id="update_right" value="<?php echo $right_update; ?>" ></input>
<div id="maincontent">
	<div class="wrap">
	<div class="crumbs"><?php echo $a_langpackage->a_location; ?> &gt;&gt; <?php echo $a_langpackage->a_global_settings; ?> &gt;&gt;<?php echo $a_langpackage->a_custom_navigation; ?> </div>
        <hr />
	<div class="infobox">
	<h3 ><?php echo $a_langpackage->a_navigation_list; ?><a href="m.php?app=nav_add" style="float:right;*margin-top:-10px;margin-right:15px;"><?php echo $a_langpackage->a_add_navigation;?></a></h3>
    <div class="content2">
		<table class="list_table">
		  <thead>
			<tr style="text-align: center;">
				<th width="80px"><?php echo $a_langpackage->a_navigation; ?>ID</th>
				<th width="100px"><?php echo $a_langpackage->a_navigation_name; ?></th>
				<th width="200px"><?php echo $a_langpackage->a_news_links_url; ?></th>
				<th width="60px"><?php echo $a_langpackage->a_sort; ?></th>
				<th width="40px"><?php echo $a_langpackage->a_operate; ?></th>
			</tr>
			</thead>
			<tbody>
			<?php if($result['result']) {
			foreach($result['result'] as $value) { ?>
			<tr style="text-align: center;">
				<td>
				<?php echo $value['id'];?>
				</td>
				<td>
				<div onclick="edit(this,<?php echo $value['id'];?>,'divname<?php echo $value['id'];?>','a.php?act=updateAjax','tablename=nav&colname=nav_name&idname=id&idvalue=<?php echo $value['id'];?>&logcontent=<?php echo $a_langpackage->a_modify_navigation; ?>&colvalue=',10);">
				<?php echo $value['nav_name'];?></div>
				<div style="display:none;"></div>
				</td>
				<td>
				<div onclick="edit1(this,<?php echo $value['id'];?>,'divurl<?php echo $value['id'];?>','a.php?act=updateAjax','tablename=nav&colname=url&idname=id&idvalue=<?php echo $value['id'];?>&logcontent=<?php echo $a_langpackage->a_modify_navigation; ?>&colvalue=',20,'<?php echo $value['url'];?>');">
				<?php echo $value['url'];?></div>
				<div style="display:none;"></div>
				</td>
				<td><div onclick="editnum(this,<?php echo $value['id'];?>,'divorder<?php echo $value['id'];?>','a.php?act=updateAjax','tablename=nav&colname=short_order&idname=id&idvalue=<?php echo $value['id'];?>&logcontent=<?php echo $a_langpackage->a_modify_navigation; ?>&colvalue=',3);">
				<?php echo $value['short_order'];?></div>
				<div style="display:none;"></div>
				</td>
				<td><a href="m.php?app=nav_edit&nav_id=<?php echo $value['id'];?>"><?php echo $a_langpackage->a_update; ?></a>&nbsp;<a href="a.php?act=nav_del&nav_id=<?php echo $value['id'];?>"><?php echo $a_langpackage->a_delete; ?></a></td>
			</tr>
			<?php }?>
			<?php } else { ?>
			<tr>
				<td colspan="13"><?php echo $a_langpackage->a_no_list; ?></td>
			</tr>
			<?php } ?>
			<tr>
				<td colspan="13" class="center"><?php include("m/page.php"); ?></td>
			</tr>
			</tbody>
		</table>
	   </div>
	  </div>
	</div>
</div>
<script language="JavaScript" src="../servtools/ajax_client/ajax.js"></script>
<script language="JavaScript">
<!--
var inputs = document.getElementsByTagName("input");
function checkall(obj) {
	if(obj.checked) {
		for(var i=0; i<inputs.length; i++) {
			if(inputs[i].type=='checkbox') {
				inputs[i].checked = true;
			}
		}
	} else {
		for(var i=0; i<inputs.length; i++) {
			if(inputs[i].type=='checkbox') {
				inputs[i].checked = false;
			}
		}
	}
}
function toggle_show(obj,name,id) {
	var right=document.getElementById(name).value;
	if(right != '0'){
		var re = /yes/i;
		var src = obj.src;
		var s = 1;
		var searchv = src.search(re);
		if(searchv > 0) {
			s = 0;
		}
		var rights=document.getElementById(name).value;
		ajax("a.php?act=goods_toggle","POST","id="+id+"&s="+s+"&name="+name,function(data){
			if(data) {
				obj.src = '../skin/default/images/'+data+'.gif';
			}
		});
	}else{
		ShowMessageBox("<?php echo $a_langpackage->a_privilege_mess;?>",'m.php?app=error"');
		// location.href="m.php?app=error";
	}

}
//-->
</script>
</body>
</html>