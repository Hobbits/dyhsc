<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
require("../foundation/module_areas.php");

//引入语言包
$a_langpackage=new adminlp;

//数据表定义区
$t_shop_request = $tablePreStr."shop_request";
$t_shop_info = $tablePreStr."shop_info";
$t_areas = $tablePreStr."areas";

$request_id = intval(get_args('id'));

if($request_id) {
	//权限管理
	$right=check_rights("company_search");
	if(!$right){
		header('location:m.php?app=error');
	}
}
//读操作
$dbo = new dbex;
dbtarget('r',$dbServs);

$sql = "select * from `$t_shop_request` r join `$t_shop_info` s on r.user_id=s.user_id where r.request_id = $request_id";
$result = $dbo->getRow($sql);
$resultArea=get_areas_kv($dbo,$t_areas);
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
</style>
</head>
<body>
<div id="maincontent">
	<div class="wrap">
	<div class="crumbs"><?php echo $a_langpackage->a_location; ?> &gt;&gt; <?php echo $a_langpackage->a_m_member_oprate;?> &gt;&gt; <?php echo $a_langpackage->a_m_check_commember;?> &gt;&gt; <?php echo $a_langpackage->a_corporate_info; ?></div>
    <hr />
	<div class="infobox">
	<h3><span class="left"><?php echo $a_langpackage->a_corporate_info; ?></span><span class="right" style="margin-right:15px;"><a href="m.php?app=shop_request"><?php echo $a_langpackage->a_m_check_commember;?></a></span></h3>
    <div class="content2">
		<form action="a.php?act=shop_request" name="form1" method="post">
		<table class="list_table">
		  <tbody>
			<tr>
				<td width="84px"><?php echo $a_langpackage->a_company_name;?>：</td>
				<td><?php echo $result['company_name'];?></td>
			</tr>
			<tr>
				<td><?php echo $a_langpackage->a_company_owner_name;?>：</td>
				<td><?php echo $result['person_name'];?></td>
			</tr>
			<tr>
				<td><?php echo $a_langpackage->a_certificate_kind;?>：</td>
				<td><?php echo $result['credit_type'];?></td>
			</tr>
			<tr>
				<td><?php echo $a_langpackage->a_certificate_code;?>：</td>
				<td><?php echo $result['credit_num'];?></td>
			</tr>
			<tr>
				<td><?php echo $a_langpackage->a_trading_license;?>：</td>
				<td><img src="../<?php echo $result['credit_commercial'];?>" height="125px" width="230px" onerror="this.src='../skin/default/images/nopic.gif'"/></td>
			</tr>
			<tr>
				<td><?php echo $a_langpackage->a_company_zip;?>：</td>
				<td><?php echo $result['zipcode'];?></td>
			</tr>
			<tr>
				<td><?php echo $a_langpackage->a_company_mobile;?>：</td>
				<td><?php echo $result['mobile'];?></td>
			</tr>
			<tr>
				<td><?php echo $a_langpackage->a_company_tel;?>：</td>
				<td><?php echo $result['telphone'];?></td>
			</tr>
			<tr>
				<td><?php echo $a_langpackage->a_company_time;?>：</td>
				<td><?php echo $result['add_time'];?></td>
			</tr>
			<tr>
				<td><?php echo $a_langpackage->a_company_area;?>：</td>
				<td><?php echo $result['company_area'];?></td>
			</tr>
			<tr>
				<td><?php echo $a_langpackage->a_company_add;?>：</td>
				<td><?php echo $result['company_address'];?></td>
			</tr>
			<tr>
				<td><?php echo $a_langpackage->a_status;?>：</td>
				<td>
					<?php if($result['status']==1) {echo "<span class='green'>".$a_langpackage->a_audit_successed."</span>";}
					elseif($result['status']==2) {echo "<span class='red'>".$a_langpackage->a_audit_fail."</span>";}
					else {echo $a_langpackage->a_audit_wait;} ?>
				</td>
			</tr>
		</tbody>
		</table>
		</form>
	   </div>
	  </div>
	  
	  	<div class="infobox">
	<h3><span class="left">店铺信息</span></h3>
    <div class="content2">
		<form action="a.php?act=shop_request" name="form1" method="post">
		<table class="list_table">
		  <tbody>
			<tr>
				<td width="84px">店铺名称：</td>
				<td><?php echo $result['shop_name'];?></td>
			</tr>
			<tr>
				<td>所在地区：</td>
				<td><?php echo $resultArea[$result['shop_country']];?>&nbsp;
					<?php echo $resultArea[$result['shop_province']];?>&nbsp;
					<?php echo $resultArea[$result['shop_city']];?>&nbsp;
					<?php echo $resultArea[$result['shop_district']];?>&nbsp;</td>
			</tr>
			<tr>
				<td>经营范围：</td>
				<td><?php echo $result['shop_management'];?></td>
			</tr>
			<tr>
				<td>详细地址：</td>
				<td><?php echo $result['shop_address'];?></td>
			</tr>
			<tr>
				<td>店铺简介：</td>
				<td><?php echo $result['shop_intro'];?></td>
			</tr>
		</tbody>
		</table>
	
		</form>
	   </div>
	  </div>
	  <?php if($result['status']==0){ ?>
	  	<input type="button" name="" class="regular-button"  onclick="auditing(1,<?php echo $result['request_id'];?>)" value="审核通过" />
		<input type="button" name="" class="regular-button"  onclick="auditing(2,<?php echo $result['request_id'];?>)" value="审核不通过" />
		<?php } ?>
	</div>
</div>
</body>
<script language='javascript'>
function auditing(v,id){
    window.location.href="a.php?act=shop_request&s="+v+"&id="+id;
}


</script>
</html>