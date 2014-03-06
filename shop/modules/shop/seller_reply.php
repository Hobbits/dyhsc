<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/shop/seller_reply.html
 * 如果您的模型要进行修改，请修改 models/modules/shop/seller_reply.php
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
if(filemtime("templates/default/modules/shop/seller_reply.html") > filemtime(__file__) || (file_exists("models/modules/shop/seller_reply.php") && filemtime("models/modules/shop/seller_reply.php") > filemtime(__file__)) ) {
	tpl_engine("default","modules/shop/seller_reply.html",1);
	include(__file__);
} else {
/* debug模式运行生成代码 结束 */
?><?php
if(!$IWEB_SHOP_IN) {
	trigger_error('Hacking attempt');
}

require("foundation/acheck_shop_creat.php");

//引入语言包
$m_langpackage=new moduleslp;
$i_langpackage=new indexlp;

//数据表定义区
$t_shop_guestbook = $tablePreStr."shop_guestbook";

$gid=intval(get_args('id'));

//读写分离定义方法
$dbo = new dbex;
dbtarget('r',$dbServs);

$sql = "select * from `$t_shop_guestbook` where shop_id='$shop_id' and gid='$gid' and shop_del_status=1";

$sql .= " order by add_time desc";

//echo $sql;/
$result = $dbo->getRow($sql);
//print_r($result);
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
th{background:#EFEFEF}
.edit span{background:#efefef;}
.search {margin:5px;}
.search input {color:#444;}
td.img img{cursor:pointer}
</style>

</head>
<body onload="menu_style_change('shop_guestbook');changeMenu();">
<?php  require("shop/index_header.php");?>
	<div class="site_map">
	  <?php echo $m_langpackage->m_current_position;?><A href="index.php"><?php echo $SYSINFO['sys_name'];?></A>/<a href="modules.php"><?php echo $m_langpackage->m_u_center;?></a>/&nbsp;&nbsp;<?php echo  $m_langpackage->m_addseller_write_back;?>
	</div>
    <div class="clear"></div>
	<?php  require("modules/left_menu.php");?>
    <div class="main_right">
		<div class="right_top"></div>
            <div class="cont">
                <div class="cont_title"><?php echo  $m_langpackage->m_addseller_write_back;?></div>
                <hr />
			<form action="do.php?act=shop_reply_add&id=<?php echo $gid;?>" name="form1" method="post" onsubmit="return check();">
			<table width="100%" style="border:0" cellspacing="0">
				<tr class="center">
					<td class="textright" width="180px;"><?php echo  $m_langpackage->m_name;?>:</td>
					<td class="textleft"><?php echo  $result['name'];?></td>
				</tr>
				<tr class="center">
					<td class="textright"><?php echo  $m_langpackage->m_email;?>:</td>
					<td class="textleft"><?php echo  $result['email'];?></td>
				</tr>
				<tr class="center">
					<td class="textright"><?php echo  $m_langpackage->m_other_contact;?>:</td>
					<td class="textleft"><?php echo  $result['contact'];?></td>
				</tr>
				<tr class="center">
					<td class="textright"><?php echo  $m_langpackage->m_guestbook_content;?>:</td>
					<td class="textleft"><?php echo  $result['content'];?></td>
				</tr>
				<tr class="center">
					<td class="textright"><?php echo  $m_langpackage->m_my_write_back;?>:</td>
					<td class="textleft"><?php echo  $result['reply'];?></td>
				</tr>
				<tr class="center">
					<td class="textright"><?php echo  $m_langpackage->m_add_time;?>:</td>
					<td class="textleft"><?php echo  substr($result['add_time'],0,16);?></td>
				</tr>
				<?php if($result['reply']=="") {?>
				<tr>
					<th class="textleft" colspan="2">
						<?php echo  $m_langpackage->m_iwantto_write_back;?>
					</th>
				</tr>
				<tr>
					<td class="textright" valign="top"><?php echo  $m_langpackage->m_write_back_content;?></td>
					<td class="textleft">
						<textarea rows="4" cols="50" id="reply" name="reply" onkeyup="this.value=this.value.slice(0,300);"></textarea>
					</td>
				</tr>
				<tr><td></td>
					<td>
						<input class="submit" type="submit" value="<?php echo  $m_langpackage->m_post;?>"/>
					</td>
				</tr>
				<?php }?>
			</table>
			</form>
			</div>
		    <div class="clear"></div>
			<div class="right_bottom"></div>
			<div class="back_top"><a href="#"></a></div>
		</div>
<?php  require("shop/index_footer.php");?>
<script language="JavaScript">
function Trim(center) {
	return center.replace(/\s+$|^\s+/g,"");
}
function check(){
	var center = Trim(document.form1.reply.value);
	var textareac = document.getElementById("reply");
	if(center == ""){
		alert("<?php echo  $m_langpackage->m_post_notnull;?>");
		document.form1.reply.value = center;
		return false;
	}
	if(textareac.value.length>300){
		alert("<?php echo $m_langpackage->m_work_count_error;?>");
		textareac.focus();
		return false;
	}
}
</script>
</body>
</html><?php } ?>