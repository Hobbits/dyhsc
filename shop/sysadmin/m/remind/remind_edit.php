<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

require_once("../foundation/module_news.php");

//引入语言包
$a_langpackage=new adminlp;

$id = short_check(get_args('id'));

//数据表定义区
$t_remind_info = $tablePreStr."remind_info";
//定义写操作
dbtarget('w',$dbServs);
$dbo=new dbex;
$sql = "select * from $t_remind_info where rinfo_id = $id";
$row = $dbo->getRow($sql);
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
	<div class="crumbs"><?php echo $a_langpackage->a_location; ?> &gt;&gt; <?php echo $a_langpackage->a_promotion_manage;?> &gt;&gt; <?php echo $a_langpackage->a_message_update; ?></div>
        <hr />
	<div class="infobox">
	<h3><span class="left" ><?php echo $a_langpackage->a_message_update; ?></span> <span class="right" style="margin-right:15px;"><a href="m.php?app=message_list"><?php echo $a_langpackage->a_set_message; ?></a></span></h3>
    <div class="content2">
		<form action="a.php?act=remind_update" method="post" onsubmit="return checkForm();">
		<table class="form-table"> 
			<tr><input type="hidden" name="rinfo_id" value="<?php echo $id;?>"/>
				<td width="70px" class="left"><?php echo $a_langpackage->a_message_conten; ?>：</td>
				<td class="left"><textarea rows="6" cols="30" name="remind_info"><?php echo $row['remind_info'];?></textarea></td>
			</tr>
			<tr><td colspan="2"><span class="button-container"><input class="regular-button" type="submit" name="submit" value="<?php echo $a_langpackage->a_message_update; ?>" /></td></span></tr>
		</table>
		</form>
	  </div>
	 </div>
	</div>
</div>
<script language="JavaScript">
<!--
function checkForm() {
	var cat_name = document.getElementsByName("remind_info")[0];
	if(cat_name.value=='') {
		ShowMessageBox("<?php echo $a_langpackage->a_message_null; ?>",'0');
		return false;
	}
	return true;
}
//-->
</script>
</body>
</html>