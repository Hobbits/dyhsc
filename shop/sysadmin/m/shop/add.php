<?php
if(!$IWEB_SHOP_IN){
	die('Hacking attempt');
}

//引入语言包
$a_langpackage=new adminlp;
//数据表定义区
$t_shop_request = $tablePreStr."shop_request";
$t_shop_info = $tablePreStr."shop_info";

$uid = intval(get_args('id'));

//读写分离定义方法
$dbo=new dbex;
dbtarget('r',$dbServs);

$sql = "select * from `$t_shop_request` where user_id='$uid'";
$shopsql="select * from `$t_shop_info` where user_id='$uid'";

$request_info = $dbo->getRow($sql);
$shop_info = $dbo->getRow($shopsql);
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
	<div class="crumbs"><?php echo $a_langpackage->a_location; ?> &gt;&gt; <?php echo $a_langpackage->a_m_shop_mengament;?> &gt;&gt; <?php echo $a_langpackage->a_app_member; ?></div>
        <hr />
	<div class="infobox">
	<h3><span class="left"><?php echo $a_langpackage->a_app_member; ?></span><span class="right" style="margin-right:15px;"><a href="m.php?app=asd_list"><?php echo $a_langpackage->a_memeber_list; ?></a></span></h3>
    <div class="content2">
		<form method="post" action="a.php?act=shop_add" name="form_shop_request" onsubmit="return check_form(this)" enctype="multipart/form-data">
		<table>
			<tr>
				<td width="140px;"><?php echo $a_langpackage->a_companyname; ?>：</td>
				<td><input type="text" name="company_name" maxlength="200" style="width:200px" value="<?php echo $request_info['company_name']; ?>"/><span class="red">*</span></td>
			</tr><input type="hidden" name="uid" value="<?php echo $uid; ?>"/><input type="hidden" name="request_id" value="<?php echo $request_info['request_id']; ?>"/>
			<tr>
				<td><?php echo $a_langpackage->a_person_name; ?>：</td>
				<td><input type="text" name="person_name" maxlength="200" style="width:200px" value="<?php echo $request_info['person_name']; ?>"/><span class="red">*</span></td>
			</tr>
			<tr>
				<td><?php echo $a_langpackage->a_credit_type; ?>：</td>
				<td><select name="credit_type">
					<option value="身份证">身份证</option>
					<option value="军官证">军官证</option>
					</select> <span class="red">*</span></td>
			</tr>
			<tr>
				<td><?php echo $a_langpackage->a_credit_num; ?>：</td>
				<td><input type="text" name="credit_num" maxlength="200" style="width:200px" value="<?php echo $request_info['credit_num']; ?>"/><span class="red">*</span></td>
			</tr>
			<tr>
				<td><?php echo $a_langpackage->a_attach; ?>：</td>
				<td><input type="file" name="attach[]" /> <span class="red">*</span>支持的文件格式（jpg,gif,png）</td>
			</tr>
			<tr>
				<td><?php echo $a_langpackage->a_companyarea; ?>：</td>
				<td><input type="text" name="company_area" maxlength="200" style="width:200px" value="<?php echo $request_info['company_area']; ?>" /></td>
			</tr>
			<tr>
				<td><?php echo $a_langpackage->a_company_address; ?>：</td>
				<td><input type="text" name="company_address" maxlength="200" style="width:300px" value="<?php echo $request_info['company_address']; ?>"/> <span class="red">*</span></td>
			</tr>
			<tr>
				<td><?php echo $a_langpackage->a_zipcode; ?>：</td>
				<td><input type="text" name="zipcode" maxlength="10" style="width:100px" value="<?php echo $request_info['zipcode']; ?>"/> <span class="red">*</span></td>
			</tr>
			<tr>
				<td><?php echo $a_langpackage->a_mobile_code; ?>：</td>
				<td><input type="text" name="mobile" maxlength="20" style="width:200px" value="<?php echo $request_info['mobile']; ?>"/> <span class="red">*</span></td>
			</tr>
			<tr>
				<td><?php echo $a_langpackage->a_telphone_code; ?>：</td>
				<td><input type="text" name="telphone" maxlength="20" style="width:200px" value="<?php echo $request_info['telphone']; ?>"/> <span class="red">*</span></td>
			</tr>
			<tr>
				<td colspan="2"><span class="button-container"><input class="regular-button" type="submit" name="btn_submit" value="<?php echo $a_langpackage->a_app_member; ?>"  /></span></td>
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
		if(obj.company_name.value==''){
			ShowMessageBox("<?php echo $a_langpackage->a_check_complay; ?>","0")
			return false;
		}
		if(obj.person_name.value==''){
			ShowMessageBox("<?php echo $a_langpackage->a_check_person; ?>","0")
			return false;
		}
		if(obj.credit_num.value==''){
			ShowMessageBox("<?php echo $a_langpackage->a_check_card; ?>","0")
			return false;
		}
		if(isNaN(obj.credit_num.value.substr(0,obj.credit_num.value.length-1))){
			ShowMessageBox("<?php echo $a_langpackage->a_check_truecard; ?>","0")
			return false;
		}
		if(obj.company_address.value==''){
			ShowMessageBox("<?php echo $a_langpackage->a_check_address; ?>","0")
			return false;
		}
		if(obj.zipcode.value==''){
			ShowMessageBox("<?php echo $a_langpackage->a_check_postcode; ?>","0")
			return false;
		}
		if(isNaN(obj.zipcode.value)){
			ShowMessageBox("<?php echo $a_langpackage->a_check_postcodeisnum; ?>","0")
			return false;
		}
		if(obj.mobile.value==''){
			ShowMessageBox("<?php echo $a_langpackage->a_check_mobile; ?>","0")
			return false;
		}
		if(isNaN(obj.mobile.value)){
			ShowMessageBox("<?php echo $a_langpackage->a_check_mobileisnum; ?>","0")
			return false;
		}
		if(obj.telphone.value==''){
			ShowMessageBox("<?php echo $a_langpackage->a_check_phone; ?>","0")
			return false;
		}
		if(isNaN(obj.telphone.value)){
			ShowMessageBox("<?php echo $a_langpackage->a_check_phoneisnum; ?>","0")
			return false;
		}
	}
</script>