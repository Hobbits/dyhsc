<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/shop/credit_add.html
 * 如果您的模型要进行修改，请修改 models/modules/shop/credit_add.php
 *
 * 修改完成之后需要您进入后台重新编译，才会重新生成。
 * 如果您开启了debug模式运行，那么您可以省去上面这一步，但是debug模式每次都会判断程序是否更新，debug模式只适合开发调试。
 * 如果您正式运行此程序时，请切换到service模式运行！
 *
 * 如您有问题请到官方论坛（http://tech.jooyea.com/bbs/）提问，谢谢您的支持。
 */
?><?php
/*
 * 此段代码由debug模式下生成运行，请勿改动！
 * 如果debug模式下出错不能再次自动编译时，请进入后台手动编译！
 */
/* debug模式运行生成代码 开始 */
if(!function_exists("tpl_engine")) {
	require("foundation/ftpl_compile.php");
}
if(filemtime("templates/default/modules/shop/credit_add.html") > filemtime(__file__) || (file_exists("models/modules/shop/credit_add.php") && filemtime("models/modules/shop/credit_add.php") > filemtime(__file__)) ) {
	tpl_engine("default","modules/shop/credit_add.html",1);
	include(__file__);
} else {
/* debug模式运行生成代码 结束 */
?><?php
if(!$IWEB_SHOP_IN) {
	trigger_error('Hacking attempt');
}
require("foundation/module_goods.php");
//引入语言包
$m_langpackage=new moduleslp;
$i_langpackage=new indexlp;
$s_langpackage=new shoplp;

//数据表定义区
$t_order_goods = $tablePreStr."order_goods";
$t_order_info = $tablePreStr."order_info";
$t_users = $tablePreStr."users";
$t_goods = $tablePreStr."goods";
$oid=intval(get_args('id'));
$t=short_check(get_args('t'));

//读写分离定义方法
$dbo = new dbex;
dbtarget('r',$dbServs);
//$user_id = get_sess_user_id();
//判断商品是否锁定，锁定则不许操作
$sql="select b.goods_id,a.transport_type from $t_order_info as a join $t_order_goods as b on a.order_id=b.order_id where a.order_id=$oid";
$row1=$dbo->getRow($sql);
if($row1){
	$goods_id=$row1['goods_id'];
}
include("foundation/fgoods_locked.php");
//判断用户是否锁定，锁定则不许操作
$sql ="select locked from $t_users where user_id=$user_id";
$row = $dbo->getRow($sql);
if($row['locked']==1){
	session_destroy();
	trigger_error($m_langpackage->m_user_locked);//非法操作
}

$credit=array(
		"1"=>$m_langpackage->m_credit_goods,
		"0"=>$m_langpackage->m_credit_middle,
		"-1"=>$m_langpackage->m_credit_bad,
	);
if($t=='buyer'){
	$sql="select order_status,buyer_reply from $t_order_info where order_id=$oid and user_id=$user_id";
	$row=$dbo->getRow($sql);
	if(!$row){
		trigger_error('您没有购买该商品，您不能评价！');
	}else{
		if($row['order_status']!=3){
			trigger_error('您还没有完成购买，您不能评价！');
		}
		if($row['buyer_reply']==1){
			trigger_error('您已评价过，您不能重复评价！');
		}
	}
}

	$sql="select c.goods_name,c.goods_id,b.user_name,b.user_id from $t_order_info as a,$t_users as b,$t_order_goods as c where a.order_id=$oid and b.user_id=a.user_id and a.order_id=c.order_id";

$result = $dbo->getRow($sql);

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo  $m_langpackage->m_u_center;?></title>

<link rel="stylesheet" type="text/css" href="skin/<?php echo  $SYSINFO['templates'];?>/css/modules.css">
<link rel="stylesheet" type="text/css" href="skin/<?php echo  $SYSINFO['templates'];?>/css/layout.css">
<link rel="stylesheet" type="text/css" href="skin/<?php echo  $SYSINFO['templates'];?>/css/style.css">
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/changeStyle.js"></script>
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/userchangeStyle.js"></script>
<style type="text/css">
th { background:#EFEFEF }
.edit span { background:#efefef; }
.search { margin:5px; }
.search input { color:#444; }
td.img img { cursor:pointer }
</style>
</head>

<body onload="changeMenu();">
<?php  require("shop/index_header.php");?>
	<div class="site_map">
	  <?php echo $m_langpackage->m_current_position;?><A href="index.php"><?php echo $SYSINFO['sys_name'];?></A>/<a href="modules.php"><?php echo $m_langpackage->m_u_center;?></a>/&nbsp;&nbsp;<?php echo $m_langpackage->m_recver_order;?>
	</div>
    <div class="clear"></div>
  	<?php  require("modules/left_menu.php");?>

     <div class="main_right">
     <div class="right_top"></div>
     <div class="cont">

		<div class="bigapart">
			<div class="title_uc"><h3><?php echo  $m_langpackage->m_evaluate;?></h3></div>
   <hr />
			<form action="do.php?act=shop_credit_add&id=<?php echo $oid;?>&t=<?php echo $t;?>" name="form1" method="post" onsubmit="return check();">
				<table width="98%" class="form_table_02">
					<tr class="center">
						<th class="hor"><?php echo  $m_langpackage->m_appraiser;?></th>
						<td class="textleft"><?php echo  $result['user_name'];?></td>
					</tr>
					<tr class="center">
						<th class="hor"><?php echo  $m_langpackage->m_goods_info;?></th>
						<td class=" textleft"><a href="goods.php?id=<?php echo $result['goods_id'];?>" target="_blank" style="color:#0044DD;"><?php echo  $result['goods_name'];?></a></td>
					</tr>

				</table>
    <table width="100%" cellpadding="0" cellspacing="0">
    	<tbody>
      <tr>
      	<th width="150px" class="textleft"><?php echo  $m_langpackage->m_my_appraise;?></th>
       <th></th>
      </tr>
      <tr>
        <td width="150px"><?php echo  $m_langpackage->m_appraise_grade;?></td>
        <td><?php foreach($credit as $key=>$val){?>
							&nbsp;&nbsp;&nbsp;<input type="radio" name="grade" value="<?php echo $key;?>"><?php echo $val;?>
							<?php }?></td>
      </tr>
      <tr>
        <td><?php echo  $m_langpackage->m_evaluate_con;?></td>
        <td><textarea rows="4" cols="50" name="content" id="content" onkeyup="this.value=this.value.slice(0,300);"></textarea></td>
      </tr>
      <tr>
        <td></td>
        <td><input type="submit" value="<?php echo  $m_langpackage->m_send;?>"/></td>
      </tr>
     </tbody>
    </table>
			</form></div></div>
  </div>
</div>
<div class="clear"></div>
<?php  require("shop/index_footer.php");?>
<script language="JavaScript">
function Trim(center) {
	return center.replace(/\s+$|^\s+/g,"");
}
function check(){
	var sex_obj = document.getElementsByName('grade');
	var temp_sex = false;
	for(var i = 0; i < sex_obj.length; i ++){
		if(sex_obj[i].checked){
			var sex = sex_obj[i].value;
			temp_sex = true;
			break;
		}
	}
	if(temp_sex == false){
		alert("<?php echo  $m_langpackage->m_appraise_grade_sell;?>");
		return false;
	}
	var center = Trim(document.form1.content.value);
	if(center == ""){
		alert("<?php echo  $m_langpackage->m_commentate_null;?>");
		document.form1.content.value = center;
		return false;
	}
	var textareac = document.getElementById("textareac");
	if(textareac.value.length>300){
		alert("<?php echo $s_langpackage->s_work_count_error;?>");
		textareac.focus();
		return false;
	}
	return false;
}
</script>
</body>
</html><?php } ?>