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

$integral = get_integral_list($dbo,$t_integral);

$credit_update=check_rights("credit_update");

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
<form id="form1" name="form1" method="post" action="a.php?act=sys_upd_integral" onsubmit="return checkvalue();">

<div id="maincontent">
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
		<a href="m.php?app=sys_integral_add" ><?php echo $a_langpackage->a_rank_grade_add; ?></a>
	</span></h3>
    <div class="content2">
		<table class="list_table">
			<thead>
				<tr style="text-align:center;">
					<th><?php echo $a_langpackage->a_grade;?></th>
					<th><?php echo $a_langpackage->a_credit_min;?></th>
					<th><?php echo $a_langpackage->a_credit_max;?></th>
					<th><?php echo $a_langpackage->a_credit_img;?></th>
					<th><?php echo $a_langpackage->a_operate;?></th>
				</tr>
			</thead>
			<tbody>
			<?php if($integral) {
				foreach($integral as $val) { ?>
			<tr style="text-align:center;">
				<td><?php echo $val['int_grade'];?></td>
				<td><?php echo $val['int_min']?></td>
				<td><?php echo $val['int_max']?></td>
				<td><img src=".<?php echo $val['int_img']?>" /></td>
				<td><a href="m.php?app=sys_integral_add&id=<?php echo $val['int_id'];?>">修改</a> | 
					<a href="a.php?act=integral_del&id=<?php echo $val['int_id'];?>">删除</a>
				</td>
			</tr>
				<?php }?>
			<tr><td colspan="4">&nbsp;&nbsp;<?php echo $a_langpackage->a_crons_notice;?></td></tr>
			<?php }?>
			</tbody>
		</table>
		</div>
	</div>
</div>
</div>
</form>
</body>
</html>