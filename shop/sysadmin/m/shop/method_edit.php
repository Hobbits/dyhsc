<?php
if(!$IWEB_SHOP_IN){
	die('Hacking attempt');
}

//引入语言包
$a_langpackage=new adminlp;
//数据表定义区
$t_transport = $tablePreStr."transport";

$tranid = intval(get_args('id'));
if(!$tranid) {
	trigger_error($a_langpackage->a_error);
}
//读写分离定义方法
$dbo=new dbex;
dbtarget('r',$dbServs);

$sql = "select * from `$t_transport` where tranid=$tranid";
$info = $dbo->getRow($sql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
	<div class="crumbs"><?php echo $a_langpackage->a_location; ?> &gt;&gt; <?php echo $a_langpackage->a_m_order_mengament;?> &gt;&gt; <?php echo $a_langpackage->a_xiu_method; ?></div>
        <hr />
	<div class="infobox">
	<h3><span class="left"><?php echo $a_langpackage->a_xiu_method; ?></span><span class="right" style="margin-right:15px;"><a href="m.php?app=shop_method"><?php echo $a_langpackage->a_ship_method; ?></a></span></h3>
    <div class="content2">
		<form method="post" action="a.php?act=shop_method_edit" name="form_shop_request" onsubmit="return check_form(this)" enctype="multipart/form-data">
		<table>
			<tr><input type="hidden" name="tranid" value="<?php echo $tranid; ?>"/>
				<td width="140px;"><?php echo $a_langpackage->a_tran_name; ?>：</td>
				<td><input type="text" name="tran_name" maxlength="200" style="width:200px" value="<?php echo $info['tran_name']; ?>"/><span class="red">*</span></td>
			</tr>
			<tr>
				<td><?php echo $a_langpackage->a_describe; ?>：</td>
				<td><textarea rows="6" cols="30" name="content"><?php echo $info['content']; ?></textarea></td>
			</tr>
			<tr>
				<td colspan="2"><span class="button-container"><input class="regular-button" type="submit" name="btn_submit" value="<?php echo $a_langpackage->a_xiu_method; ?>"  /></span></td>
			</tr>
		</table>
		</form>
	  </div>
	 </div>
   </div>
</div>
</body>
</html>
<script language="JavaScript" type="text/javascript">
	function check_form(obj){
		if(obj.tran_name.value==''){
			ShowMessageBox("<?php echo $a_langpackage->a_check_complay; ?>","0")
			return false;
		}
		if(obj.content.value==''){
			ShowMessageBox("<?php echo $a_langpackage->a_describe_not; ?>","0")
			return false;
		}
		
	}
</script>