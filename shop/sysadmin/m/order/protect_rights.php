<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

//引入语言包
$a_langpackage=new adminlp;
//数据表定义区
$t_protect_rights = $tablePreStr."protect_rights";
$t_shop_info = $tablePreStr."shop_info";
$t_users = $tablePreStr."users";

//读写分离定义方法
$dbo = new dbex;
dbtarget('r',$dbServs);

$sql = "select pr.*,si.shop_name,u.user_name from `$t_protect_rights` as pr join `$t_shop_info` as si on pr.shop_id = si.shop_id join `$t_users` as u on pr.user_id = u.user_id  where pr.status = 2  order by pr.status desc;";

$result = $dbo->fetch_page($sql,13);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link rel="stylesheet" type="text/css" href="skin/css/admin.css">
<link rel="stylesheet" type="text/css" href="skin/css/main.css">
<script type='text/javascript' src="skin/js/jy.js"></script>
<style>
td span {color:red;}
.green {color:green;}
.red {color:red;}
.black {color:#cccccc;}
</style>
</head>
<body>
<div id="maincontent">
 <?php  include("messagebox.php");?>
	<div class="wrap">
	<div class="crumbs"><?php echo $a_langpackage->a_location; ?> &gt;&gt; <a href=""><?php echo $a_langpackage->a_protect_rights;?></a></div>
	<div class="seachbox">
    </div>
	<div class="infobox">
	<h3><?php echo $a_langpackage->a_protect_rights;?></h3>
    <div class="content2">
		<form action="a.php?act=order_set_status" name="postForm" method="post" onsubmit="return submitform();">
		<table class="list_table">
			<thead>
			<tr style=" text-align:center">
				<th width="10%"><?php echo $a_langpackage->a_orderID;?></th>
				<th width="15%" align="left"><?php echo $a_langpackage->a_shop_name2;?></th>
				<th width="15%" align="left">维权用户</th>
				<th width="10%" align="left">维权项目</th>
				<th width="" align="left"><?php echo $a_langpackage->a_status;?></th>
				<th width="10%"><?php echo $a_langpackage->a_operate;?></th>
			</tr>
			</thead>
			<tbody>
			<?php if($result['result']) {
			foreach($result['result'] as $value) { ?>
			<tr style=" text-align:center">
				<td width="10%"><font size="-6"><?php echo $value['order_id'];?></font></td>
				<td width="15%" align="left">
					<a href="../shop.php?shopid=<?php echo $value['shop_id'];?>" target="_blank"><?php echo $value['shop_name'];?>
				</td>
				<td width="15%" align="left"><?php echo $value['user_name'];?></td>
				<td width="10%" align="left"><?php if($value['protect_item'] == '1')
							echo "退款";
				?></td>
				<td width="" align="left">
				<?php if($value['status']==1){
						echo "<span class='red'>客服介入中</span><br />";
					} else {
						echo "<span class='black'>维权结束</span><br />";
				}?></td>
				<td width="10%">
					<a href="m.php?app=protect_rights_info&id=<?php echo $value['order_id'];?>"><?php echo $a_langpackage->a_look;?></a> | 
					<a href="a.php?act=close_protect_rights&order_id=<?php echo $value['order_id'];?>&pid=<?php echo $value['pid'];?>">结束维权</a>
				</td>
			</tr>
			<?php }} else { ?>
			<tr>
				<td colspan="11"><?php echo $a_langpackage->a_no_list;?></td>
			</tr>
			<?php } ?>
			<tr>
				<td colspan="11"><?php include("m/page.php"); ?></td>
			</tr>
			</tbody>
		</table>
		</form>
		</div>
	  </div>
	</div>
</div>
</body>
</html>