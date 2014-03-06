<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
require_once("../foundation/module_users.php");

//引入语言包
$a_langpackage=new adminlp;

//获取form提交的数据
$name = short_check(get_args('name'));
$email = short_check(get_args('email'));
$start_time = get_args('start_time');
$end_time = get_args('end_time');
$user_status = get_args('user_status');
$user_rank_id = get_args('user_rank_id');

//数据表定义区
$t_users = $tablePreStr."users";
$t_user_rank = $tablePreStr."user_rank";
$t_shop_info = $tablePreStr."shop_info";

//读写分离定义方法
$dbo = new dbex;
dbtarget('r',$dbServs);

$sql = "select c.shop_name,u.* from $t_users as u left join $t_shop_info as c on u.user_id=c.user_id   where 1";
//判断/添加用户名查询条件
if($name) {
	//权限管理
	$right=check_rights("user_search");
	if(!$right){
		header('Location: m.php?app=error');
	}else{
		$sql .= " and u.user_name like '%$name%' ";
	}
}
//判断/添加email查询条件
if($email) {
	//权限管理
	$right=check_rights("user_search");
	if(!$right){
		header('Location: m.php?app=error');
	}else{
		$sql .= " and u.user_email like '%$email%' ";
	}
}
//判断/添加注册时间大于等于开始时间查询条件
if($start_time) {
	//权限管理
	$right=check_rights("user_search");
	if(!$right){
		header('Location: m.php?app=error');
	}else{
		$sql .= " and u.reg_time >= '$start_time' ";
	}
}
//判断/添加注册时间小于等于结束时间查询条件
if($end_time) {
	//权限管理
	$right=check_rights("user_search");
	if(!$right){
		header('Location: m.php?app=error');
	}else{
		$sql .= " and u.reg_time  <= '$end_time' ";
	}
}
//判断/添加等级查询条件
if($user_rank_id) {
	//权限管理
	$right=check_rights("user_search");
	if(!$right){
		header('Location: m.php?app=error');
	}else{
		$sql .= " and u.rank_id = $user_rank_id ";
	}
}
//判断/添加锁定状态查询条件
if($user_status!="" && $user_status!=2) {
	//权限管理
	$right=check_rights("user_search");
	if(!$right){
		header('Location: m.php?app=error');
	}else{
		$sql .= " and u.locked = $user_status ";
	}
}

$sql .= " order by u.user_id desc";

$result = $dbo->fetch_page($sql,13);
//print_r($result['result']);
$userrank ="";
$userrank = get_userrank_list($dbo,$t_user_rank);

