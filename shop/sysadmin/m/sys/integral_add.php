<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
require("../foundation/module_credit.php");

//引入语言包
$a_langpackage=new adminlp;

//数据表定义区
$t_integral = $tablePreStr."integral";

//变量定义区

$dbo=new dbex;
//读写分离定义方法
dbtarget('r',$dbServs);
$int_id = short_check(get_args('id'));
$row =array('int_id'=>'','int_min'=>'','int_max'=>'','int_grade'=>'','int_img'=>'');
$button_title = $a_langpackage->a_rank_grade_add;
if(get_args('id')){

	$sql = "select * from `$t_integral` where int_id = $int_id";
	$row = $dbo->getRow($sql);
	$button_title = $a_langpackage->a_rank_grade_edit;
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
.green {color:green;}
.red {color:red;}
.edit span{background:#efefef;}
</style>
</head>
<body>

<div id="maincontent">
<?php  include("messagebox.php");?>
	<div class="wrap">
	<div class="crumbs">
		<?php echo $a_langpackage->a_location; ?>&gt;&gt; 
		<?php echo $a_langpackage->a_m_shop_mengament;?> &gt;&gt; 
		<?php echo $a_langpackage->a_rank_grade;?>
	</div>
        <hr />
	<div class="infobox">
	<h3><?php echo $a_langpackage->a_m_sys_integral; ?>
	<span class="right">
		<a href="m.php?app=sys_integral" ><?php echo $a_langpackage->a_m_sys_integral; ?></a>
	</span></h3>
    <div class="content2">
		<form action="a.php?act=integral_add" method="post"  enctype="multipart/form-data" onsubmit="return checkForm();">
		<table class="form-table">
			<tr>
				<td width="72px"><?php echo $a_langpackage->a_grade; ?>：</td>
				<td><input id="credit_grade" class="small-text" type="text" name="credit_grade" value="<?php echo $row['int_grade']; ?>" style="width:200px;" /></td>
			</tr>
			<tr>
				<td><?php echo $a_langpackage->a_credit_min; ?>：</td>
				<td><input id="credit_min" class="small-text" type="text" name="credit_min" value="<?php echo $row['int_min']; ?>" style="width:200px;" /></td>
			</tr>
			<tr>
				<td><?php echo $a_langpackage->a_credit_max; ?>：</td>
				<td><input id="credit_max" class="small-text" type="text" name="credit_max" value="<?php echo $row['int_max']; ?>" style="width:200px;" /></td>
			</tr>
			<tr>
				<td><?php echo $a_langpackage->a_credit_img; ?>：</td>
				<td><input type="file" name="credit_img[]" />
					<input type="hidden" name="credit_img_old" value='<?php echo $row['int_img']; ?>' />
					<input type="hidden" name="id" value='<?php echo $row['int_id']; ?>' />
				</td>
			</tr>
			<tr><td colspan="2"><span class="button-container"><input class="regular-button" type="submit" name="submit" value="<?php echo $button_title; ?>" /></span></td></tr>
		</table>
		</form>
		</div>
	</div>
</div>
</div>
<script language="JavaScript">
<!--
function checkForm() {
	var credit_grade = document.getElementById("credit_grade").value;
	var credit_min = document.getElementById("credit_min").value;
	var credit_max = document.getElementById("credit_max").value;
	if(credit_grade==''){
		ShowMessageBox('<?php echo $a_langpackage->a_rank_grade_not_null;?>','0')
        return false;
    }
	if(credit_min==''){
		ShowMessageBox('<?php echo $a_langpackage->a_rank_min_not_null;?>','0')
        return false;
    }
	if(credit_max==''){
		ShowMessageBox('<?php echo $a_langpackage->a_rank_max_not_null;?>','0')
        return false;
    }
	var num_reg = /^(\d+)$/;
	// alert('aa');
	if(!num_reg.test(credit_grade)){
		ShowMessageBox('<?php echo $a_langpackage->a_rank_grade_format;?>','0')
        return false;
    }
	if(!num_reg.test(credit_min)){
		ShowMessageBox('<?php echo $a_langpackage->a_rank_min_format;?>','0')
        return false;
    }
	if(!num_reg.test(credit_max)){
		ShowMessageBox('<?php echo $a_langpackage->a_rank_max_format;?>','0')
        return false;
    }
	if(parseInt(credit_min)>parseInt(credit_max)){
		ShowMessageBox('<?php echo $a_langpackage->a_rank_max_min_format;?>','0')
        return false;
    }
	
	return true;
}
//-->
</script>
</body>
</html>