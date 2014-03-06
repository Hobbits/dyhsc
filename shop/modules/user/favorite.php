<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/user/favorite.html
 * 如果您的模型要进行修改，请修改 models/modules/user/favorite.php
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
if(filemtime("templates/default/modules/user/favorite.html") > filemtime(__file__) || (file_exists("models/modules/user/favorite.php") && filemtime("models/modules/user/favorite.php") > filemtime(__file__)) ) {
	tpl_engine("default","modules/user/favorite.html",1);
	include(__file__);
} else {
/* debug模式运行生成代码 结束 */
?><?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
require('foundation/module_start.php');

//引入语言包
$m_langpackage=new moduleslp;
$i_langpackage=new indexlp;

//数据表定义区
$t_user_favorite = $tablePreStr."user_favorite";
$t_goods = $tablePreStr."goods";
$t_shop_info = $tablePreStr."shop_info";

//读写分离定义方法
$dbo = new dbex;
dbtarget('r',$dbServs);
$result = get_myfavorite_info($dbo,$t_user_favorite,$t_goods,$t_shop_info,$user_id,10);
$my_favorite = $result;
/* 店铺收藏 */
$result = get_shop_favorite($dbo,$t_user_favorite,$t_shop_info,$user_id,10);
$shop_favorite = $result;
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
.edit span{background:#efefef;}
.search {margin:5px;}
.search input {color:#444;}
td.img img{cursor:pointer}
</style>
<script>
var inputs = document.getElementsByTagName("input");
function submitform() {
	var checked = false;
	for(var i=0; i<inputs.length; i++) {
		if (inputs[i].checked == true) 
        {
            checked = true;
            if(confirm('<?php echo $m_langpackage->m_manage_sure_del;?>')){
            	break; 
                }else{
                	return false;
                	break; 
                    }
        }
	}
	if (!checked){ 
		alert("<?php echo $m_langpackage->m_selceted_one;?>");
		return false;
	}
	return true;
}
function checkall(obj) {
	if(obj.checked) {
		for(var i=0; i<inputs.length; i++) {
			if(inputs[i].type=='checkbox') {
				inputs[i].checked = true;
			}
		}
	} else {
		for(var i=0; i<inputs.length; i++) {
			if(inputs[i].type=='checkbox') {
				inputs[i].checked = false;
			}
		}
	}
}
function check_shop(obj){
	if(obj.checked) {
		for(var i=0; i<inputs.length; i++) {
			if(inputs[i].type=='checkbox') {
				inputs[i].checked = true;
			}
		}
	} else {
		for(var i=0; i<inputs.length; i++) {
			if(inputs[i].type=='checkbox') {
				inputs[i].checked = false;
			}
		}
	}
}
function submitform_shop() {
	var checked = false;
	for(var i=0; i<inputs.length; i++) {
		if (inputs[i].checked == true) 
        {
            checked = true;
            if(confirm('<?php echo $m_langpackage->m_manage_sure_del;?>')){
            	break; 
                }else{
                	return false;
                	break; 
                    }
        }
	}
	if (!checked){ 
		alert("<?php echo $m_langpackage->m_selceted_one;?>");
		return false;
	}
	return true;
}
</script>
</head>
<body onload="menu_style_change('user_favorite');changeMenu();">
<?php  require("shop/index_header.php");?>
	<div class="site_map">
	  <?php echo $m_langpackage->m_current_position;?><A href="index.php"><?php echo $SYSINFO['sys_name'];?></A>/<a href="modules.php"><?php echo $m_langpackage->m_u_center;?></a>/&nbsp;&nbsp;<?php echo $m_langpackage->m_my_favorite;?>
	</div>
    <div class="clear"></div>
	<?php  require("modules/left_menu.php");?>

	        <div class="main_right">
				<div class="right_top"></div>

				<div class="cont">
					<div class="cont_title">
						<?php echo $m_langpackage->m_my_favorite;?>
					</div>
				  <hr />
                  <div class="index_tab">
                	<ul>
                      <li><a id="style1" class="current" href="javascript:;" onclick="change_style('style1')"><?php echo $m_langpackage->m_goods_store;?></a></li>
                      <li><a id="style2" href="javascript:;" onclick="change_style('style2')"><?php echo $m_langpackage->m_shop_store;?></a></li>
                    </ul>
                  </div>
                  <div id="display_order" class="tab_box">
					<form action="do.php?act=user_favorite_del" name="form" method="post" onsubmit="return submitform();">
					<table width="98%" border="0" cellspacing="0">
					  <tr>
						<th width="20"><input type="checkbox" onclick="checkall(this);" /></th>
						<th width="90"><?php echo  $m_langpackage->m_goods_image;?></th>
						<th><?php echo  $m_langpackage->m_goods_info;?></th>
						<th width="60"><?php echo  $m_langpackage->m_manage;?></th>
					  </tr>
					  <?php 
						if(!empty($my_favorite['result'])) {
							foreach($my_favorite['result'] as $v) {?>
						<tr class="trcolor">
							<td><input type="checkbox" name="favorite[]" value="<?php echo  $v['favorite_id'];?>" /></td>
							<td align="center"><a href="<?php echo  goods_url($v['goods_id']);?>" target="_blank"><img src="<?php echo  $v['goods_thumb'];?>" width="80" height="80" onerror="this.src='skin/default/images/nopic.gif'"></a></td>
							<td class="name"><a href="<?php echo  goods_url($v['goods_id']);?>" target="_blank"><?php echo  $v['goods_name'];?></a>
							<br /> <?php echo  $m_langpackage->m_order_shops;?>：<a href="<?php echo shop_url($v['shop_id']);?>" target="_blank"><?php echo  $v['shop_name'];?></a> &nbsp;&nbsp; <?php echo  $m_langpackage->m_price;?>：￥<span style="color:#FF6600; font-weight:bold;"><?php echo  $v['goods_price'];?></span><?php echo  $m_langpackage->m_yuan;?>
							<br /> <?php echo  $m_langpackage->m_collect_num;?>：<span><?php echo  $v['favpv'];?></span> &nbsp;&nbsp; <?php echo  $m_langpackage->m_add_time;?>：<?php echo  substr($v['add_time'],0,16);?> &nbsp;&nbsp; <script src="imshow.php?u=<?php echo  $v['user_id'];?>"></script>
							</td>
							<td align="center">
							
							<?php if($v['lock_flg']=='1') { ;?>
								<font color='red'><?php echo  $m_langpackage->m_other_shop_lock;?></font>
							<?php } elseif($v['open_flg']=='1') { ;?>
								<font color='red'><?php echo  $m_langpackage->m_other_shop_close;?></font>
							<?php } else {?>
								<a href="modules.php?app=user_order_adress&gid=<?php echo  $v['goods_id'];?>&v=1"><?php echo  $m_langpackage->m_ccbuy;?></a>
							<?php }?><br />
							<a href="do.php?act=user_favorite_del&id=<?php echo  $v['favorite_id'];?>" onclick="return confirm('<?php echo  $m_langpackage->m_suredel_favorite;?>');"><?php echo  $m_langpackage->m_del;?></a>
							</td>
						</tr>
						<?php }?>
						<tr><td colspan="4" class="textleft"><INPUT class="submit" type="submit" value="<?php echo $m_langpackage->m_pl_del;?>" name="deletesubmit" /> </td></tr>
						<tr><td colspan="4" ><div class="page"><?php  require("modules/page.php");?></div></td></tr>
						<?php  } else {?>
						<tr><td colspan="4" class="center"><?php echo  $m_langpackage->m_nolist_record;?></td></tr>
						<?php }?>
					</table>
					</form>
				  </div>
                  <div id="display_favorite" class="tab_box" style="display:none;">
					<form action="do.php?act=user_shopfavorite_del" name="form_shop" method="post" onsubmit="return submitform_shop();">
                  	<table width="98%" border="0" cellspacing="0">
					  <tr>
						<th width="20"><input type="checkbox" onclick="check_shop(this);" /></th>
						<th width="90"><?php echo $m_langpackage->m_shop_logo;?></th>
						<th><?php echo $m_langpackage->m_shop_infomation;?></th>
						<th width="60"><?php echo  $m_langpackage->m_manage;?></th>
					  </tr>
					  <?php 
						if(!empty($shop_favorite['result'])) {
							foreach($shop_favorite['result'] as $v) {?>
						<tr class="trcolor">
							<td><input type="checkbox" name="favorite_shop[]" value="<?php echo  $v['favorite_id'];?>" /></td>
							<td align="center">
								<?php  if($v['shop_logo']){?>
									<a href="<?php echo  shop_url($v['shop_id']);?>" target="_blank">
										<img src="<?php echo  $v['shop_logo'];?>" width="80" height="80" onerror="this.src='skin/default/images/nopic.gif'">
									</a>
								<?php  } else{?>
									<a href="<?php echo  shop_url($v['shop_id']);?>" target="_blank">
										<img src="skin/default/images/shop_nologo.gif" width="80" height="80" >
									</a>
								<?php }?>
							</td>

							<td class="name">
								<a href="<?php echo  shop_url($v['shop_id']);?>" target="_blank"><?php echo  $v['shop_name'];?></a>
								<br /><?php echo $m_langpackage->m_shop_intro;?>：&nbsp;&nbsp;<?php echo  $v['shop_intro'];?>
							</td>
							<td align="center">
							 <?php if($v['lock_flg']=='1') {;?>
								 	<font color='red'><?php echo  $m_langpackage->m_other_shop_lock;?></font><br />
							 <?php }?>
							 <?php if($v['open_flg']=='1') {;?>
								 	<font color='red'><?php echo  $m_langpackage->m_other_shop_close;?></font><br />
							 <?php }?>
								<a href="do.php?act=user_shopfavorite_del&id=<?php echo  $v['favorite_id'];?>" onclick="return confirm('<?php echo  $m_langpackage->m_suredel_favorite;?>');"><?php echo  $m_langpackage->m_del;?></a><br />
							</td>
						</tr>
						<?php }?>
						<tr>
							<td colspan="4" class="textleft">
								
								<INPUT class="submit" type="submit" value="<?php echo $m_langpackage->m_pl_del;?>" name="deletesubmit" />
							</td>
						</tr>
						<tr><td colspan="4" ><div class="page"><?php  require("modules/page.php");?></div></td></tr>
						<?php  } else {?>
						<tr><td colspan="4" class="center"><?php echo  $m_langpackage->m_nolist_record;?></td></tr>
						<?php }?>
					</table>
				  </form>
                  </div>
				</div>
				<div class="clear"></div>
				<div class="right_bottom"></div>
				<div class="back_top"><a href="#"></a></div>
			</div>
	</form>
<?php  require("shop/index_footer.php");?>
<script language="JavaScript">
<!--
function change_style(flag) {
	if (flag =='style1'){
		document.getElementById('style1').className="current";
		document.getElementById('style2').className="";
		document.getElementById('display_order').style.display="block";
		document.getElementById('display_favorite').style.display="none";

	}
	if (flag =='style2'){
		document.getElementById('style1').className="";
		document.getElementById('style2').className="current";
		document.getElementById('display_order').style.display="none";
		document.getElementById('display_favorite').style.display="block";
	}
}

//-->
</script>

</body>
</html><?php } ?>