$right_array=array(
	"user_search"    =>   "0",
    "user_update"    =>   "0",
    "user_lock"    =>   "0",
    "user_unlock"    =>   "0",
);
foreach($right_array as $key => $value){
	$right_array[$key]=check_rights($key);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link rel="stylesheet" type="text/css" href="skin/css/admin.css">
<link rel="stylesheet" type="text/css" href="skin/css/main.css">
<script type='text/javascript' src="skin/js/jy.js"></script>
<script type='text/javascript' src='../servtools/date/WdatePicker.js'></script>
<style>
td span { color:red; }
.green { color:green; }
.red { color:red; }
</style>
</head>
<body>
<div id="maincontent">
	<?php  include("messagebox.php");?>
	<div class="wrap">
		<div class="crumbs"><?php echo $a_langpackage->a_location; ?> &gt;&gt; <?php echo $a_langpackage->a_m_shop_mengament;?> &gt;&gt; <?php echo $a_langpackage->a_no_create_list; ?></div>
		<hr />
		<div class="seachbox">
			<div class="content2">
				<form action="m.php?app=member_list" name="searchForm" method="get">
					<table class="form-table">
						<tbody>
							<tr>
								<td width="2px" style="padding:0 0 0 5px"><span style="margin:1px 0px 0px 0px; float:left; color: #000" > <img src="skin/images/icon_search.gif" border="0" alt="SEARCH" /> </span></td>
								<td ><?php echo $a_langpackage->a_memeber_name; ?>： <input type="text" class="small-text" name="name" value="<?php echo $name; ?>" style="width:100px" /> <?php echo $a_langpackage->a_memeber_email; ?>：<input type="text" class="small-text" name="email" value="<?php echo $email; ?>" style="width:100px" /> &nbsp;&nbsp;会员状态：
									<select name='user_status'>
										<option value ="2">全部</option>
										<option value ="0" <?php if($user_status=='0') echo "selected"?>>正常</option>
										<option value ="1" <?php if($user_status=='1') echo "selected"?>>锁定</option>
									</select>
									会员类型：
									<select name='user_rank_id'>
										<option value ="0">选择分类</option>
										<?php
							foreach($userrank as $value) {?>
										<option value ="<?php echo $value['rank_id'];?>" <?php if($user_rank_id==$value['rank_id']) echo "selected"?>><?php echo $value['rank_name'];?></option>
										<?php } ?>
									</select>
								</td>
							</tr>
							<tr>
								<td></td>
								<td > 创建时间： <input class="Wdate" type="text" name="start_time" id="start_time" onFocus="WdatePicker({isShowClear:false,readOnly:true})" value="<?php echo $start_time;?>" /><?php echo $a_langpackage->a_to;?> <input class="Wdate" type="text" name="end_time" id="end_time" onFocus="WdatePicker({isShowClear:false,readOnly:true})"  value="<?php echo $end_time;?>"/> 
			
									&nbsp;&nbsp;<input type="hidden" name="app" value="member_list" /> <input type="submit" class="regular-button" value="<?php echo $a_langpackage->a_serach; ?>" /></td>
							</tr>
						</tbody>
					</table>
				</form>
			</div>
		</div>
		<div class="infobox">
			<h3><?php echo $a_langpackage->a_no_create_list; ?></h3>
			<div class="content2">
				<form action="m.php?app=member_list" id="form1" method="get">
					<table class="list_table">
						<thead>
							<tr style="text-align:center;">
								<th width="160px" align="left"><?php echo $a_langpackage->a_memeber_name; ?>/<?php echo $a_langpackage->a_memeber_email; ?></th>
								<th width="275px"><?php echo $a_langpackage->a_register_time; ?> / <?php echo $a_langpackage->a_last_login_time; ?></th>
								<th width="276px"><?php echo $a_langpackage->a_email_check; ?>/<?php echo $a_langpackage->a_user_rank; ?></th>
								<th><?php echo $a_langpackage->a_shop; ?></th>
							</tr>
						</thead>
						<tbody>
							<?php if($result['result']) {
			foreach($result['result'] as $value) { ?>
							<tr style=" text-align:center;">
								<td align="left"><?php echo $value['user_name'];?><br />
									<?php echo $value['user_email'];?></td>
								<td><?php echo $value['reg_time'];?><br />
									<?php echo $value['last_login_time'];?></td>
								<?php if($value['email_check']){?>
								<td class="green center"><?php echo $a_langpackage->a_verify; ?><br />
									<?php echo $userrank[$value['rank_id']]['rank_name'];?></td>
								<?php }else{?>
								<td class="red center"><?php echo $a_langpackage->a_unverify; ?><br />
									<?php echo $userrank[$value['rank_id']]['rank_name'];?></td>
								<?php }?>
								<td class="center"><?php if($value['shop_name']) {?>
									<span style='color:red;'><?php echo $value['shop_name'];?></span>
									<?php }else { ?>
									<span style='color:green;'><a href="m.php?app=shop_add&id=<?php echo $value['user_id'];?>"><?php echo $a_langpackage->a_shop_add;?></a></span>
									<?php } ?></td>
							</tr>
							<?php }?>
							<?php } else { ?>
							<tr>
								<td colspan="10"></td>
							</tr>
							<?php } ?>
							<tr>
								<td colspan="10" class="center"><?php include("m/page.php"); ?></td>
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