<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

//引入语言包
$a_langpackage=new adminlp;
//权限管理
$right=check_rights("protect_rights_info");
if(!$right){
	header('location:m.php?app=error');
}
$order_id = intval(get_args('id'));
if(!$order_id) { trigger_error($a_langpackage->a_error); }

//定义读操作
dbtarget('r',$dbServs);
$dbo = new dbex;

//数据表定义区
$t_protect_rights = $tablePreStr."protect_rights";
$t_shop_info = $tablePreStr."shop_info";
$t_users = $tablePreStr."users";

$sql = "select *from `$t_protect_rights` where order_id = $order_id order by protect_date desc";
$result = $dbo->getRs($sql);

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
.right{font-weight:bold;}
</style>
</head>
<body>
<div id="maincontent">
	<div class="wrap">
	<div class="crumbs"><?php echo $a_langpackage->a_location; ?> &gt;&gt; <?php echo $a_langpackage->a_protect_rights;?>&gt;&gt; 维权查看</div>
        <hr />
	<div class="infobox">
	<h3><span class="left">维权查看</span><span class="right" style="margin-right:15px;"><a href="m.php?app=protect_rights" style="float: right;">返回维权列表</a></span></h3>
    <div class="content2">
	
			<table class="list_table">
			<?php if($result) {
					foreach($result as $v) { ?>
				<thead>
				<tr>
					<th colspan="4">&nbsp;&nbsp;
					<?php if($v['user_type']==0) {
								echo "客户";
							} else {
								echo "商家";
							}
							echo "于{$v['protect_date']}";
							if($v['status']==1)
								echo "<font color='red'>同意客户的维权</font>并且";
							echo "说：";
					?>
					</th>
				</tr>
				</thead>
				<tbody>
					<tr style="text-align:center;">
						<td align="left" width="270px">&nbsp;&nbsp;<?php echo str_replace("<img src=\"","<img src=\"../",$v['content']);?></td>
					</tr>
				</tbody>
				<?php }} ?>
			</table>
		
		</div>
	  </div>
	</div>
</div>
</body>
</html>