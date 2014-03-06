<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/shop/guestbook.html
 * 如果您的模型要进行修改，请修改 models/modules/shop/guestbook.php
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
if(filemtime("templates/default/modules/shop/guestbook.html") > filemtime(__file__) || (file_exists("models/modules/shop/guestbook.php") && filemtime("models/modules/shop/guestbook.php") > filemtime(__file__)) ) {
	tpl_engine("default","modules/shop/guestbook.html",1);
	include(__file__);
} else {
/* debug模式运行生成代码 结束 */
?><?php
if(!$IWEB_SHOP_IN) {
	trigger_error('Hacking attempt');
}

require("foundation/acheck_shop_creat.php");
require("foundation/module_guestbook.php");
require("foundation/module_shop.php");
//引入语言包
$m_langpackage=new moduleslp;
$i_langpackage=new indexlp;
$s_langpackage=new shoplp;
//数据表定义区
$t_shop_guestbook = $tablePreStr."shop_guestbook";
$t_shop_info = $tablePreStr."shop_info";
$t_users = $tablePreStr."users";
//读写分离定义方法
$dbo = new dbex;
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
$state = intval(get_args('state'));
$result = shop_guestbook_list($dbo,$t_shop_guestbook,$shop_id,13,$state);
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
</script>
</head>
<body onload="menu_style_change('shop_guestbook');changeMenu();">

	<?php  require("shop/index_header.php");?>
	<div class="site_map">
	  <?php echo $m_langpackage->m_current_position;?><A href="index.php"><?php echo $SYSINFO['sys_name'];?></A>/<a href="modules.php"><?php echo $m_langpackage->m_u_center;?></a>/&nbsp;&nbsp;<?php echo $m_langpackage->m_rc_guestbook;?>
	</div>
    <div class="clear"></div>
    	<?php  require("modules/left_menu.php");?>
        <div class="main_right">
        	<div class="right_top"></div>
            <div class="cont">
                <div class="cont_title"><?php echo  $m_langpackage->m_rc_guestbook;?></div>
                <hr />
<form action="do.php?act=shop_guestbook_del" name="form" method="post" onsubmit="return submitform();">                
				<table width="98%" class="form_table">
					<tr class="center"><th width="20"><input type="checkbox" onclick="checkall(this);" /></th>
						<th width="80"><?php echo  $m_langpackage->m_name;?></th>
						<th width="80"><?php echo  $m_langpackage->m_add_time;?></th>
                        <th width="80"><?php echo  $m_langpackage->m_my_write_back;?></th>
						<th width="50"><?php echo  $m_langpackage->m_status;?></th>
						<th width="80"><?php echo  $m_langpackage->m_manage;?></th></tr>
					<?php 
					if(!empty($result['result'])) {
						foreach($result['result'] as $v) {?>
						<?php if($v['group_id']) {?>
							<tr class="center">
								<td><input type="checkbox" name="guest[]" value="<?php echo  $v['gid'];?>" /></td>
								<td class="center">[<?php echo  $m_langpackage->m_group_buy;?>:<a href="goods.php?id=<?php echo $v['goods_id'];?>&app=groupbuyinfo&groupid=<?php echo $v['group_id'];?>"><?php echo  $v['group_name'];?></a>]<br /><?php echo  $v['name'];?></td>
								<td class="center"><?php echo  substr($v['add_time'],0,16);?></td>
								<td class="center"><?php echo  sub_str($v['reply'],15);?></td>
								<td class="center">
									<?php if($v['read_status']) {?>
										<?php echo  $m_langpackage->m_read;?>
									<?php  } else {?>
										<?php echo  $m_langpackage->m_unread;?>
									<?php }?>
								</td>
								<td class="center"><a href="do.php?act=shop_guestbook_del&id=<?php echo  $v['gid'];?>"
									onclick="return confirm('<?php echo  $m_langpackage->m_suredel_guestbook;?>');"><?php echo  $m_langpackage->m_del;?></a>
									<a href="modules.php?app=shop_seller_r&id=<?php echo  $v['gid'];?>" ><?php echo  $m_langpackage->m_write_back;?></a>
									<a href="modules.php?app=shop_seller_r&id=<?php echo  $v['gid'];?>" ><?php echo  $m_langpackage->m_view;?></a>
									
								</td>
							</tr>
						<?php  } else {?>
							<tr class="center">
								<td><input type="checkbox" name="guest[]" value="<?php echo  $v['gid'];?>" /></td>
								<td class="center"><?php echo  $v['name'];?></td>
								<td class="center"><?php echo  substr($v['add_time'],0,16);?></td>
								<td class="center"><?php echo  sub_str($v['reply'],15);?></td>
								<td class="center">
									<?php if($v['read_status']) {?>
										<?php echo  $m_langpackage->m_read;?>
									<?php  } else {?>
										<?php echo  $m_langpackage->m_unread;?>
									<?php }?>
								</td>
								<td class="center"><a href="do.php?act=shop_guestbook_del&id=<?php echo  $v['gid'];?>"
									onclick="return confirm('<?php echo  $m_langpackage->m_suredel_guestbook;?>');"><?php echo  $m_langpackage->m_del;?></a>
									<a href="modules.php?app=shop_seller_r&id=<?php echo  $v['gid'];?>" ><?php echo  $m_langpackage->m_write_back;?></a>
									<a href="modules.php?app=shop_seller_r&id=<?php echo  $v['gid'];?>" ><?php echo  $m_langpackage->m_view;?></a>
								</td>
							</tr>
					    <?php }?>
					    
					<?php }?>
					<tr><td colspan="6" class="page"><?php  require("modules/page.php");?></td></tr>
					<tr><td colspan="6"><INPUT class="submit" type="submit" value="<?php echo $m_langpackage->m_pl_del;?>" name="deletesubmit" /> </td></tr>
					<?php  } else {?>
					<tr><td colspan="6" class="center"><?php echo  $m_langpackage->m_nolist_record;?></td></tr>
					<?php }?>
				</table>
</form>				
			</div>
			<div class="right_bottom"></div>
			<div class="back_top"><a href="#"></a></div>
		</div>
	</div>
<div class="clear"></div>
<?php  require("shop/index_footer.php");?>

</body>
</html><?php } ?>