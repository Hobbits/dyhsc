<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

require_once("../foundation/module_complaint.php");

//引入语言包
$a_langpackage=new adminlp;

//数据表定义区
$t_complaints = $tablePreStr."complaints";
$t_complaint_type = $tablePreStr."complaint_type";
$t_users = $tablePreStr."users";
$t_goods = $tablePreStr."goods";

//读写分离定义方法
$dbo = new dbex;
dbtarget('r',$dbServs);
$sql="select c.*,u.locked,u.user_name,g.lock_flg from $t_complaints c join $t_users u ON c.user_id =u.user_id join $t_goods g on c.goods_id=g.goods_id";
$result = $dbo->fetch_page($sql,13);

//print_r($type_rs);

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
</style>
</head>
<body>
<div id="maincontent">
	<div class="wrap">
	<div class="crumbs"><?php echo $a_langpackage->a_location; ?> &gt;&gt; <?php echo $a_langpackage->a_m_order_mengament;?> &gt;&gt; <?php echo $a_langpackage->a_complaints_list;?></div>
        <hr />
	<div class="infobox">
	<h3><?php echo $a_langpackage->a_complaints_list;?></h3>
    <div class="content2">
		<form action="a.php?act=lock_shop" name="form1" id="form1" method="post">
		<table class="list_table">
		  <thead>
			<tr style="text-align:center;">
				<th width="2px"><input type="checkbox" onclick="checkall(this,'type_id[]');" value='' /></th>
				<th width="60px"><?php echo $a_langpackage->a_complainant; ?></th>
				<th width="110px" align="left"><?php echo $a_langpackage->a_by_complainant; ?></th>
				<th width="150px" align="left"><?php echo $a_langpackage->a_related_products; ?></th>
				<th width="100px" align="left"><?php echo $a_langpackage->a_of_complaint; ?></th>
				<th width="200px" align="left"><?php echo $a_langpackage->a_complaints; ?></th>
				<th width="150px" align="left"><?php echo $a_langpackage->a_operate;?></th>
			</tr>
			</thead>
			<tbody>
			<?php if($result['result'] ) {
			foreach($result['result']  as $value) { ?>
			<tr style="text-align:center;">
				<td><input type="checkbox" name="type_id[]" value="<?php echo $value['complaints_id'];?>" /></td>
				<td><?php echo $value['user_name'];?></td>
				<td align="left"><a href="../shop.php?shopid=<?php echo  $value['usered_id'];?>&app=index" target="_blank"><?php echo $value['usered_name'];?></a></td>
				<td align="left"><a href="../goods.php?id=<?php echo $value['goods_id'];?>" target="_blank"><?php echo $value['goods_name'];?></a></td>
				<td align="left"><?php echo $value['complaints_title'];?></td>
				<td align="left"><?php echo $value['complaints_content'];?></td>
				<td align="left">
				 	<?php if($value['locked']==0){?>
					<a href="a.php?act=member_locked_user&id=<?php echo $value['usered_id'];?>" onclick="return confirm('<?php echo $a_langpackage->a_sure_member_lock; ?>');">
						<?php   echo $a_langpackage->a_locked_informers; ?>
					</a>
					<?php } else { ?>
					<font color="red"><?php echo $a_langpackage->a_lock_to_be_informers; ?></font>
					<?php } ?>
					<br />
					 <?php if($value['lock_flg']==0){?>
					<a href="a.php?act=lock_goods_user&id=<?php echo $value['goods_id']; ?>&v=1" onclick="return confirm('<?php echo $a_langpackage->a_operate_message;?>')">
						<?php  echo $a_langpackage->a_locked_reported_goods; ?>
					</a>
					<?php } else { ?>
					<font color="red"><?php echo $a_langpackage->a_lock_was_reported_goods; ?></font>
					<?php } ?>
				| <a href="a.php?act=complaint_del&id=<?php echo $value['complaints_id'];?>"><?php echo $a_langpackage->a_dele;?></a></td>
			</tr>
			<?php }?>
			<tr>
				<td colspan="13" class="center"><?php include("m/page.php"); ?></td>
			</tr>
			<?php } else { ?>
			<tr>
				<td colspan="9"><?php echo $a_langpackage->a_no_list;?></td>
			</tr>
			<?php } ?>
			</tbody>
		</table>
		</form>
	  </div>
	 </div>
   </div>
 </div>
</body>
</html>