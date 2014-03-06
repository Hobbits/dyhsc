<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/shop/shipping_export.html
 * 如果您的模型要进行修改，请修改 models/modules/shop/shipping_export.php
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
if(filemtime("templates/default/modules/shop/shipping_export.html") > filemtime(__file__) || (file_exists("models/modules/shop/shipping_export.php") && filemtime("models/modules/shop/shipping_export.php") > filemtime(__file__)) ) {
	tpl_engine("default","modules/shop/shipping_export.html",1);
	include(__file__);
} else {
/* debug模式运行生成代码 结束 */
?><?php

	/*
		-----------------------------------------
		文件：shipping_export.php。
		功能: 商铺发货单导出。
		日期：2010-11-11
		-----------------------------------------
	*/

	if(!$IWEB_SHOP_IN) {
		trigger_error('Hacking attempt');
	}
	
	//文件引入
	include_once("foundation/asystem_info.php");

	//引入语言包
	$m_langpackage=new moduleslp;
	$i_langpackage=new indexlp;

	//取得当前商铺的信息
	$shop_id = get_sess_shop_id();

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="application/vnd.ms-excel; charset=utf-8">
<title><?php echo  $m_langpackage->m_u_center;?></title>
<link rel="stylesheet" type="text/css" href="skin/<?php echo  $SYSINFO['templates'];?>/css/style.css">
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/changeStyle.js"></script>
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/userchangeStyle.js"></script>
</head>
<body onload="menu_style_change('shop_shipping_list');changeMenu();">
	<?php  require("shop/index_header.php");?>
	<div class="site_map">
	  <?php echo $m_langpackage->m_current_position;?><A href="index.php"><?php echo $SYSINFO['sys_name'];?></A>/<a href="modules.php"><?php echo $m_langpackage->m_u_center;?></a>/&nbsp;&nbsp;发货单导出
	</div>
    <div class="clear"></div>
    <div class="apart">
    	<?php  require("modules/left_menu.php");?>
        <div class="main_right">
        	<div class="right_top"></div>
            <div class="cont">
                <div class="cont_title">发货单导出</div>
                <hr />
			<form action="do.php?act=shop_shipping_export" method="post" id="cvsform" name='cvsform' onsubmit="return checkform(this)">
				<input type="hidden" name="shop_id" value="<?php echo $shop_id;?>" />
					<table width="100%" style="border:0" cellspacing="0">
						<tr>
							<td width="120" align="right"><?php echo $m_langpackage->m_csv_name;?>:</td><td width="180"><input type="text" name="filename" value="" /></td><td><?php echo $m_langpackage->m_no_csv_name;?></td>
						</tr>
						<tr>
							<td align="right"><?php echo $m_langpackage->m_export_code;?>:</td>
							<td align="left" colspan="2">
									<select name="chast" id="chast" onchange="check();">
									<option value="gbk" selected>GBK</option>
									<option value="gb2312">GB2312</option>
									<option value="utf-8">UTF-8</option>
								</select>
							</td>
						</tr>
						<tr><td></td>
							<td colspan="2">
								<input class="submit" type="submit" name="submit" value="发货单导出" />
							</td>
						</tr>
					</table>
			</form>
			</div>
		</div>
    <div class="clear"></div>
    <?php  require("shop/index_footer.php");?>
</body>
</html>
<script language="JavaScript" type="text/javascript">
	function checkform(obj){
		if(obj.filename.value.length<1){
			alert("<?php echo $m_langpackage->m_no_csv_name;?>");
			return false;
		}
	}
	function check(){
		var asd=document.getElementById('chast').value;
		if(asd=="utf-8"){
			alert("选择该编码，打开文件会出现乱码，建议选择GBK编码");
			}
		}
</script><?php } ?>