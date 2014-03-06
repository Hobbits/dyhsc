<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/shop/notice.html
 * 如果您的模型要进行修改，请修改 models/modules/shop/notice.php
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
if(filemtime("templates/default/modules/shop/notice.html") > filemtime(__file__) || (file_exists("models/modules/shop/notice.php") && filemtime("models/modules/shop/notice.php") > filemtime(__file__)) ) {
	tpl_engine("default","modules/shop/notice.html",1);
	include(__file__);
} else {
/* debug模式运行生成代码 结束 */
?><?php
if(!$IWEB_SHOP_IN) {
	trigger_error('Hacking attempt');
}

require("foundation/acheck_shop_creat.php");

require("foundation/module_shop.php");
//引入语言包
$m_langpackage=new moduleslp;
$i_langpackage=new indexlp;
$s_langpackage=new shoplp;
//数据表定义区
$t_shop_info = $tablePreStr."shop_info";
$t_users = $tablePreStr."users";
//读写分离定义方法
$dbo=new dbex;
dbtarget('r',$dbServs);
/* 商铺信息处理 */
include("foundation/fshop_locked.php");
//判断用户是否锁定，锁定则不许操作
$sql ="select locked from $t_users where user_id=$user_id";
$row = $dbo->getRow($sql);
if($row['locked']==1){
	session_destroy();
	trigger_error($m_langpackage->m_user_locked);//非法操作
}
$shop_info = get_shop_info($dbo,$t_shop_info,$shop_id);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo  $m_langpackage->m_u_center;?></title>
<link rel="stylesheet" type="text/css" href="skin/<?php echo  $SYSINFO['templates'];?>/css/modules.css">
<link rel="stylesheet" type="text/css" href="skin/<?php echo  $SYSINFO['templates'];?>/css/layout.css">
<link rel="stylesheet" type="text/css" href="skin/<?php echo  $SYSINFO['templates'];?>/css/style.css">
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/userchangeStyle.js"></script>
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/changeStyle.js"></script>

<style type="text/css">
.red{color:red;}
</style>
<script type="text/javascript" src="servtools/nicedit/nicEdit.js"></script>
<script type="text/javascript" src="servtools/jquery-1.3.2.min.js?v=1.3.2"></script>
<script type="text/javascript" src="servtools/xheditor/xheditor.min.js?v=1.0.0-final"></script>

<script type="text/javascript">
var introeditor;
$(function(){
	introeditor=$("#shopnotice").xheditor({skin:'vista',tools:"Cut,Copy,Paste,Pastetext,Separator,Blocktag,Fontface,FontSize,Bold,Italic,Underline,Strikethrough,FontColor,BackColor,SelectAll,Removeformat,Separator,Align,List,Outdent,Indent,Separator,Link,Unlink,Img,Table,Separator,Fullscreen,About"});

});
</script>
</head>
<body onload="menu_style_change('shop_notice');changeMenu();">
<?php  require("shop/index_header.php");?>
	<div class="site_map">
	  <?php echo $m_langpackage->m_current_position;?><A href="index.php"><?php echo $SYSINFO['sys_name'];?></A>/<a href="modules.php"><?php echo $m_langpackage->m_u_center;?></a>/&nbsp;&nbsp;<?php echo  $m_langpackage->m_shop_notice;?>
	</div>
    <div class="clear"></div>
    <?php  require("modules/left_menu.php");?>
        <div class="main_right">
        	<div class="right_top"></div>
            <div class="cont">
                <div class="cont_title"><?php echo  $m_langpackage->m_shop_notice;?></div>
                <hr />
				<form action="do.php?act=shop_notice" method="post" name="shop_notice_form" onsubmit="return checkForm();">
					<table width="100%" style="border:0">
						<tr>
							<td style="width:90px; text-align:center; vertical-align:top; font-weight:bold"><?php echo  $m_langpackage->m_shop_notice;?>:</td>
                        	<td>
								<textarea name="shop_notice" id="shopnotice" cols="65" rows="15"><?php echo  $shop_info['shop_notice'];?></textarea>
							</td>
                        </tr>
						<tr>
							<td></td>
							<td><input type="hidden" name="shop_id" value="<?php echo  $shop_id;?>" />
							<input class="submit" type="submit" name="submit" style="font-weight:normal" value="<?php echo  $m_langpackage->m_edit_shopnotice;?>" /></td>
						</tr>
					</table>
				</form>
			</div>
			<div class="clear"></div>
			<div class="right_bottom"></div>
			<div class="back_top"><a href="#"></a></div>
		</div>
<?php  require("shop/index_footer.php");?>
</body>
</html><?php } ?>